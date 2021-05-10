<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function toDrive($age){
        return view("hello", ["age" => $age]);
    }

    public function home(){
        return view("home"); 
    }
}
