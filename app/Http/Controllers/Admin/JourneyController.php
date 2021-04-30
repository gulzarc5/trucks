<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Journey;
use DataTables;

class JourneyController extends Controller
{
    public function journeyListOfOrder($order_id)
    {
        $journey = Journey::where('order_id', $order_id)->get();
        return view('admin.journey.journey_of_order_list',compact('journey'));
    }

    public function statusUpdate($journey_id,$status)
    {
        $journey =Journey::findOrFail($journey_id);
        $journey->status = $status;
        $journey->save();
        return 1;
    }

    public function journeylist()
    {
        return view('admin.journey.journey_list');
    }

    public function journeylistAjax()
    {
        return DataTables::eloquent(Journey::with('owner')->orderBy('id','desc'))
            ->addIndexColumn()
            ->addColumn('action', function($row){
                if ($row->status == '1'){
                    $btn = '<span id="action'.$row->id.'"><a class="btn btn-xs btn-primary"  onclick="openModal('.$row->id.',2,'.$row->id.',\'Are You Sure To Update On The Way\')">On The Way</a>
                    <a href="#" class="btn btn-xs btn-success"  onclick="openModal('.$row->id.',3,'.$row->id.',\'Are You Sure To Update Completed\')">Completed</a></span>';
                }elseif($row->status == '2'){
                    $btn = '<span id="action'.$row->id.'"><a href="#" class="btn btn-xs btn-success"  onclick="openModal('.$row->id.',3,'.$row->id.',\'Are You Sure To Update Completed\')">Completed</a></span>';
                }else{
                    $btn ='<button class="btn btn-xs btn-success">Done</button>';
                }
                return $btn;
            })
            ->addColumn('status_tab', function($row){
                if($row->status == '1'){
                    $btn = '<a href="#" class="btn btn-xs btn-warning">Assigned</a>';
                }elseIf($row->status == '2'){
                    $btn = '<a href="#" class="btn btn-xs btn-primary">On The Way</a>';
                }else{
                    $btn ='<a href="#" class="btn btn-xs btn-success">Completed</a>';
                }               
                return $btn;
            })
            ->rawColumns(['action','status_tab'])
            ->make(true);
 
    }
    
}
