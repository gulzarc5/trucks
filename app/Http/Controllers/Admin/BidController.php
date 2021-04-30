<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderCustomer;
use App\Models\Bids;

class BidController extends Controller
{
    public function bidList($order_id)
    {
        //Bid Status  1 = New, 2 = Accepted, 3 = Rejected
        $order = OrderCustomer::findOrFail($order_id);
        $bids = Bids::where('order_id',$order_id)->get();
        return view('admin.bids.bid_list', compact('bids'));
    }

    public function bidStatusUpdate($bid_id,$status)
    {
        $bid = Bids::findOrFail($bid_id);
        $bid->status = $status;
        if($bid->save()){
            OrderCustomer::where('id',$bid->order_id)
            ->update([
                'bid_approval_status' =>2,
                'assigned_client_id' =>$bid->client_id,
            ]);
            Bids::where('order_id',$bid->order_id)->where('status',1)
            ->update([
                'status' => 3,
            ]);
        }
        return 1;
    }

    public function bidAdvAmountForm($bid_id)
    {
        $bid = Bids::findOrFail($bid_id);

        return view('admin.bids.bid_adv_amount',compact('bid'));
    }

    public function bidAdvAmountInsert($bid_id, Request $request)
    {
        $this->validate($request, [
            'adv_amount' =>'required|numeric',
        ]);

        $bid = Bids::findOrFail($bid_id);
        $bid->status = 2;
        if($bid->save()){
            OrderCustomer::where('id',$bid->order_id)
            ->update([
                'bid_approval_status' =>2,
                'amount' => $bid->bid_amount,
                'adv_amount' => $request->input('adv_amount'),
                'bid_status' => 3,
                'assigned_client_id' =>$bid->client_id,
            ]);
            Bids::where('order_id',$bid->order_id)->where('status',1)
            ->update([
                'status' => 3,
            ]);
            return redirect()->route('admin.bid_list',['order_id' => $bid->order_id]);
        }else {
            return redirect()->back()->with('error', 'Something Went Wrong Please Try Again');
        }

    }
}
