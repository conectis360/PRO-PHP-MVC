<?php

namespace App\Http\Controllers;

class ShowHomeController {
    public function handle() {
        return view('home', ['number' => 42]);
    }
}