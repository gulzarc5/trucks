<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Bids;

use App\Services\ClientBidCheckService;

class BidController extends Controller
{
    public function placeBid(Request $request,ClientBidCheckService $service)
    {
        $validator =  Validator::make($request->all(), [
            'order_id' => 'required',
            'client_id' => 'required',
            'amount' => 'required',
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

        $order_id = $request->input('order_id');
        $client_id = $request->input('client_id');
        $amount = $request->input('amount');

        $bid_check = $service->clientBidCheck($order_id,$client_id);
        if ($bid_check > 0) {
            $response = [
                'status' => false,
                'message' => 'Sorry!! Already Placed Your Bid',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

        $bid = new Bids();
        $bid->order_id = $order_id;
        $bid->client_id = $client_id;
        $bid->bid_amount = $amount;
        $bid->save();

        $response = [
            'status' => true,
            'message' => 'Bid Placed Successfully',
            'error_code' => false,
            'error_message' => null,
        ];
        return response()->json($response, 200);
    }


}
