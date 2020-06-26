<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;

class AuthController extends Controller
{
    public function page(){
        if (Sentinel::check()){
            return redirect('/dashboard');
        }
        return view("Auth::login");
    }

    public function action(Request $request)
    {
        $requestBody = $request->only(['email','password']);
        if ($request->has('remember')) {
            $auth = Sentinel::authenticateAndRemember($requestBody);
        } else {
            $auth = Sentinel::authenticateAndRemember($requestBody);
        }
        if (!$auth) {
            toastr()->error('CREDENTIALS IS NOT VALID!');
            return redirect()->back()->withInput();
        }
        toastr()->success('WELCOME BACK '.strtoupper($auth->first_name).' '.strtoupper($auth->last_name).'!');
        return redirect("/dashboard");
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect("/auth/login");
    }
}
