<?php

namespace App\Http\Controllers;

use App\Team;
use App\Batch;
use App\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransportationController extends Controller
{
    public function buyTransportation(Request $request) {
        $this->authorize("peserta");

        $transportation_id = $request->get('transportation_id');
        $team = Team::find(Auth::user()->team);
        $total_price = 0;

        foreach ($transportation_id as $index => $id) {
            $total_price += Transportation::find($id)->price * $transportation_amount[$index];
        }

        if ($team->balance >= $total_price) {
            $status = "success";
            $message = "Berhasil membeli ingredient";
        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }

        return response()->json(array(
            'status'=> $status,
            'message' => $message
        ), 200);
    }

    public function sellTransport(Request $request) {
        $id = $request->get("id");
        $batch = Batch::find(1)->batch;
        $team = Team::find(Auth::user()->team);
        
        $transportation = DB::table("team_transportation")->where('id', $id)->get();
        $transport = Transportation::find($transportation[0]->transportations_id);
        
        $lifetime = $batch - $transportation[0]->batch + 1;
        $price = $transport->price - ($lifetime/5*($transport->price - $transport->residual_price));
        
        $update_price = $team->increment('balance', $price);
        $team->save();

        $update_exist = DB::table("team_transportation")->where('id', $id)->update(['exist'=>0]);

        return response()->json(array(
            'status'=> "success",
            'message' => "Berhasil menjual transportasi"
        ), 200);
    }

    public function getTransportById(Request $request)
    {
        $batch = Batch::find(1)->batch;
        $id = $request->get("id");
        //$transportation = Team::find(Auth::user()->team)->transportations->where('pivot.id', 2);
        
        $transportation = DB::table("team_transportation")->where('id', $id)->get();
        $nama = DB::table('transportations')->where('id', $transportation[0]->transportations_id)->get();

        // var_dump($nama[0]->name);
        // var_dump($transportation[0]->batch);
        // var_dump($transportation[1]->name);

        $lifetime = $batch - $transportation[0]->batch + 1;
        $price = $nama[0]->price - ($lifetime/5*($nama[0]->price - $nama[0]->residual_price));
        $nama = $nama[0]->name;
        
        return response()->json(array(
            'status'=>'ok',
            'id'=>$id,
            'nama'=>$nama,
            'lifetime'=>$lifetime,
            'price' => $price
        ));
    }
}
