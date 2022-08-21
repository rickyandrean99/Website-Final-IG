<?php

namespace App\Http\Controllers;
use App\Team;
use App\Batch;
use App\Events\UpdateBalance;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UpgradePostController extends Controller
{
    public function dashboard() {
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        }

        $teams = Team::all();
        return view('upgrade', compact('teams'));
    }

    public function buyFridge(Request $request){
        $id = $request->get('id');
        $team = Team::find($id);
        $batch = Batch::find(1)->batch;

        if ($team->fridge == 0) {
            if ($team->balance >= 1000) {
                $team->increment('fridge');
                $team->decrement('balance', 1000);
                $team->save();

                $message = "Berhasil membeli kulkas";

                //tambah history buy fridge
                DB::table('histories')->insert([
                    "teams_id" => $team->id,
                    "kategori" => "FRIDGE",
                    "batch" => $batch,
                    "type" => "OUT",
                    "amount" => 1000,
                    "keterangan" => "Berhasil membeli kulkas seharga 1000 TC"
                ]);

                //pusdher update balance tim
                $balance = Team::find($id)->balance;
                event(new UpdateBalance($id, $balance));
            } else {
                $message = "Saldo TC tidak mencukupi";
            }
        } else {
            $message = "Perusahaan sudah memiliki kulkas";
        }

        return response()->json(array(
            'message' => $message
        ), 200);
    }

    public function updateLevel(Request $request){
        $machine_id = $request->get('machine_id');
        $machine_types_id = $request->get('machine_types_id');
        $id = $request->get('id');

        $mesin = DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->where('exist', '1')->get();

        if (count($mesin) > 0) {
            $status = "success";
            $message = $mesin[0]->level;
            $defect = $mesin[0]->defact;
        } else {
            $status = "failed";
            $message = "Mesin ini sudah tidak ada di inventory";
            $defect = 0;
        }

        return response()->json(array(
            'defect'=> $defect,
            'status'=> $status,
            'level' => $message
        ), 200);
    }

    public function upgradeMachine(Request $request){
        $batch = Batch::find(1)->batch;
        $machine_id = $request->get('machine_id');
        $machine_types_id = $request->get('machine_types_id');
        $id = $request->get('id');
        $team = Team::find($id);
        $price = DB::table('machine_types')->where('id', $machine_types_id)->get();

        if($batch == 1){
            return response()->json(array(
                'status'=> "failed",
                'message' => "Tidak dapat melakukan upgrade mesin pada batch 1",

            ), 200);
        }
        
        $mesin = DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->where('exist', 1)->get();

        $level = $mesin[0]->level;
        $limit = $team->upgrade_machine_limit;
        $defect = $mesin[0]->defact;

        if($level == 0){
            $price = $price[0]->upgrade_price1;
        }else if($level == 1){
            $price = $price[0]->upgrade_price2;
        }else if($level == 2){
            $price = $price[0]->upgrade_price3;
        }else{
            $price = 0;
        }

        // Jika Harga 0, maka mesin tersebut merupakan mesin untuk waste product karena mesin tersebut defactnya sudah 0 (Kecuali Cooking Mixer)
        if ($price == 0) {
            return response()->json(array(
                'status'=> "failed",
                'message' => "Mesin ini merupakan mesin untuk waste product yang tidak perlu diupgrade karena defactnya 0!",
            ), 200);
        }
        
        if (count($mesin) > 0) {
            if ($mesin[0]->is_upgrade == 0){
                if ($team->upgrade_machine_limit > 0){
                    if($team->balance >= $price){
                        if($mesin[0]->level != 3){
                            $team->decrement('balance', $price);
                            $team->decrement('upgrade_machine_limit', 1);
            
                            DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->increment('level', 1);
        
                            DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->increment('is_upgrade', 1);
            
                            $type = DB::table('machine_types')->where('id', $machine_types_id)->get();
            
                            $new_defact = DB::table('machine_level')->where('machines_id', $type[0]->machines_id)->where('levels_id', $mesin[0]->level + 1)->get();
            
                            DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->update(['defact' => $new_defact[0]->defact]);
                            
                            $mesin = DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->where('exist', 1)->get();

                            $status = "success";
                            $message = "Berhasil upgrade machine";
                            $level = $mesin[0]->level;
                            $defect = $mesin[0]->defact;
                            $limit = $team->upgrade_machine_limit;

                            //tambah history upgrade machine
                            DB::table('histories')->insert([
                                "teams_id" => $team->id,
                                "kategori" => "UPGRADE",
                                "batch" => $batch,
                                "type" => "OUT",
                                "amount" => $price,
                                "keterangan" => "Berhasil upgrade ".$type[0]->name_type."". $mesin[0]->id." ke level ".$level." seharga ".$price." TC"
                            ]);

                            //pusdher update balance tim
                            $balance = Team::find($id)->balance;
                            event(new UpdateBalance($id, $balance));

                        }else{
                            $status = "failed";
                            $message = "Mesin ini sudah mencapai level maksimal";
                        }
                    } else {
                        $status = "failed";
                        $message = "Koin tidak mencukupi";
                    }
                } else {
                    $status = "failed";
                    $message = "Kesempatan upgrade mesin pada batch ini sudah habis";
                }
            } else {
                $status = "failed";
                $message = "Mesin telah diupgrade pada batch ini";
            }
        } else {
            $status = "failed";
            $message = "Mesin sudah tidak ada di inventori";
        }

        return response()->json(array(
            'status'=> $status,
            'message' => $message,
            'defect' => $defect,
            'level' => $level,
            'limit' => $limit
        ), 200);
    }

    public function getMachineById(Request $request){
        $machine_id = $request->get('machine_id');
        $machine_types_id = $request->get('machine_types_id');
        $id = $request->get('id');
        $price = DB::table('machine_types')->where('id', $machine_types_id)->get();
        
        $mesin = DB::table('team_machine')->where('id', $machine_id)->where('machine_types_id', $machine_types_id)->where('teams_id', $id)->where('exist', 1)->get();

        $machine = DB::table('machine_types')->where('id', $machine_types_id)->get();
        $level = $mesin[0]->level;
        $name = $machine[0]->name_type;

        if($level == 0){
            $price = $price[0]->upgrade_price1;
        }else if($level == 1){
            $price = $price[0]->upgrade_price2;
        }else if($level == 2){
            $price = $price[0]->upgrade_price3;
        }else{
            $price = 0;
        }

        return response()->json(array(
            'name' => $name,
            'level' => $level,
            'price' => $price
        ), 200);
    }
}
