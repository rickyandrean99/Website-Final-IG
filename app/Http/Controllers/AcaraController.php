<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Demand;
use App\Team;
use App\Product;
use App\DefectiveProduct;
use App\Events\UpdateDemand;
use Illuminate\Http\Response;
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
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        } else if (Auth::user()->role == "pasar") {
            return redirect()->route('market');
        } else if (Auth::user()->role == "administrator"){
            return redirect()->route('batch');
        }

        //leaderboard
        $teams = Team::all();
        $leaderboard = [];

        foreach($teams as $team) {
            $get = DB::table('transactions')->where('teams_id', $team->id)->get();

            $total_product = 0;
            foreach($get as $trans){
                $amount = DB::table('product_transaction')
                    ->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->sum('amount');
                $total_product += $amount;
            }

            $sigma_team = 0;
            foreach($get as $trans){
                $get2 = DB::table('product_transaction')
                    ->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->get();
                foreach($get2 as $detail){
                    $amount = $detail->amount;
                    $sigma = $detail->sigma_level;
                    
                    $calculate = $amount / $total_product * $sigma;
                    $sigma_team += $calculate;
                }
            }

            $leaderboard[$team->name] = round($sigma_team,2);
        }

        // sorting
        arsort($leaderboard);
        
        $batch = Batch::find(1)->batch;
        $demands = (Demand::find($batch))->products()->wherePivot('amount', '!=', 0)->get();
        $umkm = (DefectiveProduct::find($batch))->sell_price;
        $denda = (DefectiveProduct::find($batch))->penalty_price;
        $price = [];
        foreach($demands as $demand){
            $p = DB::table('product_batchs')->where('id', $batch)->where('products_id',$demand->id)->sum('price');
            array_push($price, $p);
        }

        $time = Batch::find(1)->time;
        return view('demand', compact('batch', 'demands', 'umkm', 'denda', 'price', 'leaderboard', 'time'));
    }

    public function updateDemand(Request $request){
        $batch = Batch::find(1)->batch;
        $id = $request->get('id');
        $demand = (int)$request->get('demand');

        
        DB::table('product_demand')->where('products_id', $id)->where('demands_id', $batch)->update(["amount" => $demand]);
        
        //pusher ke demand
        $demands = DB::table('product_demand')->join('products', 'products.id', '=', 'product_demand.products_id')->where('demands_id', $batch)->where('amount', '!=', 0)->get();
        $price = [];
        foreach($demands as $demand){
            $p = DB::table('product_batchs')->where('id', $batch)->where('products_id',$demand->id)->sum('price');
            array_push($price, $p);
        }
        $new_timer = Batch::find(1)->time;

        event(new UpdateDemand($demands, $batch, $price, $new_timer));

        return response()->json(array(
            'status' => 'success',
            'message' => "Demand berhasil di update!"
        ), 200);
    }
}
