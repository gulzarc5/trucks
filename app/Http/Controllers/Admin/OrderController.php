<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use DataTables;
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
        return view('admin.orders.approved_order_list');
    }

    public function approvedOrderListAjax(Request $request){
        return DataTables::eloquent(OrderCustomer::with('customer','truckType','sourceCity','destinationCity','weight')->select('order_customer.*')->where(function($q){
            $q->where('bid_status',2)
            ->orWhere('bid_status',3);
        })->latest())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.route('admin.bid_list',['order_id'=>$row->id]).'" class="btn btn-xs btn-primary" target="_blank">View Bids</a>
                <a href="'.route('admin.order_details',['order_id'=>$row->id]).'" class="btn btn-xs btn-info" target="_blank">View</a>';
                if ($row->journey_status == '2') {
                    $btn .= '<a href="'.route('admin.journey_list_of_order',['order_id'=>$row->id]).'" class="btn btn-xs btn-primary" target="_blank">View journey</a>';
                }
                return $btn;
            })
            ->addColumn('total_bids', function($row){
                return $row->bidTotal->count();
            })
            ->addColumn('bid_approval_status', function($row){
                if ($row->bid_approval_status == '2'){
                    $btn = '<a class="btn btn-xs btn-primary">Bid Approved</a>';
                }else{
                    $btn ='<a class="btn btn-xs btn-warning">Pending</a>';
                }
                return $btn;
            })
            ->addColumn('user_type', function($row){
                if (isset($row->customer->user_type)){
                    if ($row->customer->user_type == '1'){
                        $btn = 'Individual User';
                    }else{
                        $btn = 'Corporate User';
                    }
                }else {
                    $btn = '';
                }
                return $btn;
            })
            ->addColumn('journey_status', function($row){
                return $row->journey_status == '1' ? '<a class="btn btn-xs btn-warning">Not Started</a>' : '<a class="btn btn-xs btn-info">Started</a>';
            })
            ->rawColumns(['action','total_bids','bid_approval_status','user_type','journey_status'])
            ->toJson();
    }

    public function rejectedOrders()
    {
        return view('admin.orders.rejected_order_list');
    }

    public function rejectedOrderListAjax(Request $request){
        return DataTables::eloquent(OrderCustomer::with('customer','truckType','sourceCity',
        'destinationCity','weight')->where('bid_status',4)->latest())
            ->addIndexColumn()
            ->addColumn('user_type', function($row){
                if (isset($row->customer->user_type)){
                    if ($row->customer->user_type == '1'){
                        $btn = 'Individual User';
                    }else{
                        $btn = 'Corporate User';
                    }
                }else {
                    $btn = '';
                }
                return $btn;
            })
            ->rawColumns(['user_type'])
            ->toJson();
    }

    public function updateStatus($order_id,$status)
    {
        $order = OrderCustomer::findOrFail($order_id);
        $order->bid_status = $status;
        $order->save();
        return 1;
    }

    public function orderDetails($order_id)
    {
        $order = OrderCustomer::findOrFail($order_id);
        return view('admin.orders.order_details',compact('order'));
    }

}
