<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\OrderCustomer;

class DashboardController extends Controller
{
    public function dashboardView()
    {
        $owners = User::where('user_type',1)->count();

        $drivers = User::where('user_type',2)->count();
        $customers = Customer::count();
        $orders=OrderCustomer::count();
        $order_details = OrderCustomer::get();
        $bids = OrderCustomer::where('bid_status',1)->count();
        return view('admin.dashboard',compact('owners','drivers','customers','orders','bids'));

    }

    public function newOrders()
    {
        $new_orders = OrderCustomer::where('status',1)->get();
        return view('admin.orders.new_order_list',compact('new_orders'));
    }

}
