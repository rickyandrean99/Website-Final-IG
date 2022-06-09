<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOcassion extends Model
{
    public $timestamps = false;

    public function product() {
        return $this->belongsTo("App\Product", "products_id");
    }

    public function ingredient() {
        return $this->belongsTo("App\Ingredient", "ingredients_id");
    }
}
