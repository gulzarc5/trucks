<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderCustomer;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator;
use App\Services\ClientBidCheckService;
use App\Http\Resources\Order\ClientOrderListResource;
use App\Http\Resources\Order\CustomerOrderListResource;


use Razorpay\Api\Api;

class OrderController extends Controller
{
    public function clientOrderList(ClientBidCheckService $service,Request $request)
    {
        $client_id = $request->user()->id;
        $client_type = $request->user()->user_type;
        $orders = OrderCustomer::where('order_customer.bid_status',2)
        ->select('order_customer.*')
        ->whereDate('order_customer.schedule_date','>=',Carbon::now()->toDateString());
        if ($client_type == 1) {
            $orders->join('trucks', function($join) use($client_id){
                $join->on('order_customer.source_city_id','=','trucks.source')
                ->where('trucks.owner_id',$client_id)
                ->where('trucks.status',1);
            });
        }
        $orders = $orders->distinct('order_customer.id')->latest()
        // ->toSql();
        ->paginate(20);
        // return $orders;
        $modified = $orders->map(function($item, $key) use($client_id,$service) {
            $bid_check = $service->clientBidCheck($item->id,$client_id);
            $bid_check > 0 ? $item->is_bid = 2 : $item->is_bid = 1;
            return $item;
        });

        $response = [
            'status' => true,
            'messaage' => 'Orders List',
            'data' => ClientOrderListResource::collection($modified),
        ];
        return response()->json($response);
    }


    public function advancePaymentCheckout($order_id)
    {
        $order = OrderCustomer::find($order_id);
        if ($order && ($order->adv_amount > 0)) {
            $customer = Customer::find($order->customer_id);
            if ($customer) {
                $api = new Api(config('services.razorpay.id'), config('services.razorpay.key'));
                $orders = $api->order->create(array(
                    'receipt' => $order_id,
                    'amount' => $order->adv_amount*100,
                    'currency' => 'INR',
                    )
                );
                $order->payment_request_id = $orders['id'];
                $order->save();

                $payment_data = [
                    'key_id' => config('services.razorpay.id'),
                    'amount' => $order->adv_amount*100,
                    'order_id' => $orders['id'],
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'mobile' => $customer->mobile,
                ];

                $response = [
                    'status' => true,
                    'message' => 'Payment Order Details',
                    'error_code' => false,
                    'error_message' => null,
                    'data' => [
                        'order_id' => $order_id,
                        'amount' => $order->adv_amount,
                        'payment_data' => $payment_data,
                    ],
                ];

               return response()->json($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Sorry We Can\'t initiate payment Try After Sometime',
                    'data' => [],
                ];
                return response()->json($response, 200);
            }            

        } else {
            $response = [
                'status' => false,
                'message' => 'Sorry We Can\'t initiate payment Try After Sometime',
                'data' => [],
            ];
            return response()->json($response, 200);
        }
        

    }

    public function paymentVerify(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'user_id' => 'required',
            'razorpay_order_id' => 'required', // 1 = normal, 2 = Express
            'razorpay_payment_id' => 'required', // 1 = cod, 2 = online
            'razorpay_signature' => 'required',
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
                'data' => [],
            ];
            return response()->json($response, 200);
        }

        $verify = $this->signatureVerify(
            $request->input('razorpay_order_id'),
            $request->input('razorpay_payment_id'),
            $request->input('razorpay_signature')
        );
        if ($verify) {
            $order = OrderCustomer::find($request->input('order_id'));
            $order->payment_id =  $request->input('razorpay_payment_id');
            $order->payment_status = 2;
            $order->save();
            $response = [
                'status' => true,
                'message' => 'Payment Success',
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'status' => false,
                'message' => 'Payment Failed',
            ];
            return response()->json($response, 200);
        }
    }

    private function signatureVerify($signature,$payment_id,$order_id)
    {
        try {
            $api = new Api(config('services.razorpay.id'), config('services.razorpay.key'));
            $attributes = array(
                'razorpay_order_id' => $order_id,
                'razorpay_payment_id' => $payment_id,
                'razorpay_signature' => $signature
            );

            $api->utility->verifyPaymentSignature($attributes);
            $success = true;
        } catch (\Exception $e) {
            $success = false;
        }
        return $success;
    }
}
