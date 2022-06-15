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
        $this->authorize('peserta');

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
        $team = Team::find(Auth::user()->team);
        $team->increment('balance', $coin);

        return response()->json(array(
            'status' => "success",
            'message' => "Berhasil menambah koin",
        ), 200);
    }   

    public function infoHutang(){
        $team = Team::find(Auth::user()->team);

        if ($team->debt_paid != 0) {
            $status = "success";
            $info = "Hutang Lunas";
        } else {
            $batch = Batch::find(1)->batch;
            $hutang = 25000;
            for($i = 1; $i <= $batch; $i++) {
                $hutang += (0.05 * $hutang);
            }

            $status = "failed";
            $info = "Jumlah Hutang: ".ceil($hutang)." TC";
        }

        return response()->json(array(
            'status' => $status,
            'info' => $info
        ), 200);
    }

    public function bayarHutang(){
        $team = Team::find(Auth::user()->team);
        
        if ($team->debt_paid != 0){
            return response()->json(array(
                'message' => "Hutang sudah lunas",
                'status' => "success",
                'info' => "Hutang Lunas"
            ), 200);
        }
        
        $batch = Batch::find(1)->batch;
        $hutang = 25000;
        for ($i = 1; $i <= $batch; $i++) {
            $hutang += (0.05 * $hutang);
        }

        if ($team->balance >= ceil($hutang)) {
            $team->decrement('balance', ceil($hutang));
            $team->debt_paid = $batch;
            $team->save();

            $status = "success";
            $message = "Berhasil bayar hutang";
            $info = "Hutang Lunas";
        } else {
            $status = "failed";
            $message = "Saldo tidak mencukupi";
            $info = "Hutang belum lunas";
        }

        return response()->json(array(
            'status' => $status,
            'message' => $message,
            'info' => $info
        ), 200);
    }
}
