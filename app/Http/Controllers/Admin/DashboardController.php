<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Journey;
use App\Models\OrderCustomer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboardView()
    {
        $owners = User::where('user_type',1)->count();

        $drivers = User::where('user_type',2)->count();
        $customers = Customer::count();
        $orders=OrderCustomer::count();
        $order_details = OrderCustomer::get();
        $journey = Journey::count();

        $chart = $this->chartData();
        $chartJourney = $this->journeyChartData();

        $latest_order = OrderCustomer::orderBy('id','desc')->limit(10)->get();
        $latest_journey = Journey::orderBy('id','desc')->limit(10)->get();
        return view('admin.dashboard',compact('owners','drivers','customers','orders','journey','chart','chartJourney','latest_order','latest_journey'));

    }

    function chartData(){
        $data[] = [
            'level' => Carbon::now()->format('Y-m'),
            'orders_count' => $this->chartQueryOrderCount(Carbon::now()->month),
        ];

        for ($i=1; $i < 11; $i++) {
            $data[] = [
                'level' => Carbon::now()->subMonths($i)->format('Y-m'),
                'orders_count' => $this->chartQueryOrderCount(Carbon::now()->subMonths($i)->month),
            ];
        }
        return $data;
    }

    function chartQueryOrderCount($month){
        $order_count = OrderCustomer::whereMonth('created_at', $month)->count();
        return $order_count;
    }

    function journeyChartData(){
        $data[] = [
            'level' => Carbon::now()->format('Y-m'),
            'journey_count' => $this->chartQueryJourneyCount(Carbon::now()->month),
        ];

        for ($i=1; $i < 11; $i++) {
            $data[] = [
                'level' => Carbon::now()->subMonths($i)->format('Y-m'),
                'journey_count' => $this->chartQueryJourneyCount(Carbon::now()->subMonths($i)->month),
            ];
        }
        return $data;
    }

    function chartQueryJourneyCount($month){
        $journey_count = Journey::whereMonth('created_at', $month)->count();
        return $journey_count;
    }


    public function newOrders()
    {
        $new_orders = OrderCustomer::where('status',1)->get();
        return view('admin.orders.new_order_list',compact('new_orders'));
    }

}
