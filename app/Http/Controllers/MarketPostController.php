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
            if($product_amount[0] > 0){
                $batch_amount = DB::table('transactions')
                    ->where('teams_id', $id)
                    ->where('batch', $batch)->get();
                
                $current_amount = $product_amount[0];

                //cek jumlah sebelumnya + jumlah saat ini
                if(count($batch_amount) > 0){
                    foreach($batch_amount as $i){
                        $transaction = DB::table('product_transaction')
                            ->where('transaction_id', $i->id)
                            ->where('products_id', $product)->get();
                        $current_amount += $transaction; 
                    }
                }

                //cek apakah sudah memenuhi demand atau belum
                $current_demand = DB::table('product_demand')->where('demands_id', $batch)->get();

                if ($current_amount < $current_demand[0]->amount){

                }else{
                    $status : "failed";
                    $message : 
                }
            }
        }

    }
}
