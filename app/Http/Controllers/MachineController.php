<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Team;
use App\MachineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    public function buyMachine(Request $request) {
        $this->authorize("peserta");

        $machine_id = $request->get('machine_id');
        $machine_amount = $request->get('machine_amount');
        $team = Team::find(Auth::user()->team);
        $batch = Batch::find(1)->batch;
        $prices = [];

        foreach ($machine_id as $index => $id) {
            array_push($prices, MachineType::find($id)->price * $machine_amount[$index]);
        }

        if ($team->balance >= array_sum($prices)) {
            // kurangi balance
            $team->decrement('balance', array_sum($prices));            

            foreach ($machine_id as $index => $id) {
                // ambil id terbaru
                $new_id = DB::table('team_machine')->select('id')->where('teams_id', $team->id)->where('machine_types_id', $id)->orderBy('id', 'desc')->get();

                if (count($new_id) > 0) {
                    $new_id = $new_id[0]->id + 1;
                } else {
                    $new_id = 1;
                }

                if($machine_amount[$index] > 0){
                    for ($i = 1; $i <=$machine_amount[$index]; $i++){
                        $nama = DB::table('machine_types')->where('id', $id)->get();
                        $nama_machine = DB::table('machines')->where('id', $nama[0]->machines_id)->get();
                        $defact = $nama_machine[0]->defact;
    
                        $team->machineTypes()->attach($id, [
                            'id' => $new_id++,
                            'batch' => $batch, 
                            'defact' => $defact, 
                            'level' => 0
                        ]);
                    }
                }
            }

            $status = "success";
            $message = "Berhasil membeli machine";

            //tambah  history beli machine
            DB::table('histories')->insert([
                "teams_id" => $team->id,
                "kategori" => "MACHINE",
                "batch" => $batch,
                "type" => "OUT",
                "amount" => array_sum($prices),
                "keterangan" => "Berhasil membeli mesin seharga ".array_sum($prices)." TC"
            ]);

        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }    

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;
        $machines = $team->machineTypes;

        return response()->json(array(
            'balance' => $balance,
            'machines' => $machines,
            'status' => $status,
            'message' => $message,
        ), 200);
    }

    public function getMachineById(Request $request){
        $batch = Batch::find(1)->batch;
        $id = $request->get("id");
        $type_id = $request->get("type_id");
        $team = Team::find(Auth::user()->team);
        
        // var_dump($id);

        $machine = DB::table("team_machine")->where('id', $id)->where('machine_types_id', $type_id)->where('teams_id', $team->id)->get();

        $nama = DB::table('machine_types')->where('id', $machine[0]->machine_types_id)->get();
        
        $lifetime = $batch - $machine[0]->batch + 1;
        $price = $nama[0]->price - ($lifetime/5*($nama[0]->price - $nama[0]->residual_price));
        $nama = $nama[0]->name_type;

        return response()->json(array(
            'status'=>'ok',
            'id'=>$id,
            'nama'=> "$nama $id",
            'lifetime'=>$lifetime,
            'price' => $price
        ));
    }

    public function sellMachine(Request $request) {
        $id = $request->get("id");
        $batch = Batch::find(1)->batch;
        $team = Team::find(Auth::user()->team);
        $type_id = $request->get("type_id");
        
        $machine = DB::table("team_machine")->where('teams_id', $team->id)->where('id', $id)->where('machine_types_id', $type_id)->get();
        $nama = DB::table('machine_types')->where('id', $machine[0]->machine_types_id)->get();
        
        $lifetime = $batch - $machine[0]->batch + 1;
        $price =  $nama[0]->price - ($lifetime/5*($nama[0]->price - $nama[0]->residual_price));
        
        $team->increment('balance', $price);
        $team->save();

        DB::table("team_machine")->where('teams_id', $team->id)->where('id', $id)->where('machine_types_id', $type_id)->update(['exist'=>0]);

        //tambah  history jual machine
        DB::table('histories')->insert([
            "teams_id" => $team->id,
            "kategori" => "MACHINE",
            "batch" => $batch,
            "type" => "IN",
            "amount" => $price,
            "keterangan" => "Berhasil menjual ".$nama[0]->name_type."".$id." seharga ".$price." TC"
        ]);

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;
        $machines = $team->machineTypes;

        return response()->json(array(
            'type' => $type_id,
            'id' => $id,
            'balance' => $balance,
            'machines' => $machines,
            'status'=> "success",
            'message' => "Berhasil menjual mesin"
        ), 200);
    }
}   
