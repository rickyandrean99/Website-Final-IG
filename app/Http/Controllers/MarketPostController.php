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

                //cek apakah sudah memenuhi demand atau belum
                $current_demand = DB::table('product_demand')->where('demands_id', $batch)->get();
                $current_product = DB::table('products')->where('id', $product)->get();

                if ($current_amount < $current_demand[0]->amount){
                    DB::table('transactions')->insert([
                        'teams_id' => $id,
                        'batch' => $batch,
                        'subtotal' => $current_product[0]->price *  $product_amount[$index]
                    ]);

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
            }
        }

        return response()->json(array(
            'status' => "success",
            'message' => "Berhasil menjual produk",
        ), 200);
    }
}
