<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator;
use App\Services\ClientBidCheckService;

class OrderController extends Controller
{
    public function orderPlace(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required|numeric',
            'source_city_id' => 'required|numeric',
            'destination_city_id' => 'required|numeric',
            'weight_id' => 'required|numeric',
            'truck_type' => 'required|numeric',
            'no_of_trucks' => 'required|in:1,2',
            'schedule_date' => 'required|date|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $order = new OrderCustomer();
        $order->customer_id = $request->input('customer_id');
        $order->truck_type_id = $request->input('truck_type');
        $order->source_city_id = $request->input('source_city_id');
        $order->destination_city_id = $request->input('destination_city_id');
        $order->weight_id = $request->input('weight_id');
        $order->no_of_trucks = $request->input('no_of_trucks');
        $order->schedule_date = $request->input('schedule_date');
        if($order->save()){
            $response = [
                'status' => true,
                'message' => 'Order Placed Successfully',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Somethinf Went Wrong Please Try Again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

    }

    public function clientOrderList(ClientBidCheckService $service, $client_id)
    {
        $orders = OrderCustomer::where('order_customer.bid_status',2)
        ->select('order_customer.*')
        ->whereDate('order_customer.schedule_date','>=',Carbon::now()->toDateString())
        ->join('trucks', function($join) use($client_id){
            $join->on('order_customer.source_city_id','=','trucks.source')
            ->where('trucks.owner_id',$client_id)
            ->where('trucks.status',1);
        })
        ->distinct('order_customer.id')
        ->get();

        $modified = $orders->map(function($item, $key) use($client_id,$service) {
            $bid_check = $service->clientBidCheck($item->id,$client_id);
            $bid_check > 0 ? $item->is_bid = 2 : $item->is_bid = 1;
            return $item;
        });

        $response = [
            'status' => true,
            'messaage' => 'Orders List',
            'data' => $modified,
        ];
        return response()->json($response);
    }
}
