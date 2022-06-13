<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Team;
use App\Ingredient;
use App\MachineType;
use App\Transportation;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToPostController extends Controller
{
    public function dashboard() {
        $this->authorize('peserta');

        $batch = Batch::find(1)->batch;
        $team = Team::find(Auth::user()->team);
        $ingredient = Ingredient::where('id', '<=', '12')->get();
        $machines = MachineType::all();
        $transportations = Transportation::all();
        $products = Product::all();
        $limit = ($team->packages()->wherePivot('packages_id', $batch)->get()[0])->pivot->remaining;

        return view('index', compact('batch', 'team', 'ingredient', 'machines', 'transportations', 'limit', 'products'));
    }

    public function addCoin(Request $request){
        $this->authorize("peserta");

        $coin = $request->get('coin');
        $team = Team::find(Auth::user()->team);

        $update_balance = $team->increment('balance', $coin);
        $team->save();

        $status = "success";
        $message = "Berhasil menambah koin";

        return response()->json(array(
            'status' => $status,
            'message' => $message,
        ), 200);
    }   
}
