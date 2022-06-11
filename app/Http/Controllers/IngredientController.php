<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team;
use App\Ingredient;

class IngredientController extends Controller
{
    public function buyIngredient(Request $request) {
        $this->authorize("peserta");

        $ingredient_id = $request->get('ingredient_id');
        $ingredient_amount = $request->get('ingredient_amount');
        $team = Team::find(Auth::user()->team);
        $prices = [];
        $amounts = [];
        
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
                            $a = $team->ingredients->where('pivot.id', $id);
                            var_dump($a);
                            //$team->ingredients()->where('pivot.id', $id)->amount = $team->ingredients()->where('pivot.id', $id)->amount + $amounts[$index];
                            //$team->ingredients->save();
                        } else {
                            $team->ingredients()->attach($id, ['amount' => $amounts[$index]]);
                        }
                    }
                }
                
                // kurangi balance
                // update limit package

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

        return response()->json(array(
            'status'=> $status,
            'message' => $message
        ), 200);
    }
}
