<?php

namespace App\Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use Sentinel;

class OrderController extends Controller
{
    public function index(Request $request){
        $perPage = 10;
        $globalSearch = null;
        $clientType = null;
        if ($request->has('global_search')){
            $globalSearch = $request->get('global_search');
        }
        if ($request->has('client_type')){
            $clientType = $request->get('client_type');
        }
        $data = Order::orderBy('created_at','desc')
        ->where(function($q) use ($globalSearch){
            if ($globalSearch != null){
                $q->where('invoice_number', 'like', "%$globalSearch%");
            }
        })
        ->whereHas('client', function($q)use($clientType){
            if ($clientType != null){
                if ($clientType == 'Personal') {
                    $q->where('isPersonal',1);
                } else {
                    $q->where('isPersonal',0);
                }
            }
        })
        ->with(['client'])
        ->paginate($perPage);
        if ($request->has('global_search')){
            $data->appends(['global_search' => $request->get('global_search')]);
        }
        if ($request->has('client_type')){
            $data->appends(['client_type' => $request->get('client_type')]);
        }
        return view("Order::index",compact('data','globalSearch','clientType'));
    }

    public function detail($invoice_number){
        $data = Order::where('invoice_number',$invoice_number)
        ->with('order_detail','client')->first();
        return view("Order::view",compact('data'));
    }

    public function update($id,Request $request){
        $confirmBy = Sentinel::getUser()->id;
        Order::where('id',(int)$id)->update(['status' => $request->get('status')]);
        toastr()->success('YOUR POST HAS BEEN UPDATED!');
        return redirect()->back();
    }
}
