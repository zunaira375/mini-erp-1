<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function cards()
    {
        return view('layouts.cards');
    }
    public function steps()
    {
        return view('layouts.progress-steps');
    }
    public function search()
    {
        return view('layouts.search-wizard');
    }
    public function blurry()
    {
        return view('layouts.blurryloading');
    }
    public function scroll()
    {
        return view('layouts.blurryloading');
    }
    public function split()
    {
        return view('layouts.splitpage');
    }




}

