<?php

namespace App\Http\Controllers;

use DB;
use App\Team;
use App\Batch;
use App\Transportation;
use App\Transaction;
use App\MachineType;
use App\Ingredient;
use Illuminate\Http\Request;
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
        }

        return view('update-batch');
    }

    public function updateBatch() {
        // Update batch dan preparation
        $batch = Batch::find(1);
        $batch->batch = $batch->batch + 1;
        $batch->preparation = 0;
        $batch->save();

        // Jika Batch 6 (selesai game), Potong saldonya yang belum bayar
        if ($batch->batch == 6) {
            $teams = Team::all();
            foreach($teams as $team) {
                if ($team->debt > 0) {
                    $team->decrement('balance', $team->debt);
                    $team->debt = 0;
                    $team->save();
                }
            }
        }
        
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
        foreach($teams as $team) {
            $rent_price = $team->inventory_ingredient_rent + $team->inventory_product_rent;
            $interest = 0.05 * $team->debt;
            $team->decrement('balance', $rent_price);
            $team->increment('debt', $interest);
        }

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

        return response()->json(array(
            'status' => 'success',
            'message' => "Batch berhasil di update!"
        ), 200);
    }

    public function updatePreparation() {
        $batch = Batch::find(1);
        $batch->preparation = 1;
        $batch->save();
        
        $teams = Team::all();
        foreach ($teams as $team) {
            $profit = self::calculateProfit($team, $batch->batch);
            $market_share = self::calculatePangsaPasar($team, $batch->batch);
            $six_sigma = self::calculateSigma($team, $batch->batch);

            $team->rounds()->attach($batch->batch, [
                'profit' => $profit,
                'market_share' => $market_share,
                'six_sigma' => $six_sigma,
            ]);
        }

        return response()->json(array(
            'status' => 'success',
            'message' => "Berhasil update preparation"
        ), 200);
    }
    
    public function calculateProfit($team, $batch) {
        // Hitung hasil penjualan
        $hasil_penjualan = $team->transactions()->where("batch", $batch)->sum("subtotal");
        
        // Hitung harga pokok produksi
        $ingredients_price = $team->histories()->where("batch", $batch)->where("kategori", "INGREDIENT")->sum("amount");
        $current_transportations = $team->transportations()->where("batch", $batch)->where("exist", 1)->sum("price");
        $current_machines = $team->machineTypes()->where("batch", $batch)->where("exist", 1)->sum("price");
        $previously_transportation = $team->transportations()->where("batch", "<", $batch)->where("exist", 1)->sum("residual_price");
        $previously_machines = $team->machineTypes()->where("batch", "<", $batch)->where("exist", 1)->sum("residual_price");
        $harga_pokok_produksi = $ingredients_price + $current_transportations + $current_machines + $previously_transportation + $previously_machines;

        return ($hasil_penjualan - $harga_pokok_produksi);
    }


    public function calculatePangsaPasar($team, $batch) {
        //kalkulasi total penjualan semua tim
        $sales_total = Transaction::where("batch", $batch)->sum("subtotal");
            
        //Kalkulasi total penjualan tim
        $sales_team = $team->transactions()->where("batch", $batch)->sum("subtotal");
            
        //Market share = penjualan tim / penjualan keseluruhan tim
        return ($sales_team/$sales_total);
    }

    public function calculateSigma() {
        return 0;
    }
}
