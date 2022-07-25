<?php

namespace App\Http\Controllers;
use App\Product;
use App\Team;
use App\Batch;
use App\MachineType;
use App\Ingredient;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $batch = Batch::find(1)->batch;
        $productions_id = $request->get('production_id');
        $productions_amount = $request->get('production_amount');
        $productions_machine = $request->get('production_machine');
        $productions_team_machine = $request->get('production_team_machine');
        $apple_need = [1=>0,2=>0,3=>0];
        $total_defact = 0.0;
        $sigma_produk = [];
        $defact_array = array(450060, 200020, 140030, 8805, 3356, 134);
        $defective_product = [];

        try {
            $ingredients_need = [];
            $ingredient_list = Ingredient::all();

            // Mapping Ingredient Need, set default 0
            foreach($ingredient_list as $ingredient) {
                $ingredients_need[$ingredient->id] = 0.0;
            }

            // Cek jumlah bahan baku keseluruhan yang diperlukan
            foreach($productions_id as $index => $id) {
                $product = Product::find($id);
                foreach($product->ingredients as $ingredient) {
                    $ingredients_need[$ingredient->id] = $ingredient->pivot->amount * $productions_amount[$index];
                    
                    if ($ingredient->id == 2 && in_array($id, [1,2,3])) {
                        $apple_need[$id] = $ingredient->pivot->amount * $productions_amount[$index];
                    }
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

            // Pengecekan apakah bahan baku cukup
            if ($sufficient_stock) {
                // Array untuk menyimpan daftar produk jadi. Key berupa idproduk dengan valuenya berupa jumlah produk yang dihasilkan (sudah dikali 10)
                $product_total_amount = [];

                // Lakukan proses produksi
                foreach($productions_id as $index => $id) {
                    $product = Product::find($id);
                    $product_amount = $productions_amount[$index]*10;
                    $product_machine = $productions_machine[$index];
                    $product_team_machine = $productions_team_machine[$index];
                    $machine_input = [];
                    $total_defact = 0.0;

                    // Buat 2d array dengan indexnya yaitu machineTypeId dan valuenya team_machine pivot id
                    foreach($product_machine as $index => $value) {
                        $machine_input[$value] = $product_team_machine[$index];
                    }

                    // Cari id dari machine yang sudah di order
                    $machines_id = [];
                    foreach($product->machines()->orderBy('order', 'ASC')->get() as $machine){
                        array_push($machines_id, $machine->pivot->machines_id);
                    }

                    // Cari daftar machine type berdasarkan id machine yang sudah di order
                    $m_id = implode(',', $machines_id);
                    $machines_need = MachineType::whereIn('machines_id', $machines_id)->orderByRaw("FIELD(machines_id, $m_id)")->get();

                    // Eliminasi machine type berdasarkan dengan yang tim punya dan simpan defactnya berdasarkan machinetype dan id pivot keberapa
                    $ordered_machines = [];
                    foreach($machines_need as $machine_need){
                        $machine_team_used = $machine_need->teams()->wherePivot('teams_id', $team_id)->wherePivot('exist', '1')->get();

                        if ($machine_team_used != null) {
                            foreach($machine_team_used as $mtu){
                                $ordered_machines[$mtu->pivot->machine_types_id][$mtu->pivot->id]["defact"] = $mtu->pivot->defact;
                                $ordered_machines[$mtu->pivot->machine_types_id][$mtu->pivot->id]["capacity"] = MachineType::find($mtu->pivot->machine_types_id)->capacity;
                            }
                        }
                    }

                    // Mengurutkan machine, kemudian simpan capacity dan defactnya
                    $machine_process = [];
                    foreach($ordered_machines as $id_machine_type => $machine_type_team){
                        foreach($machine_type_team as $mtt_id => $value){
                            foreach($machine_input as $machine_type_selected => $machine_type_team_selected){
                                if ($id_machine_type == $machine_type_selected & $mtt_id == $machine_type_team_selected) {
                                    $machine = [];
                                    $machine["machinetype"] = $id_machine_type;
                                    $machine["id"] = $mtt_id;
                                    $machine["capacity"] = $value["capacity"];
                                    $machine["defact"] = $value["defact"];
                                    $total_defact += $value["defact"];

                                    array_push($machine_process, $machine);
                                    break 2;
                                }
                            }
                        }
                    }

                    // Perhitungan sigma produksi
                    $total_defact *= 1000000;
                    foreach($defact_array as $index => $dpmo) {
                        // Start: Kalau acara sudah fix, modifikasi ini
                        if ($total_defact > $defact_array[0]) {
                            $sigma_produk[$id] = 0;
                            break;
                        }

                        if ($total_defact <= $defact_array[5]) {
                            $sigma_produk[$id] = 10;
                            break;
                        }
                        // End
                        
                        if ($total_defact <= $dpmo && $total_defact >= $defact_array[$index+1]) {
                            $defact_atas = $dpmo;
                            $defact_bawah = $defact_array[$index+1];
                            $level_atas = $index+1;
                            $level_bawah = $index+2;
        
                            $sigma_produk[$id] = round(((($total_defact-$defact_bawah)/($defact_atas-$defact_bawah))* ($level_atas-$level_bawah)) + $level_bawah, 2);
                            break;
                        }
                    }
                    
                    // Lakukan proses produksi berdasarkan spesifikasi mesin
                    foreach($machine_process as $index => $machine) {
                        if ($product_amount > $machine["capacity"]) {
                            $product_amount = $machine["capacity"];
                        }

                        // Jika special occasion product, maka tidak ada defact
                        if (!in_array($id, [4,5])){
                            $product_amount = $product_amount - ($product_amount * $machine["defact"]);
                        }
                    }

                    // Simpan di array 
                    $product_total_amount[$id] = floor($product_amount);
                }

                // Cek apakah inventory produk dapat menyimpan produk yang bisa dibuat ini
                $inventory_amount = $team->products->sum('pivot.amount');
                if ((array_sum($product_total_amount)+$inventory_amount) <= $team->product_inventory) {
                    // Tambah Produk Jadi ke Inventori
                    foreach ($product_total_amount as $product_id => $product_amount) {
                        $sigma = (int)($sigma_produk[$product_id]*100);

                        if (count($team->products()->wherePivot('products_id', $product_id)->wherePivot('batch', $batch)->wherePivot('sigma_level', $sigma)->get()) > 0) {
                            $team->products()->wherePivot('products_id', $product_id)->wherePivot('batch', $batch)->wherePivot('sigma_level', $sigma)->increment('product_inventory.amount', $product_amount);
                        } else {
                            $new_id = 1;
                            $latest_id = $team->products()->wherePivot('products_id', $product_id)->orderBy('product_inventory.id', 'desc')->first();
                            if($latest_id != null) $new_id = $latest_id->pivot->id + 1;

                            $team->products()->attach($product_id, ['id'=> $new_id, 'batch' => $batch, 'amount' => $product_amount, 'sigma_level' => $sigma]);
                        }
                    }

                    // Kurangi jumlah bahan baku
                    foreach($ingredients_need as $id => $amount){
                        $team->ingredients()->wherePivot('ingredients_id', $id)->decrement('ingredient_inventory.amount', $amount);
                    }

                    // Tambahkan special occassion
                    foreach($apple_need as $product_id => $apple_amount) {
                        $result = floor($apple_amount/10);
                        $id_ingredient = 13;
                        if ($product_id == 3) $id_ingredient = 14;

                        if (count($team->ingredients()->wherePivot('ingredients_id', $id_ingredient)->get()) > 0) {
                            $team->ingredients()->wherePivot('ingredients_id', $id_ingredient)->increment('ingredient_inventory.amount', $result);
                        } else {
                            $team->ingredients()->attach($id_ingredient, ['amount' => $result]);
                        }
                    }

                    // Defective Product

                    // Success Result
                    $status = "success";
                    $message = "Berhasil memproduksi dengan hasil: \n";

                    $i = 0;
                    foreach($product_total_amount as $id => $amount) {
                        $remaining = ($productions_amount[$i]*10-$amount);
                        $message .= "- ".$amount." ".Product::find($id)->name." (".$remaining." gagal)\n";
                        $defective_product[$id] = $remaining;
                        $i++;
                    }
                } else {
                    $status = "failed";
                    $message = "Produk inventori tidak mencukupi";
                }
            } else {
                $status = "failed";
                $message = "Bahan baku tidak mencukupi";
            }

            return response()->json(array(
                'status' => $status,
                'message' => $message
            ), 200);
        } catch(Exception $e) {
            return response()->json(array(
                'status' => 'failed',
                'message' => "Terjadi kegagalan dalam proses produksi"
            ), 200);
        }
    }
}
