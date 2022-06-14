<?php

namespace App\Http\Controllers;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $bayar = $team->decrement('balance', 1000);
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
        $machine_types_id = $request->get('machine_types_id');
        $id = $request->get('id');
        $team = Team::find($id);

        $mesin = DB::table('team_machine')
            ->where('id', $machine_id)
            ->where('machine_types_id', $machine_types_id)
            ->where('teams_id', $id)
            ->get();

        return response()->json(array(
            'status'=> "success",
            'level' => $mesin[0]->level
        ), 200);
    }

    public function upgradeMachine(Request $request){
        $machine_id = $request->get('machine_id');
        $machine_types_id = $request->get('machine_types_id');
        $id = $request->get('id');
        $team = Team::find($id);
        $price = DB::table('machine_types')->where('id', $machine_types_id)->get();
        $price = $price[0]->upgrade_price;

        $mesin = DB::table('team_machine')
            ->where('id', $machine_id)
            ->where('machine_types_id', $machine_types_id)
            ->where('teams_id', $id)
            ->get();

        if($mesin[0]->is_upgrade == 0){
            if ($team->upgrade_machine_limit > 0){
                if($team->balance >= $price){
                    $team->decrement('balance', $price);
                    $team->decrement('upgrade_machine_limit', 1);
    
                    DB::table('team_machine')
                    ->where('id', $machine_id)
                    ->where('machine_types_id', $machine_types_id)
                    ->where('teams_id', $id)
                    ->increment('level', 1);

                    DB::table('team_machine')
                    ->where('id', $machine_id)
                    ->where('machine_types_id', $machine_types_id)
                    ->where('teams_id', $id)
                    ->increment('is_upgrade', 1);
    
                    $type = DB::table('machine_types')->where('id', $machine_types_id)->get();
    
                    $new_defact = DB::table('machine_level')
                        ->where('machines_id', $type[0]->machines_id)
                        ->where('levels_id', $mesin[0]->level + 1)->get();
    
                    DB::table('team_machine')
                    ->where('id', $machine_id)
                    ->where('machine_types_id', $machine_types_id)
                    ->where('teams_id', $id)
                    ->update(['defact' => $new_defact[0]->defact]);
    
                    $status = "success";
                    $message = "Berhasil upgrade machine";
                }else{
                    $status = "failed";
                    $message = "Koin tidak mencukupi";
                }
    
            }else{
                $status = "failed";
                $message = "Kesempatan upgrade untuk batch ini sudah habis";
            }
        }else{
            $status = "failed";
            $message = "Mesin ini telah diupgrade pada batch ini";
        }

        return response()->json(array(
            'status'=> $status,
            'message' => $message,
            'level' => $mesin[0]->level + 1,
            'limit' => $team->upgrade_machine_limit
        ), 200);
    }
}
