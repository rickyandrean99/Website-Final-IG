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
use Illuminate\Support\Facades\DB;

class ToPostController extends Controller
{
    public function dashboard() {
        if (Auth::user()->role == "administrator"){
            return redirect()->route('batch');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "acara") {
            return redirect()->route('score-recap');
        }

        $batch = Batch::find(1)->batch;
        $team = Team::find(Auth::user()->team);
        $ingredient = Ingredient::where('id', '<=', '12')->get();
        $machines = MachineType::all();
        $transportations = Transportation::all();
        $products = Product::all();
        $limit = $team->packages()->wherePivot('packages_id', $batch)->first()->pivot->remaining;
        $product_name = ['Keripik Apel', 'Dodol Apel', 'Sari Buah Apel', 'Selai Kulit Apel', 'Cuka Apel'];
        $product_amount = [];
        for ($i = 1; $i<=5; $i++){
            $team_product = DB::table('product_inventory')->where('teams_id', $team->id)->where('products_id', $i)->sum('amount');
            array_push($product_amount, $team_product);
        }

        $inventory1 = DB::table('inventory_pricelists')->where('inventory_type_id', 1)->get();
        $inventory2 = DB::table('inventory_pricelists')->where('inventory_type_id', 2)->get();

        return view('index', compact(
            'batch', 'team', 'ingredient', 'machines', 
            'transportations', 'limit', 'products',
            'product_name', 'product_amount', 'inventory1', 'inventory2'));
    }

    public function addCoin(Request $request){
        $this->authorize("peserta");

        $coin = $request->get('coin');
        $metode = $request->get('metode');

        $team = Team::find(Auth::user()->team);

        if($metode == 1){
            $team->increment('balance', $coin);
        }else{
            if($team->debt_batch == 1){
                return response()->json(array(
                    'status' => "failed",
                    'message' => "Perusahaan sudah meminjam modal tambahan pada batch ini",
                ), 200);
            }
            if($team->balance >= 7500){
                return response()->json(array(
                    'status' => "failed",
                    'message' => "Modal tambahan dapat ditambakan ketika modal perusahaan kurang dari 7500 TC",
                ), 200);
            }
            if($coin > 8000){
                return response()->json(array(
                    'status' => "failed",
                    'message' => "Batas maksimal modal tambahan adalah 8000 TC",
                ), 200);
            }
            $team->increment('balance', $coin);
            $team->debt_batch = 1;
            $team->save();
        }

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;


        return response()->json(array(
            'balance' => $balance,
            'status' => "success",
            'message' => "Berhasil menambah koin",
        ), 200);
    }   

    public function infoHutang(){
        $team = Team::find(Auth::user()->team);
        $hutang = $team->debt;
        $info = "Jumlah Hutang: ".$hutang." TC";

        return response()->json(array(
            'status' => "success",
            'info' => $info
        ), 200);
    }

    public function bayarHutang(Request $request){
        $team = Team::find(Auth::user()->team);
        $bayar = $request->get('bayar');
        $hutang = $team->debt;

        if ($bayar > $team->debt){
            return response()->json(array(
                'message' => "Jumlah yang dibayar melebihi hutang",
                'status' => "failed",
                'info' => "Jumlah Hutang: ".$hutang." TC"
            ), 200);
        }


        if ($team->balance >= $bayar) {
            $team->decrement('balance', $bayar);
            $team->decrement('debt', $bayar);
            $team->save();

            $status = "success";
            $message = "Berhasil bayar hutang";
        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
        }

        $team = Team::find(Auth::user()->team);
        $hutang = $team->debt;
        $balance = $team->balance;

        return response()->json(array(
            'status' => $status,
            'message' => $message,
            'balance' => $balance,
            'info' => "Jumlah Hutang: ".$hutang." TC"
        ), 200);
    }
}
