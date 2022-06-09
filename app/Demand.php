<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    public $timestamps = false;

    public function products() {
        return $this->belongsToMany("App\Product", "product_demand", "demands_id", "products_id")->withPivot("amount");
    }
}
