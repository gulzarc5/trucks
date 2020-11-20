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
}
