<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OutOfHome;
use App\OutOfHomeDetail;
use Sentinel;

class OutOfHomeController extends Controller
{
    public function index(){
        $perPage = 10;
        $data = OutOfHome::with(['city' => function($q){
            $q->select(['id','name']);
        }])->orderBy('created_at','desc')->paginate($perPage);
        return view("Services::ooh.index",compact('data'));
    }

    public function form($id = null){
        if ($id !== null){
            $data = OutOfHome::where('id',(int)$id)->first();
            return view("Services::ooh.form")->with('data', $data);
        }
        return view("Services::ooh.form");
    }

    public function post(Request $request){
        $created = Sentinel::getUser()->id;
        $body = $request->except(['_token','id']);
        $body['updated_by'] = $created;
        if ($request->all()['id'] === null){
            $body['created_by'] = $created;
            $data = OutOfHome::create($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/out-of-home/form/'.$data['id']);
        } else {
            OutOfHome::where('id',(int)$request->all()['id'])->update($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/out-of-home/form/'.$request->all()['id']);
        }
    }

    public function detail($id){
        $perPage = 100;
        $data = OutOfHomeDetail::where('out_of_home_id',$id)->orderBy('created_at','desc')->paginate($perPage);
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_ooh($id){
        $data = OutOfHomeDetail::where('id',$id)->first();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_post($id,Request $request){
        $created = Sentinel::getUser()->id;
        if ($request->all()['id'] === null){
            $body = $request->except(['_token','id']);
            $body['out_of_home_id'] = $id;
            $body['created_by'] = $created;
            $body['updated_by'] = $created;
            OutOfHomeDetail::create([
                'out_of_home_id' => $body['out_of_home_id'],
                'type' => $body['type'],
                'period' => $body['period'],
                'duration' => $body['duration'],
                'price' => $body['price'],
                'created_by' => $body['created_by'],
                'updated_by' => $body['updated_by'],
            ]);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        } else {
            $body = $request->except(['_token','id']);
            OutOfHomeDetail::where('id',(int)$request->only('id')['id'])->update([
                'type' => $body['type'],
                'period' => $body['period'],
                'duration' => $body['duration'],
                'price' => $body['price'],
                'updated_by' => $created,
            ]);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        }
    }
}
