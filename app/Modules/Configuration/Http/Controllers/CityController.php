<?php

namespace App\Modules\Configuration\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\City;

class CityController extends Controller
{
    public function index()
    {
        $data = City::get()->pluck('name');
        return view("Configuration::city.index", compact('data'));
    }
}
