<?php

namespace App\Http\Controllers;
use App\Team;
use Illuminate\Http\Request;

class UpgradePostController extends Controller
{
    public function dashboard() {
        $this->authorize('peserta');
        $teams = Team::all();
        return view('upgrade', compact('teams'));
    }

    public function buyFridge(Request $request){
        $id = $request->get('id');
        $team = Team::find($id);

        if ($team->fridge == 0){
            $buy_fridge = $team->increment('fridge');
            $bayar = $team->decrement('balance', 2000);
            $team->save();

            $message =  "Berhasil membeli kulkas";

        }else{
            $message = "Anda sudah membeli kulkas";
        }

        return response()->json(array(
            'message' => $message
        ), 200);
    }

    public function updateLevel(Request $request){
        $machine_id = $request->get('machine_id');
        $team = Team::find($id);

        var_dump($machine_id);
    }
}
