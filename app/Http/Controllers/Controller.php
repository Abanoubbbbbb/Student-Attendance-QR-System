<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index ()
    {
    // $students=students::all();

        return view('welcome',compact('students'));
    }
}
