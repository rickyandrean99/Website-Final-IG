<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpgradePostController extends Controller
{
    public function dashboard() {
        $this->authorize('panitia');
        return view('test');
    }
}
