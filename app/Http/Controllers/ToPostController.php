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
        $this->authorize('peserta'); //jangan lupa diganti

        $batch = Batch::find(1)->batch;
        $team = Team::find(Auth::user()->team);
        $ingredient = Ingredient::where('id', '<=', '12')->get();
        $machines = MachineType::all();
        $transportations = Transportation::all();
        $products = Product::all();
        $limit = ($team->packages()->wherePivot('packages_id', $batch)->get()[0])->pivot->remaining;
        $product_name = ['Keripik Apel', 'Dodol Apel', 'Sari Buah Apel', 'Selai Kulit Apel', 'Cuka Apel'];
        $product_amount = [];

        for ($i = 1; $i<=5; $i++){
            $team_product = DB::table('product_inventory')
                ->where('teams_id', $team->id)->where('products_id', $i)->sum('amount');

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

        $update_balance = $team->increment('balance', $coin);
        $team->save();

        $status = "success";
        $message = "Berhasil menambah koin";

        return response()->json(array(
            'status' => $status,
            'message' => $message,
        ), 200);
    }   

    public function infoHutang(){
        $team = Team::find(Auth::user()->team);
        if ($team->debt_paid == 1){
            $status = "success";
            $info = "Hutang Lunas";
        } else{
            $status = "failed";
            $info = "Hutang Belum Lunas";
        }

        return response()->json(array(
            'status' => $status,
            'info' => $info
        ), 200);
    }

    public function bayarHutang(){
        $team = Team::find(Auth::user()->team);

        $status = "success";
        $info = "Hutang Lunas";

        if ($team->debt_paid == 1){
            return response()->json(array(
                'message' => "Hutang sudah lunas",
                'status' => $status,
                'info' => $info
            ), 200);
        }

        $team->debt_paid = 1;
        $team->save();


        return response()->json(array(
            'message' => "Berhasil bayar hutang",
            'status' => $status,
            'info' => $info
        ), 200);
    }

    public function upgradeInventory(Request $request){
        $id = $request->get('id');
        $up_capacity = $request->get('up_capacity');

        var_dump($id);
        var_dump($up_capacity);
    }
}
