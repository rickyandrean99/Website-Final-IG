<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\Batch;
use App\Ingredient;
use App\Events\UpdateImport;
use DB;

class IngredientController extends Controller
{
    public function buyIngredient(Request $request) {
        $this->authorize("peserta");
        
        $ingredient_id = $request->get('ingredient_id');
        $ingredient_amount = $request->get('ingredient_amount');
        $ingredient_type = $request->get('ingredient_type');
        $team = Team::find(Auth::user()->team);
        $batch = Batch::find(1)->batch;
        $prices = [];
        $amounts = [];
        $ongkir = 0;
        $limit = $team->packages()->wherePivot('packages_id', $batch)->first()->pivot->remaining;

        // Cek harga pembelian
        foreach ($ingredient_id as $index => $id) {
            if ($ingredient_type[$index] == "true") {
                array_push($prices, Ingredient::find($id)->import_price * $ingredient_amount[$index]);
            } else {
                array_push($prices, Ingredient::find($id)->price * $ingredient_amount[$index]);
            }
        }

        // Cek Ongkos Kirim
        $quantity = array_sum($ingredient_amount);
        $remaining = $limit - $quantity;
        if ($remaining < 0) {
            $ongkir = $limit + (($quantity-$limit)*3);
        } else {
            $ongkir = $quantity;
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
                // Cek apakah stok impor masih tersedia
                $permission = true;
                foreach ($ingredient_id as $index => $id) {
                    if ($ingredient_type[$index] == "true") {
                        $import_stock = Ingredient::find($id)->rounds()->wherePivot("rounds_id", $batch)->first()->pivot->amount;
                        if ($ingredient_amount[$index] > $import_stock) {
                            $permission = false;
                            break;
                        }
                    }
                }

                if ($permission) {
                    // Mengurangi stok bahan baku impor
                    foreach ($ingredient_id as $index => $id) {
                        if ($ingredient_type[$index] == "true") {
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
                    $ingredients = DB::table("ingredients")->join("import_ingredient", "import_ingredient.ingredients_id", "=", "ingredients.id")->select("ingredients.id AS id", "import_ingredient.amount AS amount",)->where("import_ingredient.rounds_id", $batch)->get();
                    event(new UpdateImport($ingredients));

                    $status = "success";
                    $message = "Berhasil membeli ingredient";
                } else {
                    $status = "failed";
                    $message = "Bahan baku impor tidak mencukupi";
                }
            } else {
                $status = "failed";
                $message = "Inventori bahan baku tidak mencukupi";
            }
        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }

        $balance = $team->balance;

        return response()->json(array(
            'status' => $status,
            'message' => $message,
            'balance' => $balance,
            'limit' => $limit
        ), 200);
    }
}
