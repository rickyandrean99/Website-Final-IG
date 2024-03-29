<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;

    public function transactions() {
        return $this->hasMany("App\Transaction", "teams_id");
    }
    
    public function transportations() {
        return $this->belongsToMany("App\Transportation", "team_transportation", "teams_id", "transportations_id")->withPivot("id", "batch", "exist");
    }

    public function ingredients() {
        return $this->belongsToMany("App\Ingredient", "ingredient_inventory", "teams_id", "ingredients_id")->withPivot("amount");
    }

    public function products() {
        return $this->belongsToMany("App\Product", "product_inventory", "teams_id", "products_id")->withPivot("id", "amount", "batch", "sigma_level");
    }

    public function machineTypes() {
        return $this->belongsToMany("App\MachineType", "team_machine", "teams_id", "machine_types_id")->withPivot("id", "batch", "defact", "level", "exist");
    }

    public function packages() {
        return $this->belongsToMany("App\Package", "team_package", "teams_id", "packages_id")->withPivot("remaining");
    }

    public function histories() {
        return $this->hasMany("App\History", "teams_id");
    }

    public function rounds() {
        return $this->belongsToMany("App\Round", "team_round", "teams_id", "rounds_id")->withPivot("six_sigma", "market_share", "profit");
    }
}
