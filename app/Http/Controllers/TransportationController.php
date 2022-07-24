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
        $transportation_amount = $request->get('transportation_amount');
        $team = Team::find(Auth::user()->team);
        $batch = Batch::find(1)->batch;
        $prices = [];

        foreach ($transportation_id as $index => $id) {
            array_push($prices, Transportation::find($id)->price * $transportation_amount[$index]);
        }

        // var_dump(array_sum($prices));

        if ($team->balance >= array_sum($prices)) {
            // kurangi balance
            $team->decrement('balance', array_sum($prices));

            // ambil id terbaru
            $new_id = DB::table('team_transportation')->select('id')->orderBy('id', 'desc')->get();

            if (count($new_id) > 0) {
                $new_id = $new_id[0]->id + 1;
            } else {
                $new_id = 1;
            }

            foreach ($transportation_id as $index => $id) {
                // ambil transportation type
                // cari id transportation berdasarkan transportation types
                // cari defact
                if($transportation_amount[$index] > 0){
                    for ($i = 1; $i <=$transportation_amount[$index]; $i++){    
                        $team->transportations()->attach($id, [
                            'id' => $new_id++,
                            'batch' => $batch, 
                        ]);
                    }
                }
            }

            $status = "success";
            $message = "Berhasil membeli transportasi";

            //tambah  history beli transportation
            DB::table('histories')->insert([
                "teams_id" => $team->id,
                "kategori" => "TRANSPORTATION",
                "batch" => $batch,
                "type" => "OUT",
                "amount" => array_sum($prices),
                "keterangan" => "Berhasil membeli transportasi seharga ".array_sum($prices)." TC"
            ]);

        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }    

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;
        $transportations = $team->transportations;

        return response()->json(array(
            'balance' => $balance,
            'transportations' => $transportations,
            'status' => $status,
            'message' => $message,
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
        
        $team->increment('balance', $price);
        $team->save();

        DB::table("team_transportation")->where('id', $id)->update(['exist'=>0]);

        //tambah  history jual transportation
        DB::table('histories')->insert([
            "teams_id" => $team->id,
            "kategori" => "TRANSPORTATION",
            "batch" => $batch,
            "type" => "IN",
            "amount" => $price,
            "keterangan" => "Berhasil menjual ".$transport->name." seharga ".$price." TC"
        ]);

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;
        $transportations = $team->transportations;

        return response()->json(array(
            'balance' => $balance,
            'transportations' => $transportations,
            'status'=> "success",
            'message' => "Berhasil menjual transportasi",
            "id" => $id
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
