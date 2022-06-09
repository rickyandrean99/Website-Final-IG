<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryType extends Model
{
    public $timestamps = false;

    public function inventoryPricelists() {
        return $this->hasMany("App\InventoryPricelist", "inventory_type_id");
    }
}