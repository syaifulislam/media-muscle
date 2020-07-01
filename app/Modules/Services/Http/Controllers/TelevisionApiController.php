<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Television;
use App\TelevisionDetail;

class TelevisionApiController extends Controller
{
    

    public function dropdown(Request $request){
        $data = Television::select(['id', 'name','period_start','period_end'])->where(function($q) use($request){
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
        $duration = $request->get('duration');
        $position = $request->get('position');
        $time = $request->get('time');
        $television_detail_id = $request->get('television_program_id');
        $data = TelevisionDetail::where(function($q) use($request){
            $television_id = $request->get('television_id');
            $television_detail_id = $request->get('television_program_id');
            $time = $request->get('time');
            $q->where('id', (int)$television_detail_id)
            ->where('television_id', (int)$television_id)
            ->where('time', $time);
        })->first();
        if ($data == null){
            return response()->json([
                'code' => 404,
                'message' => 'Data not found'
            ],404);
        }
        $price = 0;
        $price_multiple = 1;
        if ($duration == 30) $price_multiple = 2;
        else if ($duration == 45) $price_multiple = 3;
        else if ($duration == 60) $price_multiple = 4;


        if ($position == 'Premium') {
            $price = $data['premium_price'] * $price_multiple;
        } else {
            $price = $data['run_price'] * $price_multiple;
        }

        $resp = [
            "item_name" => $data['program_name'],
            "price" => $price,
            "television_detail_id" => $television_detail_id,
            "radio_detail_id" => null,
            "newspaper_detail_id" => null,
            "out_of_home_detail_id" => null,
            "period_start" => null,
            "period_end" => null
        ];
        
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $resp
        ],200);
    }

    public function get_program($id,Request $request){
        $data = TelevisionDetail::select(['id','date','program_name','time_start','time_end','premium_price','run_price','duration'])
        ->where(function($q) use($id,$request){
            $q->where('television_id', (int)$id);

            if ($request->has('date')){
                $q->where('date', $request->get('date'));
            }

            if ($request->has('time') && ($request->get('time') == 'Prime' || $request->get('time') == 'Non Prime')){
                $q->where('time', $request->get('time'));
            }
        })->get();
        $dataResp = $this->generate_program($data);
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $dataResp
        ],200);
    }

    private function generate_program($data){
        $initateProgramTime = [];
        for($i = 0; $i <= 23; $i++){
            if ($i < 10){
                array_push($initateProgramTime,['id' => null, 'program_name' => '', 'time_start' => "0$i:00",'time_end' => "0$i:15"],['id' => null, 'program_name' => '', 'time_start' => "0$i:30",'time_end' => "0$i:45"]);
            } else {
                array_push($initateProgramTime,['id' => null, 'program_name' => '', 'time_start' => "$i:00",'time_end' => "$i:15"],['id' => null, 'program_name' => '', 'time_start' => "$i:30",'time_end' => "$i:45"]);
            }
        }
        foreach($initateProgramTime as $key => $item){
            foreach($data as $row){
                if ($initateProgramTime[$key]['time_start'] >= $row['time_start'] && $initateProgramTime[$key]['time_end'] <= $row['time_end']){
                    $initateProgramTime[$key]['id'] = $row['id'];
                    $initateProgramTime[$key]['program_name'] = $row['program_name'];
                }
            }
        }
        return $initateProgramTime;
    }
}
