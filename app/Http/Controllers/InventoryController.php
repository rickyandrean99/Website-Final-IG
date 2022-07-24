<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Batch;
use DB;
use Auth;

class InventoryController extends Controller
{
    public function upgradeInventory(Request $request){
        $id = $request->get('id');
        $up_id = $request->get('up_id');
        $batch = Batch::find(1)->batch;

        $pilih = DB::table('inventory_pricelists')->where('inventory_type_id', $id)->where('id', $up_id)->get();

        $team = Team::find(Auth::user()->team);
        if($id == 1){
            if($team->upgrade_ingredient_limit == 1){
                $team->inventory_ingredient_rent = $pilih[0]->rent_price;
                $team->ingredient_inventory = $pilih[0]->upgrade_capacity;
                $team->balance -= $pilih[0]->upgrade_price;
                $team->upgrade_ingredient_limit = 0;
                $team->save();

                $status = "success";
                $message = "Berhasil upgrade inventory bahan baku";

                //tambah history upgrade inventory bahan baku
                DB::table('histories')->insert([
                    "teams_id" => $team->id,
                    "kategori" => "UPGRADE",
                    "batch" => $batch,
                    "type" => "OUT",
                    "amount" => $pilih[0]->upgrade_price,
                    "keterangan" => "Berhasil upgrade inventory bahan baku seharga ".$pilih[0]->upgrade_price." TC"
                ]);
            }
            else{

                $status = "failed";
                $message = "Kesempatan upgrade inventory bahan baku sudah habis";
            }
        }
        else{
            if($team->upgrade_product_limit == 1){
                $team->inventory_product_rent = $pilih[0]->rent_price;
                $team->product_inventory = $pilih[0]->upgrade_capacity;
                $team->balance -= $pilih[0]->upgrade_price;
                $team->upgrade_product_limit = 0;
                $team->save();

                $status = "success";
                $message = "Berhasil upgrade inventory produk";

                //tambah history upgrade inventory bahan baku
                DB::table('histories')->insert([
                    "teams_id" => $team->id,
                    "kategori" => "UPGRADE",
                    "batch" => $batch,
                    "type" => "OUT",
                    "amount" => $pilih[0]->upgrade_price,
                    "keterangan" => "Berhasil upgrade inventory produk seharga ".$pilih[0]->upgrade_price." TC"
                ]);
            }else{
                $status = "failed";
                $message = "Kesempatan upgrade inventory produk sudah habis";
            }
        }

        $team = Team::find(Auth::user()->team);
        $balance = $team->balance;

        return response()->json(array(
            'balance' => $balance,
            'status' => $status,
            'message' => $message
        ), 200);
    }
}
