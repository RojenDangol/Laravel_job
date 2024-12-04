<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(){
        // dd(request()->all());
        $attributes = request()->validate([
            'email'=>['required','email'],
            'password'=>['required'],
        ]);

        if(! Auth::attempt($attributes)){
            throw ValidationException::withMessages([
                'email'=>'Sorry those credientials do not match'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/jobs');
    }

    public function destroy(){
        Auth::logout();

        return redirect('/');
    }
}
