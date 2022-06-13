<?php

namespace App\Http\Controllers;
use App\Product;
use App\Team;
use App\MachineType;
use App\Ingredient;
use Auth;

use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function addProduction(Request $request) {
        $team_id = Auth::user()->team;
        $team = Team::find($team_id);
        $products = Product::all();

        $product = Product::find(1);
        $ingredient_requirement = $product->ingredients;
        $machine_requirement = $product->machines;

        // Ambil ID dari machine
        $machines_id = [];
        foreach($machine_requirement as $key => $value) {
            array_push($machines_id, $value->id);
        }
        
        // Ambil ID dari machine type
        $machine_type_list = MachineType::whereIn('machines_id', $machines_id)->get();
        $machine_types_id = [];
        foreach($machine_type_list as $key => $value) {
            array_push($machine_types_id, $value->id);
        }

        $team_machines = $team->machineTypes()->wherePivotIn('machine_types_id', $machine_types_id)->wherePivot('exist', '1')->get();

        return response()->json(array(
            'status'=> "success",
            'products' => $products,
            'ingredients' => $ingredient_requirement,
            'machines' => $machine_requirement,
            'team_machine' => $team_machines
        ), 200);
    }

    public function changeProduction(Request $request) {
        $team_id = Auth::user()->team;
        $team = Team::find($team_id);
        $id_product = $request->get('id');

        $product = Product::find($id_product);
        $ingredient_requirement = $product->ingredients;
        $machine_requirement = $product->machines;

        // Ambil ID dari machine
        $machines_id = [];
        foreach($machine_requirement as $key => $value) {
            array_push($machines_id, $value->id);
        }
        
        // Ambil ID dari machine type
        $machine_type_list = MachineType::whereIn('machines_id', $machines_id)->get();
        $machine_types_id = [];
        foreach($machine_type_list as $key => $value) {
            array_push($machine_types_id, $value->id);
        }

        $team_machines = $team->machineTypes()->wherePivotIn('machine_types_id', $machine_types_id)->wherePivot('exist', '1')->get();

        return response()->json(array(
            'status'=> "success",
            'ingredients' => $ingredient_requirement,
            'machines' => $machine_requirement,
            'team_machine' => $team_machines
        ), 200);
    }

    public function startProduction(Request $request) {
        $team_id = Auth::user()->team;
        $team = Team::find($team_id);
        $productions_id = $request->get('production_id');
        $productions_amount = $request->get('production_amount');
        $productions_machine = $request->get('production_machine');
        $productions_team_machine = $request->get('production_team_machine');

        // Cek apakah inventory produk dapat menyimpan produk yang bisa dibuat ini
        // [NOTE: Mending setelah diproduksi saja cek bisa ditampung apa gak, karena produksi kan bisa mengurangi jumlah jadinya]
        $inventory_amount = $team->products->sum('pivot.amount');
        if ((array_sum($productions_amount) + $inventory_amount) <= $team->product_inventory) {
            // Cek jumlah bahan baku keseluruhan yang diperlukan
            $ingredients_need = [];
            $ingredient_list = Ingredient::all();

            foreach($ingredient_list as $ingredient) {
                $ingredients_need[$ingredient->id] = 0.0;
            }
            
            foreach($productions_id as $index => $id) {
                $product = Product::find($id);
                foreach($product->ingredients as $ingredient) {
                    $ingredients_need[$ingredient->id] = $ingredient->pivot->amount * $productions_amount[$index];
                }
            }

            // Cek apakah tim memiliki sejumlah bahan baku yang diperlukan
            $sufficient_stock = true;
            foreach($ingredients_need as $id => $amount) {
                if ($amount == 0) continue;

                $stock = $team->ingredients()->wherePivot('ingredients_id', $id)->first();
                if ($stock != null) {
                    if ($stock->pivot->amount < $amount) {
                        $sufficient_stock = false;
                        break;
                    }
                } else {
                    $sufficient_stock = false;
                    break;
                }
            }

            if ($sufficient_stock) {
                // Lakukan proses produksi
                foreach($productions_id as $index => $id) {
                    $product = Product::find($id);
                    $product_machine = $productions_machine[$index];
                    $product_team_machine = $productions_team_machine[$index];

                    // Kurangi jumlah bahan baku
                    foreach($ingredients_need as $id => $amount){
                        $team->ingredients()->wherePivot('ingredients_id', $id)->decrement('ingredient_inventory.amount', $amount);
                    }

                    // Cari Jumlah Produk jadi dengan rumus defact dari mesin yang digunakan
                    $machines_id = [];
                    foreach($product->machines()->orderBy('order', 'ASC')->get() as $machine){
                        array_push($machines_id, $machine->pivot->machines_id);
                    }

                    $m_id = implode(',', $machines_id);
                    $machines_need = MachineType::whereIn('machines_id', $machines_id)->orderByRaw("FIELD(machines_id, $m_id)")->get();
                    
                    foreach($machines_need as $machine_need){
                        $machine_team_used = $machine_need->teams()->wherePivot('teams_id', $team_id)->get();
                        var_dump($machine_team_used[0]->defact);
                    }

                    // Tambah Produk Jadi ke Inventori
                    //
                }

                $status = "success";
                $message = "Belum melebihi";
            } else {
                $status = "failed";
                $message = "Bahan baku tidak mencukupi";
            }
        } else {
            $status = "failed";
            $message = "Produk inventori tidak mencukupi";
        }
        
        return response()->json(array(
            'status' => $status,
            'message' => $message
        ), 200);
    }
}
