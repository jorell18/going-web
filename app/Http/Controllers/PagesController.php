<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function loginPage(){
        return view('pages.login');
    }

    public function signupPage(){
        return view('pages.register');
    }
}
