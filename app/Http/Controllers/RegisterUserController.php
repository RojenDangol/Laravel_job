<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function store(){
        dd(request()->all());
    }
}
