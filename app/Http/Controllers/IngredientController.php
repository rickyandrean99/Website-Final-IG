<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\Batch;
use App\Package;
use App\Ingredient;
use App\Events\UpdateImport;
use DB;

class IngredientController extends Controller
{
    public function buyIngredient(Request $request) {
        $this->authorize("ingredient");
        
        $ingredient_id = $request->get('ingredient_id');
        $ingredient_amount = $request->get('ingredient_amount');
        $ingredient_type = $request->get('ingredient_type');
        $team_id = $request->get('team_id');

        $team = Team::find($team_id);
        $batch = Batch::find(1)->batch;
        $prices = [];
        $amounts = [];
        $ongkir = Package::find($batch)->fee;
        $limit = $team->packages()->wherePivot('packages_id', $batch)->first()->pivot->remaining;

        // Cek harga pembelian
        foreach ($ingredient_id as $index => $id) {
            if ($ingredient_type[$index] == "local") {
                array_push($prices, Ingredient::find($id)->local_price * $ingredient_amount[$index]);
            } else {
                array_push($prices, Ingredient::find($id)->import_price * $ingredient_amount[$index]);
            }
        }

        // Cek Ongkos Kirim
        $quantity = array_sum($ingredient_amount);
        $remaining = $limit - $quantity;
        if ($remaining < 0) {
            $ongkir += (($quantity-$limit)*3);
        } 

        // Cek apakah saldo cukup
        if ($team->balance >= (array_sum($prices) + $ongkir)) {
            // Cek jumlah inventory saat ini dalam satuan unit
            $filled_inventory = $team->ingredients->sum('pivot.amount');
            
            // Cek jumlah unit yang dibeli
            foreach ($ingredient_id as $index => $id) {
                array_push($amounts, Ingredient::find($id)->amount * $ingredient_amount[$index]);
            }

            // Cek apakah inventory masih cukup untuk menampung bahan baku
            if (($filled_inventory + array_sum($amounts)) <= $team->ingredient_inventory) {
                // Cek apakah stok local masih tersedia
                $permission = true;
                foreach ($ingredient_id as $index => $id) {
                    if ($ingredient_type[$index] == "local") {
                        $local_stock = Ingredient::find($id)->rounds()->wherePivot("rounds_id", $batch)->first()->pivot->amount;
                        if ($ingredient_amount[$index] > $local_stock) {
                            $permission = false;
                            break;
                        }
                    }
                }

                if ($permission) {
                    // Mengurangi stok bahan baku lokal
                    foreach ($ingredient_id as $index => $id) {
                        if ($ingredient_type[$index] == "local") {
                            Ingredient::find($id)->rounds()->wherePivot("rounds_id", $batch)->decrement("amount", $ingredient_amount[$index]);
                        }
                    }

                    // Memasukkan bahan baku yang dibeli ke dalam ingredient inventory
                    foreach ($ingredient_id as $index => $id) {
                        if ($amounts[$index] > 0) {
                            if ($team->ingredients->contains($id)) {
                                $team->ingredients()->wherePivot('ingredients_id', $id)->increment('ingredient_inventory.amount', $amounts[$index]);
                            } else {
                                $team->ingredients()->attach($id, ['amount' => $amounts[$index]]);
                            }
                        }
                    }

                    // kurangi balance
                    $team->decrement('balance', (array_sum($prices)+$ongkir));

                    // update limit package pada batch terkait
                    if ($limit > $quantity) {
                        $limit -= $quantity;
                    } else {
                        $limit = 0;
                    }

                    // History beli ingredient
                    $team->packages()->wherePivot('packages_id', $batch)->update(['team_package.remaining' => $limit]);
                    DB::table('histories')->insert([
                        "teams_id" => $team->id,
                        "kategori" => "INGREDIENT",
                        "batch" => $batch,
                        "type" => "OUT",
                        "amount" => (array_sum($prices)+$ongkir),
                        "keterangan" => "Berhasil membeli bahan baku seharga ".(array_sum($prices)+$ongkir)." TC"
                    ]);

                    // Realtime Ingredient
                    if (in_array("local", $ingredient_type)) {
                        $ingredients = DB::table("ingredients")->join("local_ingredient", "local_ingredient.ingredients_id", "=", "ingredients.id")->select("ingredients.id AS id", "local_ingredient.amount AS amount",)->where("local_ingredient.rounds_id", $batch)->get();
                        event(new UpdateImport($ingredients)); // Nama Event seharusnya UpdateLocal
                    }

                    $status = "success";
                    $message = "Berhasil membeli ingredient";
                } else {
                    $status = "failed";
                    $message = "Bahan baku lokal tidak mencukupi";
                }
            } else {
                $status = "failed";
                $message = "Inventori bahan baku tidak mencukupi";
            }
        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }

        return response()->json(array(
            'status' => $status,
            'message' => $message
        ), 200);
    }

    public function localIngredient() {
        if (Auth::user()->role == "administrator"){
            return redirect()->route('batch');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        } else if (Auth::user()->role == "peserta") {
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "impor") {
            return redirect()->route('ingredient-import');
        }
        
        $ingredients = Ingredient::where('id', '<=', '12')->get();
        $teams = Team::all();
        $batch = Batch::find(1)->batch;
        $ongkir = Package::find($batch)->fee;
        return view('ingredient-lokal', compact('ingredients', 'teams', 'ongkir', 'batch'));
    }

    public function importIngredient() {
        if (Auth::user()->role == "administrator"){
            return redirect()->route('batch');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        } else if (Auth::user()->role == "lokal") {
            return redirect()->route('ingredient-lokal');
        } else if (Auth::user()->role == "peserta") {
            return redirect()->route('peserta');
        }

        $ingredients = Ingredient::where('id', '<=', '12')->get();
        $teams = Team::all();
        $batch = Batch::find(1)->batch;
        $ongkir = Package::find($batch)->fee;
        return view('ingredient-import', compact('ingredients', 'teams', 'ongkir'));
    }

    public function changeTeam(Request $request) {
        $team = Team::find($request->get('teamId'));
        $batch = Batch::find(1)->batch;
        $limit = $team->packages()->wherePivot('packages_id', $batch)->first()->pivot->remaining;

        return response()->json(array(
            'status' => 'success',
            'message' => 'Berhasil memperbaharui tim',
            'limit' => $limit
        ), 200);
    }
}
