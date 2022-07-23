<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\Batch;
use App\Ingredient;

class IngredientController extends Controller
{
    public function buyIngredient(Request $request) {
        $this->authorize("peserta");

        $ingredient_id = $request->get('ingredient_id');
        $ingredient_amount = $request->get('ingredient_amount');
        $team = Team::find(Auth::user()->team);
        $batch = Batch::find(1)->batch;
        $prices = [];
        $amounts = [];
        $limit = 0;
        
        // Cek harga pembelian
        foreach ($ingredient_id as $index => $id) {
            array_push($prices, Ingredient::find($id)->price * $ingredient_amount[$index]);
        }

        if ($team->balance >= array_sum($prices)) {
            // Cek jumlah inventory saat ini dalam satuan unit
            $filled_inventory = $team->ingredients->sum('pivot.amount');

            // Cek jumlah unit yang dibeli
            foreach ($ingredient_id as $index => $id) {
                array_push($amounts, Ingredient::find($id)->amount * $ingredient_amount[$index]);
            }

            // Cek apakah inventory masih cukup untuk menampung bahan baku
            if (($filled_inventory + array_sum($amounts)) <= $team->ingredient_inventory) {
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
                $team->decrement('balance', array_sum($prices));

                // update limit package pada batch terkait
                $current_limit = ($team->packages()->wherePivot('packages_id', $batch)->get()[0])->pivot->remaining;
                if ($current_limit > array_sum($ingredient_amount)) {
                    $limit = $current_limit - array_sum($ingredient_amount);
                } 
                $team->packages()->wherePivot('packages_id', $batch)->update(['team_package.remaining' => $limit]);

                $status = "success";
                $message = "Berhasil membeli ingredient";
            } else {
                $status = "failed";
                $message = "Inventori bahan baku tidak mencukupi";
            }
        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;
        $ingredients = $team->ingredients;
        $used = $team->ingredients->sum('pivot.amount');

        return response()->json(array(
            'status' => $status,
            'message' => $message,
            'balance' => $balance,
            'used' => $used,
            'ingredients' => $ingredients,
            'limit' => $limit
        ), 200);
    }
}
