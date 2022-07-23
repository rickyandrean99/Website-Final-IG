<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    public $timestamps = false;

    public function teams() {
        return $this->belongsToMany("App\Team", "team_round", "rounds_id", "teams_id")->withPivot("six_sigma", "market_share", "profit");
    }

    public function ingredients() {
        return $this->belongsToMany("App\Ingredient", "import_ingredient", "rounds_id", "ingredients_id")->withPivot("amount");
    }
}
