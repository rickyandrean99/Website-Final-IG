<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use DB;
use Auth;

class InventoryController extends Controller
{
    public function upgradeInventory(Request $request){
        $id = $request->get('id');
        $up_id = $request->get('up_id');

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
            }else{
                $status = "failed";
                $message = "Kesempatan upgrade inventory produk sudah habis";
            }
        }

        return response()->json(array(
            'status' => $status,
            'message' => $message
        ), 200);
    }
}
