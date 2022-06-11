<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MachineController extends Controller
{
    public function buyMachine(Request $request) {
        $this->authorize("peserta");

        $machine_id = $request->get('machine_id');
        $machine_amount = $request->get('machine_amount');
        $team = Team::find(Auth::user()->team);
    }
}   
