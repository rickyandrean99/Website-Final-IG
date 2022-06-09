<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryPricelist extends Model
{
    public $timestamps = false;

    public function inventoryType() {
        return $this->belongsTo("App\InventoryType", "inventory_type_id");
    }
}
