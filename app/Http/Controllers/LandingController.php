<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    //
    public function home(){
        return view('landing.index');
    }

    public function about(){
        return view('landing.about');
    }

}
