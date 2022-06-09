<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $timestamps = false;

    public function teams() {
        return $this->belongsToMany("App\Team", "team_package", "package_id", "teams_id")->withPivot("remaining");
    }
}
