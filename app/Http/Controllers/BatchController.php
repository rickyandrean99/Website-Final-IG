<?php

namespace App\Http\Controllers;

use DB;
use App\Team;
use App\Batch;
use App\Demand;
use App\Events\SendTransactionCoin;
use App\Transportation;
use App\Transaction;
use App\MachineType;
use App\Ingredient;
use App\Package;
use App\Events\UpdateBatch;
use App\Events\UpdateDemand;
use App\Events\UpdateImport;
use App\Events\UpdatePreparation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index(){
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        }

        $transaction = Transaction::where('received', 0)->get();

        return view('update-batch', compact('transaction'));
    }

    public function updateBatch() {
        if (Auth::user()->role == "peserta") {
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        }

        // Update batch, preparation, dan timer
        $batch = Batch::find(1);
        if ($batch->batch == 1 && $batch->is_start == 0) {
            $batch->is_start = 1;
        } else {
            $batch->batch = $batch->batch + 1;
            $batch->preparation = 0;
        }
        $time = Carbon::now()->format('Y-m-d H:i:s');
        $new_timer = Carbon::parse($time)->addMinutes(20)->addSeconds(3)->format('Y-m-d H:i:s');
        $batch->time = $new_timer;
        $batch->save();

        // Reset Limit
        DB::table('teams')->update([
            'upgrade_machine_limit' => 5,
            'upgrade_ingredient_limit' => 1,
            'upgrade_product_limit' => 1,
            'debt_batch' => 0,
        ]);
        DB::table('team_machine')->update(['is_upgrade' => 0]);
        
        // Bayar Sewa Inventory, Tambah bunga hutang, Cek Maintenance, History Fee
        $teams = Team::all();
        $batch1 = Batch::find(1)->batch;
        $ongkir = Package::find($batch1)->fee;
        foreach($teams as $team) {
            $interest = 0.05 * $team->debt;
            $team->increment('debt', $interest);

            // Cek Maintenance
            if ($batch1 == 4) {
                if ($team->certification_maintenance) {
                    $team->maintenance_time = Carbon::parse($time)->addMinutes(3)->format('Y-m-d H:i:s');
                } else {
                    $team->maintenance_time = Carbon::parse($time)->addMinutes(5)->format('Y-m-d H:i:s');
                }
            }
            $team->save();

            // pusher update batch
            $limit = ($team->packages()->wherePivot('packages_id', $batch->batch)->select('remaining')->first())->remaining;
            event(new UpdateBatch($team->id, $batch->batch, $team->balance, $limit, $ongkir));
        }

        // Realtime Ingredient
        $ingredients = DB::table("ingredients")->join("local_ingredient", "local_ingredient.ingredients_id", "=", "ingredients.id")->select("ingredients.id AS id", "local_ingredient.amount AS amount",)->where("local_ingredient.rounds_id", $batch->batch)->get();
        event(new UpdateImport($ingredients));

        // Buang bahan milik tim yang tidak memiliki kulkas
        $teams = Team::all();
        foreach($teams as $team) {
            if(!$team->fridge){
                $ingredients = Ingredient::all();
                foreach($ingredients as $ingredient) {
                    if($ingredient->is_fruit) {
                        DB::table('ingredient_inventory')->where('teams_id', $team->id)->where('ingredients_id', $ingredient->id)->update(['amount'=>0]);
                    }
                }
            }
        }

        //pusher ke demand
        $demands = DB::table('product_demand')->join('products', 'products.id', '=', 'product_demand.products_id')->where('demands_id', $batch->batch)->where('amount', '!=', 0)->get();
        $price = [];
        foreach($demands as $demand){
            $p = DB::table('product_batchs')->where('id', $batch1)->where('products_id',$demand->id)->sum('price');
            array_push($price, $p);
        }
        event(new UpdateDemand($demands, $batch->batch, $price, $new_timer));

        return response()->json(array(
            'status' => 'success',
            'message' => "Batch berhasil di update!"
        ), 200);
    }

    public function updatePreparation() {
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        }
        
        $batch = Batch::find(1);
        $batch->preparation = 1;
        $time = Carbon::now()->format('Y-m-d H:i:s');
        $new_timer = Carbon::parse($time)->addMinutes(2)->addSeconds(3)->format('Y-m-d H:i:s');
        $batch->time = $new_timer;
        $batch->save();

        //pusher ke demand
        $demands = DB::table('product_demand')->join('products', 'products.id', '=', 'product_demand.products_id')->where('demands_id', $batch->batch)->where('amount', '!=', 0)->get();
        $price = [];
        foreach($demands as $demand){
            $p = DB::table('product_batchs')->where('id', $batch->batch)->where('products_id',$demand->id)->sum('price');
            array_push($price, $p);
        }
        event(new UpdateDemand($demands, $batch->batch, $price, $new_timer));
        
        // Jika Batch 5 (selesai game), Potong saldonya yang belum bayar
        if ($batch->batch == 5) {
            $teams = Team::all();
            foreach($teams as $team) {
                if ($team->debt > 0) {
                    //tambah history fee
                    DB::table('histories')->insert([
                        "teams_id" => $team->id,
                        "kategori" => "DEBT",
                        "batch" => $batch->batch,
                        "type" => "OUT",
                        "amount" => $team->debt,
                        "keterangan" => "Membayar hutang sejumlah ".$team->debt." TC"
                    ]);

                    $team->decrement('balance', $team->debt);
                    $team->debt = 0;
                    $team->save();
                }
            }
        }

        $teams = Team::all();

        // kalkulasi total penjualan semua tim
        $sales_total = 0;
        $get = DB::table('transactions')->where('batch', $batch->batch)->get();
        foreach($get as $trans){
            $amount = DB::table('product_transaction')->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->sum('amount');
            $sales_total += $amount;
        }

        foreach ($teams as $team) {
            // Inventory Fee
            $rent_price = $team->inventory_ingredient_rent + $team->inventory_product_rent;
            $team->decrement('balance', $rent_price);
            DB::table('histories')->insert([
                "teams_id" => $team->id,
                "kategori" => "FEE",
                "batch" => $batch->batch,
                "type" => "OUT",
                "amount" => $rent_price,
                "keterangan" => "Biaya simpan inventory bahan baku & produk sejumlah ".$rent_price." TC"
            ]);

            // Komponen Penilaian
            $profit = self::calculateProfit($team, $batch->batch);
            $market_share = self::calculatePangsaPasar($team, $batch->batch, $sales_total);
            $team->rounds()->wherePivot('rounds_id', $batch->batch)->update([
                'profit' => $profit,
                'market_share' => $market_share
            ]);

            event(new UpdatePreparation($team->id, $profit, $market_share, $rent_price));
        }

        return response()->json(array(
            'status' => 'success',
            'message' => "Berhasil update preparation"
        ), 200);
    }

    public function sendTC(Request $request){
        $amount = Transaction::find($request->trans_id)->total;
        $team_id = Transaction::find($request->trans_id)->teams_id;
        
        // Update balance team + ubah 'received'
        Team::find($team_id)->increment('balance', $amount);
        Transaction::find($request->trans_id)->increment('received');

        $balance = Team::find($team_id)->balance;
        $batch = Batch::find(1)->batch;

        // Menambahkan Histori
        DB::table('histories')->insert([
            "teams_id" => $team_id,
            "kategori" => "PENJUALAN",
            "batch" => $batch,
            "type" => "IN",
            "amount" => $amount,
            "keterangan" => "Berhasil mendapatkan coin sejumlah ".$amount." TC dari hasil penjualan"
        ]);

        // Push balance terbaru ke dashboard TO
        event(new SendTransactionCoin($team_id, $balance, $amount));

        return response()->json(array(
            'status' => 'success',
            'message' => "Berhasil mengirim TC"
        ), 200);
    }
    
    public function calculateProfit($team, $batch) {
        // 1. Beli (transport + mesin + bahan baku)
        $ingredients_price = $team->histories()->where("batch", $batch)->where("kategori", "INGREDIENT")->sum("amount");
        $transportations_price = $team->transportations()->where("batch", $batch)->where("exist", 1)->sum("price");
        $machines_price = $team->machineTypes()->where("batch", $batch)->where("exist", 1)->sum("price");
        $total_pengeluaran = (int)($ingredients_price + $transportations_price + $machines_price);
        
        // 2. Upgrade (mesin + kulkas + inventory + sertifikasi)
        $total_pengeluaran2 = (int)($team->histories()->where("batch", $batch)->where("kategori", "UPGRADE")->sum("amount"));

        // 3. Hasil jual produk - Denda ruang kosong - Biaya kirim
        $hasil_penjualan = (int)($team->transactions()->where("batch", $batch)->sum("total"));
        
        // 4. Hasil jual UMKM - Denda pemerintah
        $hasil_penjualan2 = (int)($team->histories()->where("batch",$batch)->where("kategori","PRODUCTION")->sum("amount"));

        return ($hasil_penjualan + $hasil_penjualan2 - $total_pengeluaran - $total_pengeluaran2);
    }

    public function calculatePangsaPasar($team, $batch, $sales_total) {
        // Kalkulasi total penjualan tim
        $get = DB::table('transactions')->where('teams_id', $team->id)->where('batch', $batch)->get();
        $sales_team = 0;
        foreach($get as $trans){
            $amount = DB::table('product_transaction')->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->sum('amount');
            $sales_team += $amount;
        }            
        
        // Market share = penjualan tim / penjualan keseluruhan tim
        if ($sales_total != 0) {
            return ($sales_team/$sales_total);
        }

        return (0);
    }
}
