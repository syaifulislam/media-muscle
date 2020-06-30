<?php

namespace App\Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Newspaper;
use App\NewspaperDetail;
use Sentinel;
class NewspaperController extends Controller
{
    public function index(){
        $perPage = 10;
        $data = Newspaper::orderBy('created_at','desc')->paginate($perPage);
        return view("Services::newspaper.index",compact('data'));
    }

    public function form($id = null){
        if ($id !== null){
            $data = Newspaper::where('id',(int)$id)->first();
            return view("Services::newspaper.form")->with('data', $data);
        }
        return view("Services::newspaper.form");
    }

    public function post(Request $request){
        $created = Sentinel::getUser()->id;
        $body = $request->except(['_token','id']);
        $body['updated_by'] = $created;
        if ($request->all()['id'] === null){
            $body['created_by'] = $created;
            $data = Newspaper::create($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/newspaper/form/'.$data['id']);
        } else {
            Newspaper::where('id',(int)$request->all()['id'])->update($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/services/newspaper/form/'.$request->all()['id']);
        }
    }

    public function detail($id){
        $perPage = 100;
        $data = NewspaperDetail::where('newspaper_id',$id)->orderBy('period_start','desc')->paginate($perPage);
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_newspaper($id){
        $data = NewspaperDetail::where('id',$id)->first();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function detail_post($id,Request $request){
        $created = Sentinel::getUser()->id;
        if ($request->all()['id'] === null){
            $body = $request->except(['_token','id']);
            $body['newspaper_id'] = $id;
            $body['created_by'] = $created;
            $body['updated_by'] = $created;
            $periodExplode = explode(' - ',$body['period']);
            NewspaperDetail::create([
                'newspaper_id' => $body['newspaper_id'],
                'period_start' => $periodExplode[0],
                'period_end' => $periodExplode[1],
                'size' => $body['size'],
                'position' => $body['position'],
                'price' => $body['price'],
                'created_by' => $body['created_by'],
                'updated_by' => $body['updated_by'],
            ]);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        } else {
            $body = $request->except(['_token','id']);
            $periodExplode = explode(' - ',$body['period']);
            NewspaperDetail::where('id',(int)$request->only('id')['id'])->update([
                'period_start' => $periodExplode[0],
                'period_end' => $periodExplode[1],
                'size' => $body['size'],
                'position' => $body['position'],
                'price' => $body['price'],
                'updated_by' => $created,
            ]);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect()->back();
        }
    }
}
