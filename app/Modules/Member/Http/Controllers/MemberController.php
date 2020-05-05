<?php

namespace App\Modules\Member\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use Alert;

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
        return view($this->memberPersonal.".index");
    }

    public function indexCompany()
    {
        return view($this->memberCompany.".index");
    }

    public function indexPersonalDetail($id)
    {
        return view($this->memberPersonal.".view");
    }

    public function updatePersonal(Request $request,$id)
    {
        toastr()->success('YOUR POST HAS BEEN SUBMITED!');
        return redirect("member/personal");
    }
}
