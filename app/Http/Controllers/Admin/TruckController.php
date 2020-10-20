<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Owner;
use App\Models\User;
use App\Models\City;
use App\Models\Driver;
use App\Models\TruckWeight;
use File;
use Image;
class TruckController extends Controller
{
    public function trucksList(){
        $trucks_list = Truck::get();
        return view('admin.truck.truck_list',compact('trucks_list'));
    }

    public function truckAddForm(){
        $owner = User::where('user_type',1)->get();
        $driver = User::where('user_type',2)->get();
        $city = City::get();
        $weight = TruckWeight::get();
        return view('admin.truck.truck_add_form',compact('owner','driver','city','weight'));
    }
    public function addTruck(Request $request){
        $this->validate($request, [
            'truck'=>'required',
            'owner_name'=>'required|numeric',
            'driver_name'=>'required',
            'source'=>'required',
            'weight'=>'required',
            'image.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $truck = new Truck();
        $truck->truck_type = $request->input('truck');
        $truck->owner_id =$request->input('owner_name');
        $truck->driver_id = $request->input('driver_name');
        $truck->source = $request->input('source');
        $truck->weight_id = $request->input('weight');
       
       

        if ($request->hasFile('images')) {
            $image = $request->file('images');
                
                $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                $destination = base_path() . '/public/images/trucks';
                File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
                $img = Image::make($image->getRealPath());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);
                $truck->image = $image_name;
                $truck->save();
        }
        else{
            $truck->save();
        }

        if($truck){
            return redirect()->back()->with('message','Truck Added Successfully');
        }

    }

    public function truckStatus($id,$status){
        
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        
        $truck = Truck::where('id',$id)->first();
        
        $truck->status=$status;
        $truck->save();
        return redirect()->back();
    }

    public function editTruckForm($id){
        $truck = Truck::where('id',$id)->first();
        $owner = User::where('user_type',1)->get();
        $driver = User::where('user_type',2)->get();
        $city = City::get();
        $weight = TruckWeight::get();
        
        return view('admin.truck.edit_truck_form',compact('truck','owner','driver','city','weight'));
    }
    
    public function updateTruck(Request $request,$id){
        $this->validate($request, [
            'truck'=>'required',
            'owner_name'=>'required|numeric',
            'driver_name'=>'required',
            'source'=>'required',
            'weight'=>'required',
            'image.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $truck =  Truck::where('id',$id)->first();
        $truck->truck_type = $request->input('truck');
        $truck->owner_id =$request->input('owner_name');
        $truck->driver_id = $request->input('driver_name');
        $truck->source = $request->input('source');
        $truck->weight_id = $request->input('weight');
       
       

        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $path = base_path() . '/public/images/trucks/' . $truck->image;
            if (File::exists($path)) {
                File::delete($path);
            }
                $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                $destination = base_path() . '/public/images/trucks';
                File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
                $img = Image::make($image->getRealPath());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);
                $truck->image = $image_name;
                $truck->save();
        }
        else{
            $truck->save();
        }

        if($truck){
            return redirect()->back()->with('message','Truck Updated Successfully');
        }



    }
    public function truckListAjax(Request $request){
        
        return datatables()->of(Truck::get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.  route('admin.edit_truck_form',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                if ($row->status == '1') {
                    $btn .='<a href="'.route('admin.truck_status',['id'=>encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                } else {
                    $btn .='<a href="'. route('admin.truck_status',['id'=>encrypt($row->id),'status'=>1]) .'" class="btn btn-primary btn-sm" >Enable</a>';
                }       
                return $btn;
            })
            ->addColumn('truck_type', function($row){
                
                if($row->truck_type == 1){
                    return '<button class="btn btn-sm btn-primary" disabled>Container</button>';
                }else{
                    return '<button class="btn btn-sm btn-info" disabled>Truck 20MT/12 wheel</button>';
                }   
            })
            ->addColumn('weight_id', function($row){
                $weight = TruckWeight::where('id',$row->weight_id)->first();
                if($row->weight_id == $weight->id){
                    return $weight->weight;
                } 
            })
            ->addColumn('owner_id', function($row){
                $owner = User::where('id',$row->owner_id)->first();
                if($row->owner_id == $owner->id){
                    return $owner->name;
                }
               
            })
            ->addColumn('driver_id', function($row){
                $driver = User::where('id',$row->driver_id)->first();
                if($row->driver_id == $driver->id){
                    return $driver->name;
                }
                
            })
            ->addColumn('source', function($row){
                $source = City::where('id',$row->source)->first();
                if($row->source == $source->id){
                    return $source->name;
                }
                
            })
            ->addColumn('image', function($row){
               
                return '<img src="'. asset('images/trucks/'.$row->image ).'"/>'; 
            })
            ->rawColumns(['action','truck_type','owner_id','driver_id','source','image'])
            ->make(true);
    }
}
