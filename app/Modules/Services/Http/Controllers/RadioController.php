<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Radio;
use App\RadioDetail;
use Sentinel;

class RadioController extends Controller
{
    public function index(){
        $perPage = 10;
        $data = Radio::with(['city'=>function($q){
            $q->select(['id','name']);
        }])->orderBy('created_at','desc')->paginate($perPage);
        return view("Services::radio.index",compact('data'));
    }

    public function form($id = null){
        if ($id !== null){
            $data = Radio::where('id',(int)$id)->first();
            return view("Services::radio.form")->with('data', $data);
        }
        return view("Services::radio.form");
    }

    public function post(Request $request){
        $created = Sentinel::getUser()->id;
        $body = $request->except(['_token','id']);
        $body['updated_by'] = $created;
        if ($request->all()['id'] === null){
            $body['created_by'] = $created;
            $data = Radio::create($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/radio/form/'.$data['id']);
        } else {
            Radio::where('id',(int)$request->all()['id'])->update($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/radio/form/'.$request->all()['id']);
        }
    }

    public function detail($id){
        $perPage = 100;
        $data = RadioDetail::where('radio_id',$id)->orderBy('period_start','desc')->paginate($perPage);
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_radio($id){
        $data = RadioDetail::where('id',$id)->first();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_post($id,Request $request){
        $created = Sentinel::getUser()->id;
        if ($request->all()['id'] === null){
            $body = $request->except(['_token','id']);
            $body['radio_id'] = $id;
            $body['created_by'] = $created;
            $body['updated_by'] = $created;
            $periodExplode = explode(' - ',$body['period']);
            RadioDetail::create([
                'radio_id' => $body['radio_id'],
                'period_start' => $periodExplode[0],
                'period_end' => $periodExplode[1],
                'time' => $body['time'],
                'type' => $body['type'],
                'price' => $body['price'],
                'created_by' => $body['created_by'],
                'updated_by' => $body['updated_by'],
            ]);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        } else {
            $body = $request->except(['_token','id']);
            $periodExplode = explode(' - ',$body['period']);
            RadioDetail::where('id',(int)$request->only('id'))->update([
                'period_start' => $periodExplode[0],
                'period_end' => $periodExplode[1],
                'time' => $body['time'],
                'type' => $body['type'],
                'price' => $body['price'],
                'updated_by' => $created,
            ]);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        }
    }
}
