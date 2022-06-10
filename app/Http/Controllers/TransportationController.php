<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    public function getTransport(Request $request){
        $team = Team::find(Auth()->team);
        // dd($team->transportations[0]->pivot->batch);
        return view('index', compact('team'));
    }
}
