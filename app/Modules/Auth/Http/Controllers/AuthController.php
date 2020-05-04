<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function page(){
        return view("Auth::login");
    }

    public function action(){
        return redirect("/dashboard");
    }

    public function logout(){
        return redirect("/auth/login");
    }
}
