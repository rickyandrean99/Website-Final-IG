<?php

namespace App\Http\Controllers;
use App\Product;
use App\Team;
use App\MachineType;
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

        // var_dump($productions_id);
        // var_dump($productions_amount);
        // var_dump($productions_machine);
        // var_dump($productions_team_machine);

        // Cek apakah inventory produk dapat menyimpan produk yang bisa dibuat ini
        $inventory_amount = $team->products->sum('pivot.amount');
        if ((array_sum($productions_amount) + $inventory_amount) <= $team->product_inventory) {
            // Cek apakah bahan baku cukup untuk melakukan proses produksi
            
            foreach($productions_id as $index => $id) {
                $product = Product::find($id);
                $amount = $productions_amount[$index];

                $ingredient_requirement = $product->ingredients();

                var_dump($ingredient_requirement);

                break;
            }
            

            $status = "";
            $message = "";
        } else {
            $status = "failed";
            $message = "Sudah melebihi";
        }
        
        return response()->json(array(
            'status' => $status,
            'message' => $message
        ), 200);
    }
}
