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
        $total_price = 0;
        $total_amount = 0;
        
        // Cek harga pembelian
        foreach ($ingredient_id as $index => $id) {
            $total_price += Ingredient::find($id)->price * $ingredient_amount[$index];
        }

        if ($team->balance >= $total_price) {
            // Cek jumlah
            $filled_inventory = $team->ingredients()->sum('amount');

            // Cek jumlah paket yang dibeli
            foreach ($ingredient_amount as $amount) {
                $total_amount += $amount;
            }

            if (($filled_inventory + $total_amount) <= $team->ingredient_inventory) {
                // kurangi balance
                // update limit package
                // masukan inventory

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
