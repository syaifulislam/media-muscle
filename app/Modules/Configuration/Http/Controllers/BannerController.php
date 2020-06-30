<?php

namespace App\Modules\Configuration\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Sentinel;
use Cloudder;
class BannerController extends Controller
{
    public function index(){
        $data = Banner::get();
        return view("Configuration::banner.index", compact('data'));
    }

    public function form($id = null){
        if($id == null){
            return view("Configuration::banner.form");
        } else {
            $data = Banner::where('id',(int)$id)->first();
            return view("Configuration::banner.form",compact('data'));
        }
    }

    public function store(Request $request){
        $created = Sentinel::getUser()->id;
        $body = $request->except(['id','_token','image']);
        if ($request->all()['id'] == null) {
            $img = $request->file('image')->getRealPath();
            $res = $this->store_image_to_cloud($img);
            $body['url'] = $res['public_id'].'.'.$res['format'];
            $body['created_by'] = $created;
            $body['updated_by'] = $created;
            Banner::create($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/configuration/banner');
        } else {
            $body['updated_by'] = $created;
            if ($request->file('image')){
                $img = $request->file('image')->getRealPath();
                $res = $this->store_image_to_cloud($img);
                $body['url'] = $res['public_id'].'.'.$res['format'];
            }
            Banner::where('id',(int)$request->all()['id'])->update($body);
            toastr()->success('YOUR POST HAS BEEN SUBMITED!');
            return redirect('/configuration/banner'); 
        }
    }

    private function store_image_to_cloud($img){
        $upload = Cloudder::upload($img, null);
        $res = $upload->getResult();
        return $res;
    }
}
