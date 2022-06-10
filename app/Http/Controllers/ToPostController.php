<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToPostController extends Controller
{
    public function dashboard() {
        $this->authorize('peserta');
        $batch = Batch::find(1)->batch;
        $team = Team::find(Auth::user()->team);
        return view('index', compact('batch', 'team'));
    }
}
