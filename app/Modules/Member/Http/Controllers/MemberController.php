<?php

namespace App\Modules\Member\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Alert;
use App\Client;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->memberPersonal = "Member::memberPersonal";
        $this->memberCompany = "Member::memberCompany";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPersonal()
    {
        $perPage = 10;
        $data = Client::where('isPersonal',1)->orderBy('created_at','desc')->paginate($perPage);
        return view($this->memberPersonal.".index",compact('data'));
    }

    public function indexCompany()
    {
        $perPage = 10;
        $data = Client::where('isPersonal',0)->orderBy('created_at','desc')->paginate($perPage);
        return view($this->memberCompany.".index",compact('data'));
    }

    public function indexPersonalDetail($id)
    {
        $data = Client::where('id',(int)$id)->first();
        return view($this->memberPersonal.".view",compact('data'));
    }

    public function indexCompanyDetail($id)
    {
        $data = Client::where('id',(int)$id)->first();
        return view($this->memberCompany.".view",compact('data'));
    }

    public function updatePersonal(Request $request,$id)
    {
        $status = $request->get('status');
        Client::where('id',(int)$id)->update(['status'=>$status]);
        toastr()->success('YOUR POST HAS BEEN SUBMITED!');
        return redirect("member/personal");
    }

    public function updateCompany(Request $request,$id)
    {
        $status = $request->get('status');
        Client::where('id',(int)$id)->update(['status'=>$status]);
        toastr()->success('YOUR POST HAS BEEN SUBMITED!');
        return redirect("member/company");
    }
}
