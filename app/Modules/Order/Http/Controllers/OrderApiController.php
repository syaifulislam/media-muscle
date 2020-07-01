<?php

namespace App\Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use DB;
use App\Order;
use App\OrderDetail;

class OrderApiController extends Controller
{

    public function order(Request $request){
        $dataOrder = $request->get('order');
        $totalPrice = 0;
        foreach($dataOrder as $row){
            $totalPrice += $row['price'];
        }
        $user = JWTAuth::parseToken()->authenticate();
        $clientId = $user['id'];
        
        try{
            DB::beginTransaction();
            $bodyOrder = [
                'client_id' => $clientId,
                'invoice_number' => 'asdasd',
                'status' => 'On Progress',
                'total_price' => $totalPrice
            ];
            $order = Order::create($bodyOrder);
            foreach($dataOrder as $key => $row){
                $dataOrder[$key]['order_id'] = $order['id'];
                OrderDetail::create($dataOrder[$key]);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'code' => 400,
                'message' => $e->getMessage()
            ],400);
        }
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => []
        ],200);
    }

    public function order_history(Request $request){
        $limit = 5;
        $offset = 0;
        if ($request->has('limit')) $limit = (int)$request->get('limit');
        if ($request->has('offset')) $offset = (int)$request->get('offset');
        
        $user = JWTAuth::parseToken()->authenticate();
        $clientId = $user['id'];
        $data = Order::select(['id','invoice_number','total_price','status'])->where('client_id',$clientId)
        ->with(['order_detail' => function($q){
            $q->select(['id','order_id','item_name','price','period_start','period_end']);
        }])->limit($limit)->offset($offset)->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ],200);
    }
}
