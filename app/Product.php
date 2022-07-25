<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    public function teams() {
        return $this->belongsToMany("App\Team", "product_inventory", "products_id", "teams_id")->withPivot("id", "amount", "batch", "sigma_level");
    }

    public function ingredients() {
        return $this->belongsToMany("App\Ingredient", "ingredient_requirement", "products_id", "ingredients_id")->withPivot("amount");
    }

    public function demands() {
        return $this->belongsToMany("App\Demand", "product_demand", "products_id", "demands_id")->withPivot("amount");
    }

    public function transactions() {
        return $this->belongsToMany("App\Transaction", "product_transaction", "products_id", "transactions_id")->withPivot("amount", "sigma_level");
    }

    public function machines() {
        return $this->belongsToMany("App\Machine", "machine_requirement", "products_id", "machines_id")->withPivot("order");
    }
}
