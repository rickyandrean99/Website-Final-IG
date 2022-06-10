<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Team;

class IngredientController extends Controller
{
    public function buyIngredient(Request $request) {
        $this->authorize("peserta");

        $ingredient_id = $request->get('ingredient_id');
        $ingredient_amount = $request->get('ingredient_amount');

        $id_team = Auth::user()->team;
        $team = Team::find($id_team);

        var_dump($ingredient_id);

        return response()->json(array(
            'status'=> 'success',
        ), 200);
    }
}
