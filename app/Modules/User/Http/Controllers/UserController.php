<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Sentinel;

class UserController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = 10;
        $data = User::orderBy('created_at','desc')->paginate($perPage);
        return view("User::index",compact('data'));
    }

    public function form(){
        return view("User::form");
    }

    public function store(Request $request){
        $req = $request->except(['_token','confirmPassword','id']);
        if ($request->input('id')){
            $findById = Sentinel::findById($request->input('id'));
            Sentinel::update($findById, $req);
        } else {
            $pass = $request->get('password');
            $Cpass = $request->get('confirmPassword');
            if ($pass !== $Cpass){
                toastr()->error('PASSWORD AND CONFIRMATION PASSWORD NOT MATCH!');
                return redirect()->back()->withInput();
            }
            $findByEmail = User::where('email',$req['email'])->first();
            if ($findByEmail){
                toastr()->error('THIS EMAIL HAS BEEN REGISTERED!');
                return redirect()->back()->withInput();
            }
            $user = Sentinel::register($req);
        }
        toastr()->success('YOUR POST HAS BEEN SUBMITED!');
        return redirect("/user");
    }

    public function view($id){
        $data = User::where('id',$id)->first();
        if (!$data){
            toastr()->error('USER NOT FOUND!');
            return redirect()->back()->withInput();
        }
        return view("User::form",compact('data'));
    }
}
