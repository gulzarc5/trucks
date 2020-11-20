<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\OrderCustomer;

class OrderController extends Controller
{
    public function newOrders()
    {
        $new_orders = OrderCustomer::where('bid_status',1)->get();
        return view('admin.orders.new_order_list',compact('new_orders'));
    }
    public function approvedOrders()
    {
        $approved_orders = OrderCustomer::where('bid_status',2)->get();
        return view('admin.orders.approved_order_list',compact('approved_orders'));
    }

    public function updateStatus($order_id,$status)
    {
        $order = OrderCustomer::findOrFail($order_id);
        $order->bid_status = $status;
        $order->save();
        return 1;
    }

}
