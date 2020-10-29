<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TruckType;
use App\Models\TruckWeight;

class ConfigurationController extends Controller
{
    public function truckTypeList(){
        $truck_type = TruckType::get();
        return view('admin.configuration.truck_type.truck_type_list',compact('truck_type'));
    }

    public function truckTypeAddForm(){
        return view('admin.configuration.truck_type.truck_type_add_form');
    }

    public function addTruckType(Request $request){
        $this->validate($request, [
            'name' =>'required',
        ]);
        $truck_type = new TruckType();
        $truck_type->name = $request->input('name');
        $truck_type->save();
        return redirect()->back()->with('message','Truck Type Added Successfully');
    }

    public function truckTypeStatus($id,$status){
        $truck_type = TruckType::find($id);
        $truck_type->status = $status;
        $truck_type->save();
        return redirect()->back();
    }

    public function editTruckType($id){
        $truck_type = TruckType::where('id',$id)->first();
        return view('admin.configuration.truck_type.truck_type_add_form',compact('truck_type'));
    }

    public function updateTruckType(Request $request,$id){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $truck_type = TruckType::find($id);
        $truck_type->name = $request->input('name');
        $truck_type->save();
        return redirect()->back()->with('message','Truck Type Updated Successfully');
    }

    /** Truck Capacity **/

    public function truckCapacityList(){
        $truck_capacity = TruckWeight::get();
        return view('admin.configuration.truck_capacity.truck_capacity_list',compact('truck_capacity'));
    }

    public function truckCapacityAddForm(){
        return view('admin.configuration.truck_capacity.truck_capacity_add_form');
    }

    public function addTruckCapacity(Request $request){
        $this->validate($request, [
            'weight' =>'required',
        ]);
        $truck_type = new TruckWeight();
        $truck_type->weight = $request->input('weight');
        $truck_type->save();
        return redirect()->back()->with('message','Truck Capacity Added Successfully');
    }

    public function editTruckCapacity($id){
        $truck_capacity = TruckWeight::where('id',$id)->first();
        return view('admin.configuration.truck_capacity.truck_capacity_add_form',compact('truck_capacity'));
    }

    public function updateTruckCapacity(Request $request,$id){
        $this->validate($request, [
            'weight' => 'required',
        ]);
        $truck_type = TruckWeight::find($id);
        $truck_type->weight = $request->input('weight');
        $truck_type->save();
        return redirect()->back()->with('message','Truck Capacity Updated Successfully');
    }

}
