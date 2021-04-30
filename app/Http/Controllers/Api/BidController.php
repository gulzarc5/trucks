<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Bids;

use App\Services\ClientBidCheckService;

use App\Http\Resources\Bid\ClientBidListResource;

class BidController extends Controller
{
    public function placeBid(Request $request,ClientBidCheckService $service)
    {
        $validator =  Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'amount' => 'required|numeric',
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
        $client_id = $request->user()->id;
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

    public function clientBids(Request $request)
    {
        $bids  = Bids::where('client_id',$request->user()->id)->orderBy('id', 'desc')->limit(50)->get();
        $response = [
            'status' => true,
            'message' => 'Bid List',
            'data' => ClientBidListResource::collection($bids),
        ];
        return response()->json($response, 200);
    }

}
