<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Television;
use App\TelevisionDetail;
use Sentinel;

class TelevisionController extends Controller
{
    public function index(){
        $perPage = 10;
        $data = Television::orderBy('created_at','desc')->paginate($perPage);
        return view("Services::television.index",compact('data'));
    }

    public function form($id = null){
        if ($id !== null){
            $data = Television::where('id',(int)$id)->first();
            $newData = [
                'id' => $data['id'],
                'name' => $data['name'],
                'period' => $data['period_start']." - ".$data['period_end'],
                'p_start' => $data['period_start'],
                'p_end' => $data['period_end'],
                'region' => $data['region'],
                'status' => $data['status'],
            ];
            return view("Services::television.form")->with('data', $newData);
        }
        return view("Services::television.form");
    }

    public function post(Request $request){
        if ($request->all()['id'] === null) {
            $body = $request->except(['_token','id']);
            $checkData = Television::where('name',$body['name'])->first();
            if ($checkData) {
                toastr()->error('DUPLICATE BROADCASTER NAME!');
                return redirect()->back()->withInput();
            }
            $created = Sentinel::getUser()->id;
            $periodExplode = explode(' - ',$body['period']);
            $newBody = [
                'name' => $body['name'],
                'period_start' => $periodExplode[0],
                'period_end' => $periodExplode[1],
                'region' => $body['region'],
                'status' => $body['status'],
                'created_by' => $created,
                'updated_by' => $created
            ];
            $data = Television::create($newBody);
            $newData = [
                'id' => $data['id'],
                'name' => $data['name'],
                'period' => $periodExplode[0]." - ".$periodExplode[1],
                'p_start' => $periodExplode[0],
                'p_end' => $periodExplode[1],
                'region' => $data['region'],
                'status' => $data['status'],
            ];
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/television');
        } else {
            toastr()->success('YOUR POST HAS BEEN UPDATED!');
            return redirect()->back();
            // return redirect()->back()->with('data',$data);
        }
    }

    public function detail($id){
        $perPage = 10;
        $data = TelevisionDetail::where('television_id',$id)->orderBy('created_at','desc')->paginate($perPage);
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_post($id, Request $request){
        $created = Sentinel::getUser()->id;
        if ($request->all()['id'] === null){
            $body = $request->except(['_token','id']);
            $body['television_id'] = $id;
            $body['created_by'] = $created;
            $body['updated_by'] = $created;
            TelevisionDetail::create($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        } else {
            $body = $request->except(['_token','id']);
            $body['updated_by'] = $created;
            TelevisionDetail::where('id',(int)$request->only('id'))->update($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        }
    }

    public function detail_television($id){
        $data = TelevisionDetail::where('id',$id)->first();
        return response()->json([
            'data'=>$data
        ]);
    }
}
