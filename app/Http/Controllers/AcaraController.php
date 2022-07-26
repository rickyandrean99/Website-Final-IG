<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Demand;
use App\Team;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Auth;

class AcaraController extends Controller
{
    public function index(){
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "administrator"){
            return redirect()->route('batch');
        }

        $teams = Team::all();
        return view('score-recap', compact('teams'));
    }
    

    public function demand(){
        $batch = Batch::find(1)->batch;
        $demands = (Demand::find($batch))->products()->wherePivot('amount', '!=', 0)->get();
        return view('demand', compact('batch', 'demands'));
    }
}
