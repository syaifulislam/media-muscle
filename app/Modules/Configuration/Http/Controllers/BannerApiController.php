<?php

namespace App\Modules\Configuration\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;

class BannerApiController extends Controller
{
    public function get_banner(){
        $limit = 5;
        $data = Banner::select(['name','url'])->where('status', 1)->limit($limit)->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ],200);
    }
}
