<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    public $timestamps = false;

    public function machine() {
        return $this->belongsTo("App\Machine", "machines_id");
    }

    public function teams() {
        return $this->belongsToMany("App\Team", "team_machine", "machine_types_id", "teams_id")->withPivot("id", "batch", "defact", "level", "exist");
    }
}
