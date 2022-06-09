<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public $timestamps = false;

    public function teams() {
        return $this->belongsToMany("App\Team", "ingredient_inventory", "ingredients_id", "teams_id")->withPivot("amount");
    }

    public function products() {
        return $this->belongsToMany("App\Product", "ingredient_requirement", "ingredients_id", "products_id")->withPivot("amount");
    }
}
