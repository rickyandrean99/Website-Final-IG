<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefectiveProduct extends Model
{
    public $timestamps = false;
    
    public function product() {
        return $this->belongsTo("App\Product", "products_id");
    }
}
