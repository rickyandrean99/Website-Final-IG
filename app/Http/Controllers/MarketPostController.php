<?php

namespace App\Http\Controllers;
use App\Product;
use App\Batch;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketPostController extends Controller
{
    public function dashboard(){
        $this->authorize('peserta'); //jangan lupa diganti

        $products = Product::all();
        // dd($products);
        return view('market', compact('products'));
    }

    public function sellProduct(Request $request){
        $id = $request->get('id');
        $product_id = $request->get('product_id');
        $product_amount = $request->get('product_amount');
        $batch = Batch::find(1)->batch;
        $subtotal = 0;

        foreach ($product_id as $index => $product) {
            if($product_amount[$index] > 0){
                $batch_amount = DB::table('transactions')
                    ->where('teams_id', $id)
                    ->where('batch', $batch)->get();
                
                $current_amount = $product_amount[$index];
                
                //cek jumlah sebelumnya + jumlah saat ini
                if(count($batch_amount) > 0){
                    foreach($batch_amount as $i){
                        $transaction = DB::table('product_transaction')
                        ->where('transactions_id', $i->id)
                        ->where('products_id', $product)->get();
                        if(count($transaction)> 0){
                            $current_amount += $transaction[0]->amount; 
                        }
                    }
                }
                // var_dump($current_amount);

                $current_demand = DB::table('product_demand')->where('demands_id', $batch)->get();

                $current_price = DB::table('product_batchs')
                    ->where('products_id', $product)->where('id', $batch)->get();

                $product_teams = DB::table('product_inventory')
                ->where('teams_id', $id)
                ->where('products_id', $product)->get();
                
                $product_team = 0;
                foreach ($product_teams as $value) {
                    $product_team += $value->amount;
                }

                //cek apakah produk cukup atau tidak
                if($product_amount[$index] <= $product_team){
                    //cek apakah sudah memenuhi demand atau belum
                    if ($current_amount <= $current_demand[0]->amount){
                        DB::table('transactions')->insert([
                            'teams_id' => $id,
                            'batch' => $batch,
                            'subtotal' => $current_price[0]->price *  $product_amount[$index]
                        ]);
                        
                        // kurangi produk inventory
                        $amount = $product_amount[$index];
                        foreach($product_teams as $team){
                            if ($amount == 0){
                                break;
                            }
                            else if($amount <= $team->amount){
                                DB::table('product_inventory')
                                ->where('teams_id', $id)
                                ->where('products_id', $product)
                                ->where('batch', $team->batch)
                                ->decrement('amount', $amount);

                                $amount = 0;
                            }
                            else{
                                $amount -= $team->amount;
                                DB::table('product_inventory')
                                ->where('teams_id', $id)
                                ->where('products_id', $product)
                                ->where('batch', $team->batch)
                                ->decrement('amount', $team->amount);
                            }
                        }

                        $subtotal += $current_price[0]->price *  $product_amount[$index];
    
                        $get_id = DB::table('transactions')->select('id')->orderBy('id', 'desc')->get();
                        $get_id = $get_id[0]->id;
    
                        DB::table('product_transaction')->insert([
                            'products_id' => $product,
                            'transactions_id' => $get_id,
                            'amount' => $product_amount[$index]
                        ]);
    
                    }else{
                        return response()->json(array(
                            'status' => "failed",
                            'message' => "Demand produk sudah terpenuhi",
                        ), 200); 
                    }
                }else{
                    return response()->json(array(
                        'status' => "failed",
                        'message' => "Produk kurang",
                    ), 200);
                }
            }
        }

        return response()->json(array(
            'status' => "success",
            'message' => "Berhasil menjual produk, tim mendapatkan koin sejumlah $subtotal TC" ,
        ), 200);
    }

    public function updateMarket(Request $request){
        $batch = $request->get('batch');
        $keripik = [];
        $dodol = [];
        $sari = [];
        $selai = [];
        $cuka = [];
        $jumlah = [];
        $subtotal = [];

        for($i = 1; $i <= 10; $i++){
            //tambah subtotal
            $sub_team = DB::table('transactions')->where('teams_id', $i)->where('batch', $batch)->sum('subtotal');
            $sub_team = (int)$sub_team;
            array_push($subtotal, $sub_team);
            
            $transactions = DB::table('transactions')->where('teams_id', $i)->where('batch', $batch)->get();
            $jumlah_team = 0;
            $keripik_team = 0;
            $dodol_team = 0;
            $sari_team = 0;
            $selai_team = 0;
            $cuka_team = 0;

            if(count($transactions) > 0){
                //tambah jumlah team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')
                        ->where('transactions_id', $transaction->id)->get();
                    $jumlah_team += $amount[0]->amount;
                }

                //tambah keripik team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')
                        ->where('products_id', 1)
                        ->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $keripik_team += $amount[0]->amount;
                    }
                }
                
                //tambah dodol team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')
                        ->where('products_id', 2)
                        ->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $dodol_team += $amount[0]->amount;
                    }
                }

                //tambah sari team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')
                        ->where('products_id', 3)
                        ->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $sari_team += $amount[0]->amount;
                    }
                }

                //tambah selai team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')
                        ->where('products_id', 4)
                        ->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $selai_team += $amount[0]->amount;
                    }
                }

                //tambah cuka team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')
                        ->where('products_id', 5)
                        ->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $cuka_team += $amount[0]->amount;
                    }
                }
            }

            array_push($jumlah, $jumlah_team);
            array_push($keripik, $keripik_team);
            array_push($dodol, $dodol_team);
            array_push($sari, $sari_team);
            array_push($selai, $selai_team);
            array_push($cuka, $cuka_team);
        }
        
        return response()->json(array(
            'keripik' => $keripik,
            'dodol' => $dodol,
            'sari' => $sari,
            'selai' => $selai,
            'cuka' => $cuka,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ), 200);
    }
}
