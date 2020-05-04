<?php

namespace App\Modules\Member\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPersonal()
    {
        return view("Member::memberPersonal.index");
    }

    public function indexCompany()
    {
        return view("Member::memberCompany.index");
    }
}
