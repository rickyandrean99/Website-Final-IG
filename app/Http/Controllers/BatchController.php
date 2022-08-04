<?php

namespace App\Http\Controllers;

use DB;
use App\Team;
use App\Batch;
use App\Demand;
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

        return view('update-batch');
    }

    public function updateBatch() {
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        }
        // Update batch dan preparation
        $batch = Batch::find(1);
        $batch->batch = $batch->batch + 1;
        $batch->preparation = 0;
        $batch->save();

        // Reset Limit
        DB::table('teams')->update([
            'upgrade_machine_limit' => 5,
            'upgrade_ingredient_limit' => 1,
            'upgrade_product_limit' => 1,
            'debt_batch' => 0,
        ]);
        DB::table('team_machine')->update(['is_upgrade' => 0]);
        
        // Bayar Sewa Inventory & Tambah bunga hutang
        $teams = Team::all();
        $batch1 = Batch::find(1)->batch;
        $ongkir = Package::find($batch1)->fee;

        foreach($teams as $team) {
            $rent_price = $team->inventory_ingredient_rent + $team->inventory_product_rent;
            $interest = 0.05 * $team->debt;
            $team->decrement('balance', $rent_price);
            $team->increment('debt', $interest);

            //tambah history fee
            DB::table('histories')->insert([
                "teams_id" => $team->id,
                "kategori" => "FEE",
                "batch" => $batch1,
                "type" => "OUT",
                "amount" => $rent_price,
                "keterangan" => "Biaya simpan inventory bahan baku & produk sejumlah ".$rent_price." TC"
            ]);

            //pusher update batch
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
                        DB::table('ingredient_inventory')
                        ->where('teams_id', $team->id)
                        ->where('ingredients_id', $ingredient->id)
                        ->update(['amount'=>0]);
                    }
                }
            }
        }

        // Buang produk yang melewati 2 batch
        $product_inventory = DB::table('product_inventory')->get();
        foreach($product_inventory as $inventory){
            if ($batch->batch - $inventory->batch >= 2) {
                DB::table('product_inventory')
                ->where('teams_id', $inventory->teams_id)
                ->where('products_id', $inventory->products_id)
                ->where('batch', $inventory->batch)
                ->update(["amount" => 0]);
            }
        }

        //pusher ke demand
        $demands = DB::table('product_demand')->join('products', 'products.id', '=', 'product_demand.products_id')->where('demands_id', $batch->batch)->where('amount', '!=', 0)->get();
        event(new UpdateDemand($demands, $batch->batch));

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
        $batch->save();
        
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
        foreach ($teams as $team) {
            $profit = self::calculateProfit($team, $batch->batch);
            $market_share = self::calculatePangsaPasar($team, $batch->batch);

            $team->rounds()->wherePivot('rounds_id', $batch->batch)->update([
                'profit' => $profit,
                'market_share' => $market_share
            ]);

            event(new UpdatePreparation($team->id, $profit, $market_share));
        }

        return response()->json(array(
            'status' => 'success',
            'message' => "Berhasil update preparation"
        ), 200);
    }
    
    public function calculateProfit($team, $batch) {
        // PROFIT VERSI 1.0
        // // Hitung hasil penjualan
        // $hasil_penjualan = (int)($team->transactions()->where("batch", $batch)->sum("subtotal"));
        
        // // Hitung harga pokok produksi
        // $ingredients_price = $team->histories()->where("batch", $batch)->where("kategori", "INGREDIENT")->sum("amount");
        // $current_transportations = $team->transportations()->where("batch", $batch)->where("exist", 1)->sum("price");
        // $current_machines = $team->machineTypes()->where("batch", $batch)->where("exist", 1)->sum("price");
        // $previously_transportation = DB::table("team_transportation")->join("transportations", "transportations.id", "=", "team_transportation.transportations_id")->where('teams_id', $team->id)->where("batch", "<", $batch)->where("exist", 1)->select(DB::raw('sum((price - residual_price)/5) AS total'))->first();
        // $previously_machines = DB::table("team_machine")->join("machine_types", "machine_types.id", "=", "team_machine.machine_types_id")->where('teams_id', $team->id)->where("batch", "<", $batch)->where("exist", 1)->select(DB::raw('sum((price - residual_price)/5) AS total'))->first();
        
        // $harga_pokok_produksi = (int)($ingredients_price + $current_transportations + $current_machines + $previously_transportation->total + $previously_machines->total);

        // return ($hasil_penjualan - $harga_pokok_produksi);

        // ----------------------------------------------

        // PROFIT VERSI 2.0
        // 1. Beli (transport + mesin + bahan baku)
        $ingredients_price = $team->histories()->where("batch", $batch)->where("kategori", "INGREDIENT")->sum("amount");
        $transportations_price = $team->transportations()->where("batch", $batch)->where("exist", 1)->sum("price");
        $machines_price = $team->machineTypes()->where("batch", $batch)->where("exist", 1)->sum("price");
        $total_pengeluaran = (int)($ingredients_price + $transportations_price + $machines_price);
        // 2. Upgrade (mesin + kulkas + inventory + sertifikasi)
        $total_pengeluaran2 = (int)$team->histories()->where("batch", $batch)->where("kategori", "UPGRADE")->sum("amount");

        // 3. Hasil jual produk - Denda ruang kosong - Biaya kirim
        $hasil_penjualan = (int)($team->transactions()->where("batch", $batch)->sum("subtotal"));
        // 4. Hasil jual UMKM - Denda pemerintah
        $hasil_penjualan2 = (int)($team->histories()->where("batch",$batch)->where("kategori","PRODUCTION")->sum("amount"));

        return ($hasil_penjualan + $hasil_penjualan2 - $total_pengeluaran - $total_pengeluaran2);
    }

    public function calculatePangsaPasar($team, $batch) {
        //kalkulasi total penjualan semua tim
        $sales_total = Transaction::where("batch", $batch)->sum("subtotal");
            
        //Kalkulasi total penjualan tim
        $sales_team = $team->transactions()->where("batch", $batch)->sum("subtotal");
            
        //Market share = penjualan tim / penjualan keseluruhan tim
        if ($sales_total != 0) {
            return ($sales_team/$sales_total);
        }

        return (0);
    }
}
