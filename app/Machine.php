<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    public $timestamps = false;

    public function machineTypes() {
        return $this->hasMany("App\MachineType", "machines_id");
    }

    public function products() {
        return $this->belongsToMany("App\Product", "machine_requirement", "machines_id", "products_id")->withPivot("order");
    }
}
