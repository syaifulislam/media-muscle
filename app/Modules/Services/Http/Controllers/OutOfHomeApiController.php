<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OutOfHome;
use App\OutOfHomeDetail;

class OutOfHomeApiController extends Controller
{
    public function dropdown(Request $request){
        $data = OutOfHome::select(['id', 'name','longitude','latitude'])->where(function($q) use($request){
            $q->where('status',1);
            if ($request->has('region') && ($request->get('region') == 'Local' || $request->get('region') == 'National')){
                $q->where('region', $request->get('region'));
            }
            if ($request->has('city_id')){
                $q->where('city_id', $request->get('city_id'));
            }
        })->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ],200);
    }

    public function get_price(Request $request){
        $data = OutOfHomeDetail::select()->where(function($q) use($request){
            $duration = $request->get('duration');
            $q->where('out_of_home_id',(int)$request->get('out_of_home_id'))
            ->where('type', $request->get('type'))   
            ->where('duration', "$duration")
            ->where('period', $request->get('period'));
            
        })->with('out_of_home')->first();
        if ($data == null){
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ],404);
        }
        $resp = [
            "item_name" => $data->out_of_home->name,
            "price" => $data->price,
            "television_detail_id" => null,
            "radio_detail_id" => null,
            "newspaper_detail_id" => null,
            "out_of_home_detail_id" => $data->id,
            "period_start" => null,
            "period_end" => null
        ];
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $resp
        ],200);
    }
}
