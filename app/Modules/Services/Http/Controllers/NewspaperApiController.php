<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Newspaper;
use App\NewspaperDetail;

class NewspaperApiController extends Controller
{
    public function dropdown(Request $request){
        $data = Newspaper::select(['id', 'name'])->where(function($q) use($request){
            $q->where('status',1);
            if ($request->has('region') && ($request->get('region') == 'Local' || $request->get('region') == 'National')){
                $q->where('region', $request->get('region'));
            }
        })->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ],200);
    }

    public function get_price(Request $request){
        $data = NewspaperDetail::select()->where(function($q) use($request){
            $q->where('newspaper_id',(int)$request->get('newspaper_id'))
            ->where('size', $request->get('size'))   
            ->where('position', $request->get('position'))
            ->where('period_start', '<=', $request->get('date'))
            ->where('period_end', '>=', $request->get('date'));
            
        })->with('newspaper')->first();
        if ($data == null){
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ],404);
        }
        $resp = [
            "item_name" => $data->newspaper->name,
            "price" => $data->price,
            "television_detail_id" => null,
            "radio_detail_id" => null,
            "newspaper_detail_id" => $data->id,
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
