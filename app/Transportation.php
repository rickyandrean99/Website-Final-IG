<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    public $timestamps = false;

    public function transactions() {
        return $this->belongsToMany("App\Transaction", "transaction_transportation", "transportations_id", "transactions_id");
    }

    public function teams() {
        return $this->belongsToMany("App\Team", "team_transportation", "transportations_id", "teams_id")->withPivot("batch", "exist");
    }
}
