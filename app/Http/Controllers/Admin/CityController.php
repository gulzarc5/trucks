<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
class CityController extends Controller
{
    public function cityList(){
        $city = City::get();
        return view('admin.city.city_list',compact('city'));
    }

    public function cityAddForm(){
        $states = State::where('status',1)->pluck('name','id');
        return view('admin.city.city_add_form',compact('states'));

    }

    public function addCity(Request $request){
        $this->validate($request, [
            'state'=>'required',
            'name'=>'required'
        ]);
        $city = new city;
        $city->name = $request->input('name');
        $city->state_id = $request->input('state');
        $city->save();
        if($city){
            return redirect()->back()->with('message','city Added Successfully');
        }

    }

    public function cityStatus($id,$status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $city = City::where('id',$id)->first();
        $city->status=$status;
        $city->save();
        return redirect()->back();
    }

    public function editCity($id){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $states = state::where('status',1)->pluck('name', 'id');
        $city = City::where('id',$id)->first();
        return view('admin.city.city_add_form',compact('city','states'));
    }

    public function cityUpdate(Request $request,$id){
        $this->validate($request, [
            'state'=>'required',
            'name'   => 'required'

        ]);
        City::where('id',$id)
            ->update([
                'state_id'=>$request->input('state'),
                'name'=>$request->input('name'),

            ]);
            return redirect()->back()->with('message','City Updated Successfully');

    }

    public function cityFetchByState($state_id){
        $city = City::Where('state_id',$state_id)->pluck('name','id');
        return $city;
    }
}
