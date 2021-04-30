<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\CustomerOrderListResource;
use App\Models\OrderCustomer;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    public function orderPlace(Request $request)
    {
        $validator = Validator::make($request->all(),[
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
                'message' => 'Vaidation Error',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $order = new OrderCustomer();
        $order->customer_id = $request->user()->id;
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

    public function customerOrderHistory(Request $request)
    {
        $orders = OrderCustomer::where('customer_id', $request->user()->id)->orderBy('id','desc')->limit(50)->get();
        $response = [
            'status' => true,
            'messaage' => 'Orders List',
            'data' => CustomerOrderListResource::collection($orders),
        ];
        return response()->json($response);
        
    }

}
