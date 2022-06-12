<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Team;
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
    }

    public function getMachineById(Request $request)
    {
        $batch = Batch::find(1)->batch;
        $id = $request->get("id");
        
        $machine = DB::table("team_machine")->where('id', $id)->get();
        $nama = DB::table('machines_types')->where('id', $machine[0]->machines_types_id)->get();

        $lifetime = $batch - $machine[0]->batch + 1;
        $price = $nama[0]->price - ($lifetime/5*($nama[0]->price - $nama[0]->residual_price));
        $nama = $nama[0]->name;
        
        var_dump($nama);
        var_dump($lifetime);
        var_dump($price);

        return response()->json(array(
            'status'=>'ok',
            'id'=>$id,
            'nama'=>$nama,
            'lifetime'=>$lifetime,
            'price' => $price
        ));
    }
}   
