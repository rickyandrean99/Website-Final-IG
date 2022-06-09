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
        return $this->belongsToMany("App\Transportation", "team_transportation", "teams_id", "transportations_id")->withPivot("batch", "exist");
    }

    public function ingredients() {
        return $this->belongsToMany("App\Team", "ingredient_inventory", "teams_id", "ingredients_id")->withPivot("amount");
    }

    public function products() {
        return $this->belongsToMany("App\Product", "product_inventory", "teams_id", "products_id")->withPivot("amount");
    }

    public function machineTypes() {
        return $this->belongsToMany("App\MachineType", "team_machine", "teams_id", "machine_types_id")->withPivot("batch", "defact", "level");
    }

    public function packages() {
        return $this->belongsToMany("App\Package", "team_package", "teams_id", "packages_id")->withPivot("remaining");
    }
}
