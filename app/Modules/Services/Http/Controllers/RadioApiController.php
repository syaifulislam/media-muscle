<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Radio;
use App\RadioDetail;

class RadioApiController extends Controller
{
    public function dropdown(Request $request){
        $data = Radio::select(['id', 'name','city_id'])->where(function($q) use($request){
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
        $data = RadioDetail::select()->where(function($q) use($request){
            $q->where('radio_id',(int)$request->get('radio_id'))
            ->where('type', $request->get('type'))   
            ->where('time', $request->get('time'))
            ->where('period_start', '<=', $request->get('date'))
            ->where('period_end', '>=', $request->get('date'));
            
        })->with('radio')->first();
        if ($data == null){
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ],404);
        }
        $resp = [
            "item_name" => $data->radio->name,
            "price" => $data->price,
            "television_detail_id" => null,
            "radio_detail_id" => $data->id,
            "newspaper_detail_id" => null,
            "out_of_home_detail_id" => null,
            "period_start" => $request->get('date'),
            "period_end" => $request->get('date')
        ];
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $resp
        ],200);
    }
}
