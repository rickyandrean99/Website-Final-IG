<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToPostController extends Controller
{
    public function dashboard() {
        $this->authorize('peserta');
        return view('index');
    }
}
