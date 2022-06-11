<?php

namespace App\Http\Controllers;

use App\Team;
use App\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportationController extends Controller
{
    public function buyTransportation(Request $request) {
        $this->authorize("peserta");

        $transportation_id = $request->get('transportation_id');
        $transportation_amount = $request->get('transportation_amount');
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

    public function checkSellPrice() {
        
    }

    public function sellTransport() {
        
    }
}
