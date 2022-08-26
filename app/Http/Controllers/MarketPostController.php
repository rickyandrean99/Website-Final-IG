<?php

namespace App\Http\Controllers;
use App\Product;
use App\Batch;
use App\Team;
use App\Demand;
use App\Events\UpdateDemand;
use App\Events\UpdateMarket;
use App\Events\UpdateLeaderboard;
use App\Transaction;
use App\Transportation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendCoin;
use Carbon\Carbon;

class MarketPostController extends Controller
{
    public function dashboard(){
        if (Auth::user()->role == "peserta"){
            return redirect()->route('peserta');
        } else if (Auth::user()->role == "upgrade") {
            return redirect()->route('upgrade');
        }

        $products = Product::all();
        $transportations = Transportation::all();
        $teams = Team::all();
        return view('market', compact('products', 'transportations', 'teams'));
    }

    public function sellProduct(Request $request){
        $id = $request->get('id');
        $team = Team::find($id);
        $product_id = $request->get('product_id');
        $product_amount = $request->get('product_amount');
        $transportation_id = $request->get('transportation_id');
        $transportation_amount = $request->get('transportation_amount');
        $metode = $request->get('metode');
        $capacity = $request->get('capacity');
        $batch = Batch::find(1)->batch;
        $preparation = Batch::find(1)->preparation;
        $subtotal = 0;
        $longest_duration = 0;
        $detail = "Berhasil Menjual ";

        if(array_sum($product_amount) > $capacity){
            return response()->json(array(
                'status' =>  "failed",
                'message' => "Kapasitas transportasi kurang",
            ), 200);
        }

        $denda = $capacity - array_sum($product_amount);
        $ongkir = 0;

        //mengecek apakah transportasi dimiliki tim atau tidak
        foreach ($transportation_id as $index => $transportation){
            if($transportation_amount[$index] > 0){
                $transportation_team = DB::table('team_transportation')->where('teams_id', $id)->where('transportations_id', $transportation)->where('exist', 1)->get();

                //hitung ongkir
                $trans = Transportation::where('id', $index + 1)->first();

                if($metode == 1){
                    $ongkir += $transportation_amount[$index] * $trans->self_price;
                    if ($trans->self_duration > $longest_duration) $longest_duration = $trans->self_duration;
                }else{
                    $ongkir += $transportation_amount[$index] * $trans->delivery_price;
                    if ($trans->delivery_duration > $longest_duration) $longest_duration = $trans->delivery_duration;
                }

                if($transportation_amount[$index] > count($transportation_team)){
                    return response()->json(array(
                        'status' =>  "failed",
                        'message' => "Transportasi yang dipilih tidak dimiliki",
                    ), 200);
                }
            }
        }


        //mengecek apakah bisa jual atau tidak
        foreach ($product_id as $index => $product){
            if($product_amount[$index] > 0){

                $current_demand = DB::table('product_demand')->where('products_id', $product)->where('demands_id', $batch)->get();
                $current_price = DB::table('product_batchs')->where('products_id', $product)->where('id', $batch)->get();
                $name = Product::find($product)->name;

                //isinya jumlah produk dengan ID terkecil yang amountnya tidak 0
                $product_team = $team->products()->wherePivot('products_id', $product)->where('amount', '>', 0)->first()->pivot->amount;

                //cek apakah produk cukup atau tidak
                if($product_amount[$index] <= $product_team){
                    //cek apakah sudah memenuhi demand atau belum
                    if ($product_amount[$index] <= $current_demand[0]->amount){
                        $subtotal += $current_price[0]->price *  $product_amount[$index];
                        $amount = $product_amount[$index];
                        $detail .= "$name ($amount), ";
                    }else{
                        return response()->json(array(
                            'status' =>  "failed",
                            'message' => "Demand produk sudah terpenuhi",
                        ), 200);
                    }
                }else{
                    return response()->json(array(
                        'status' =>  "failed",
                        'message' => "Gagal. Jenis produk dengan sigma terkecil harus dihabiskan terlebih dahulu",
                    ), 200);
                }
            }
        }

        //hitung total yak => subtotal - ongkir - denda
        $total = $subtotal - $ongkir - $denda;
        $detail .= "seharga $subtotal TC. Ongkir $ongkir TC. Denda $denda TC. Perusahaan mendapatkan $total TC";

        //jual produk
        //masukkan ke transaksi baru
        $time_now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('transactions')->insert([
            'teams_id' => $id,
            'batch' => $batch,
            'subtotal' => $subtotal,
            'total' => $total,
            'received' => 0,
            'delivered_time' => Carbon::parse($time_now)->addSeconds($longest_duration)->format('Y-m-d H:i:s'),
        ]);
        
        $transaction_id = DB::table('transactions')->select('id')->orderBy('id', 'desc')->get();
        $transaction_id = $transaction_id[0]->id;

        // Menambahkan Histori
        DB::table('histories')->insert([
            "teams_id" => $id,
            "kategori" => "PENJUALAN",
            "batch" => $batch,
            "type" => "IN",
            "amount" => $total,
            "keterangan" => $detail
        ]);
        
        // Jalankan job untuk mengirimkan TC secara otomatis berdasarkan durasi transportasi terlama
        dispatch(new SendCoin($id, $transaction_id, $total))->delay(now()->addSeconds($longest_duration));

        //masukkan ke transaksi produk (row sesuai dengan jumlah jenis produk)
        foreach ($product_id as $index => $product) {
            
            
            if($product_amount[$index] > 0){
                //keluarkan sigma level
                $sigma_level = ($team->products()->wherePivot('products_id', $product)->where('amount', '>', 0)->first()->pivot->sigma_level) / 100;

                //kurangi demand
                DB::table('product_demand')->where('products_id', $product)->where('demands_id', $batch)->decrement('amount', $product_amount[$index]);
                
                // kurangi produk inventory
                $amount = $product_amount[$index];
                $prod_id = $team->products()->wherePivot('products_id', $product)->where('amount', '>', 0)->first()->pivot->id;
                
                $team->products()->wherePivot('products_id', $product)->wherePivot('id', $prod_id)->decrement('amount', $amount);

                
                //masukkan ke transaksi produk
                DB::table('product_transaction')->insert([
                    'products_id' => $product,
                    'transactions_id' => $transaction_id,
                    'amount' => $product_amount[$index],
                    'sigma_level'=> $sigma_level
                ]);
            }
        }

        $get = DB::table('transactions')->where('teams_id', $id)->where('batch', $batch)->get();

        $total_product = 0;
        foreach($get as $trans){
            $amount = DB::table('product_transaction')->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->sum('amount');
            $total_product += $amount;
        }

        $sigma_team = 0;
        foreach($get as $trans){
            $get2 = DB::table('product_transaction')->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->get();
            foreach($get2 as $detail){
                $amount = $detail->amount;
                $sigma = $detail->sigma_level;
                
                $calculate = $amount / $total_product * $sigma;
                $sigma_team += $calculate;
            }
        }

        $sigma_team = round($sigma_team,2);

        //update sigma level
        DB::table('team_round')->where('teams_id', $id)->where('rounds_id', $batch)->update(['six_sigma'=>$sigma_team]);

        $status = "success";
        $message = "Berhasil menjual produk, detail transaksi:\n
                -Hasil jual produk: $subtotal TC\n
                -Ongkos kirim: $ongkir TC\n
                -Denda: $denda TC\n\nSehingga perusahaan mendapatkan koin sejumlah $total TC";

        //pusher ke demand
        $demands = DB::table('product_demand')->join('products', 'products.id', '=', 'product_demand.products_id')->where('demands_id', $batch)->where('amount', '!=', 0)->get();
        $price = [];
        foreach($demands as $demand){
            $p = DB::table('product_batchs')->where('id', $batch)->where('products_id',$demand->id)->sum('price');
            array_push($price, $p);
        }
        $new_timer = Batch::find(1)->time;
        event(new UpdateDemand($demands, $batch, $price, $new_timer, $preparation));
        
        //update leaderboard
        $leaderboard = self::calculateSigma();
        event(new UpdateLeaderboard($leaderboard));

        //pusher ke tim
        event(new UpdateMarket($team->id, $sigma_team));

        return response()->json(array(
            'status' => $status,
            'message' => $message
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
                    $amount = DB::table('product_transaction')->where('transactions_id', $transaction->id)->sum('amount');
                    $jumlah_team += $amount;
                }

                //tambah keripik team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')->where('products_id', 1)->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $keripik_team += $amount[0]->amount;
                    }
                }
                
                //tambah dodol team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')->where('products_id', 2)->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $dodol_team += $amount[0]->amount;
                    }
                }

                //tambah sari team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')->where('products_id', 3)->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $sari_team += $amount[0]->amount;
                    }
                }

                //tambah selai team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')->where('products_id', 4)->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $selai_team += $amount[0]->amount;
                    }
                }

                //tambah cuka team
                foreach($transactions as $transaction){
                    $amount = DB::table('product_transaction')->where('products_id', 5)->where('transactions_id', $transaction->id)->get();
                    if(count($amount) >0){
                        $cuka_team += $amount[0]->amount;
                    }
                }
            }

            $jumlah_team = ($jumlah_team - $selai_team) - $cuka_team;

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

    public function calculateSigma(){
        $teams = Team::all();
        $leaderboard = [];

        foreach($teams as $team) {
            $get = DB::table('transactions')->where('teams_id', $team->id)->get();

            $total_product = 0;
            foreach($get as $trans){
                $amount = DB::table('product_transaction')->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->sum('amount');
                $total_product += $amount;
            }

            $sigma_team = 0;
            foreach($get as $trans){
                $get2 = DB::table('product_transaction')->where('transactions_id', $trans->id)->whereNotIn('products_id', [4,5])->get();
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

        return($leaderboard);
    }
}
