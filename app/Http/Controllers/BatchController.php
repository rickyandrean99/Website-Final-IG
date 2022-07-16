<?php

namespace App\Http\Controllers;

use DB;
use App\Team;
use App\Batch;
use App\Transportation;
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

        // Jika Batch 6, Potong saldonya yang belum bayar
        if ($batch->batch == 6) {
            $hutang = 25000;
            for($i = 1; $i <= $batch->batch; $i++) $hutang += (0.05 * $hutang);

            $teams = Team::all();
            foreach($teams as $team) {
                if ($team->debt_paid == 0) {
                    $team->decrement('balance', $hutang);
                    $team->debt_paid = 6;
                    $team->save();
                }
            }
        }
        
        // Reset Limit
        DB::table('teams')->update([
            'upgrade_machine_limit' => 4,
            'upgrade_ingredient_limit' => 1,
            'upgrade_product_limit' => 1,
        ]);
        DB::table('team_machine')->update(['is_upgrade' => 0]);
        
        // Bayar Sewa Inventory
        $teams = Team::all();
        foreach($teams as $team) {
            $rent_price = $team->inventory_ingredient_rent + $team->inventory_product_rent;
            $interest = 0.07 * $team->debt;
            $team->decrement('balance', $rent_price);
            $team->increment('debt', $interest);
        }

        // Transportasi lewat 5 batch, langsung jual otomatis
        $team_transportation = DB::table('team_transportation')->get();
        foreach($team_transportation as $transport){
            if (($batch->batch - $transport->batch >= 5) && $transport->exist) {
                // Hapus transport
                DB::table('team_transportation')
                ->where('teams_id', $transport->teams_id)
                ->where('transportations_id', $transport->transportations_id)
                ->where('id', $transport->id)
                ->update(["exist" => 0]);

                // Tambah saldo
                $team = Team::find($transport->teams_id);
                $team->balance = $team->balance + Transportation::find($transport->transportations_id)->residual_price;
                $team->save();
            }
        }

        // Mesin lewat 5 batch, langsung jual otomatis
        $team_machine = DB::table('team_machine')->get();
        foreach($team_machine as $machine){
            if (($batch->batch - $machine->batch >= 5) && $machine->exist) {
                // Hapus machine
                DB::table('team_machine')
                ->where('teams_id', $machine->teams_id)
                ->where('machine_types_id', $machine->machine_types_id)
                ->where('id', $machine->id)
                ->update(["exist" => 0]);

                // Tambah saldo
                $team = Team::find($machine->teams_id);
                $team->balance = $team->balance + MachineType::find($machine->machine_types_id)->residual_price;
                $team->save();
            }
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
                // Hapus produk
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

        return response()->json(array(
            'status' => 'success',
            'message' => "Berhasil update preparation"
        ), 200);
    }
}
