<?php

namespace App\Modules\Whitelist\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;

class WhitelistController extends Controller
{

    public function city(){
        $data = City::select(['id','name'])->orderBy('name','asc')->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
