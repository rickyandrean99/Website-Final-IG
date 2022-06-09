<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    public function teams() {
        return $this->belongsTo("App\Team", "teams_id");
    }

    public function products() {
        return $this->belongsToMany("App\Product", "product_transaction", "transactions_id", "products_id")->withPivot("amount");
    }

    public function transportations() {
        return $this->belongsToMany("App\Transportation", "transaction_transportation", "transactions_id", "transportations_id");
    }
}
