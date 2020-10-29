<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\TruckWeight;
use App\Models\TruckType;
use App\Models\TruckImage;
use File;
use Image;
class TruckController extends Controller
{
    public function trucksList(){
        $trucks_list = Truck::get();
        return view('admin.truck.truck_list',compact('trucks_list'));
    }

    public function truckListAjax(Request $request){
        return datatables()->of(Truck::get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.  route('admin.edit_truck_form',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">Edit</a>
                <a href="'.  route('admin.truck_images',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">Images</a>';
                if ($row->status == '1') {
                    $btn .='<a href="'.route('admin.truck_status',['id'=>encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                } else {
                    $btn .='<a href="'. route('admin.truck_status',['id'=>encrypt($row->id),'status'=>1]) .'" class="btn btn-primary btn-sm" >Enable</a>';
                }
                return $btn;
            })->addColumn('capacity', function($row){
                return !empty($row->weight_id) && !empty($row->capacity) ? $row->capacity->weight." MT" : '';
            })->addColumn('owner', function($row){
                return !empty($row->owner_id) && !empty($row->owner) ? $row->owner->name : '';
            })->addColumn('driver', function($row){
                return !empty($row->driver_id) && !empty($row->driver) ? $row->driver->name : '';
            })->addColumn('source_city', function($row){
                return !empty($row->source) && !empty($row->sourceCity) ? $row->sourceCity->name : '';
            })
            ->rawColumns(['action','capacity','owner','driver','source_city'])
            ->make(true);
    }

    public function truckAddForm(){
        $state = State::where('status',1)->get();
        $weight = TruckWeight::get();
        $truck_type = TruckType::where('status',1)->get();
        return view('admin.truck.truck_add_form',compact('state','weight','truck_type'));
    }
    public function addTruck(Request $request){
        $this->validate($request, [
            'owner_mobile'=>'required|numeric',
            'driver_mobile'=>'required|numeric',
            'truck_type' => 'required',
            'source_city'=>'required',
            'capacity'=>'required',
            'truck_number'=>'required',
            'images.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $owner_mobile = $request->input('owner_mobile');
        $driver_mobile = $request->input('driver_mobile');

        $check_owner = User::where('mobile',$owner_mobile)->where('user_type',1);
        if ($check_owner->count() == 0) {
            return redirect()->back()->with('error','Owner Not Found');
        }
        $check_driver = User::where('mobile',$driver_mobile)->where('user_type',2);
        if ($check_driver->count() == 0) {
            return redirect()->back()->with('error','Driver Not Found');
        }
        $owner_data = $check_owner->first();
        $driver_data = $check_driver->first();

        $truck = new Truck();
        $truck->truck_type = $request->input('truck_type');
        $truck->weight_id = $request->input('capacity');
        $truck->owner_id =$owner_data->id;
        $truck->driver_id = $driver_data->id;
        $truck->source = $request->input('source_city');
        $truck->truck_number = $request->input('truck_number');
        if($truck->save()){
            $banner = null;
            if ($request->hasFile('images')) {
                for ($i = 0; $i < count($request->file('images')); $i++) {
                    $image = $request->file('images')[$i];
                    $image_name = $i . time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                    if ($i == 0) {
                        $truck->image = $image_name;
                        $truck->save();
                    }
                    $image_name =$i .time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();

                    //Product Original Image
                    $destinationPath = public_path() . '/images/trucks';
                    $img = Image::make($image->getRealPath());
                    $img->save($destinationPath . '/' . $image_name);
                    //Product Thumbnail
                    $destination = public_path() . '/images/trucks/thumb';
                    $img = Image::make($image->getRealPath());
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destination . '/' . $image_name);

                    $truck_image = new TruckImage();
                    $truck_image->image = $image_name;
                    $truck_image->truck_id = $truck->id;
                    $truck_image->save();
                }
            }
            return redirect()->back()->with('message','Truck Added Successfully');
        }else{
            return redirect()->back()->with('error','Something went wrong Please Try Again');
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
        $truck = Truck::where('trucks.id',$id)
        ->select('trucks.*','owner.mobile as owner_mobile','owner.name as owner_name','driver.mobile as driver_mobile','driver.name as driver_name')
        ->leftJoin('user as owner','owner.id','trucks.owner_id')
        ->leftJoin('user as driver','driver.id','trucks.driver_id')
        ->firstOrFail();

        $state = State::where('status',1)->get();
        $weight = TruckWeight::get();
        $truck_type = TruckType::where('status',1)->get();
        $city = null;
        $selected_state = null;
        if (!empty($truck->source)) {
            $city_data = City::find($truck->source);
            $selected_state =  $city_data->state_id;
            $city = City::where('state_id',$city_data->state_id)->get();
        }
        return view('admin.truck.edit_truck_form',compact('truck','state','truck_type','city','weight','selected_state'));
    }

    public function updateTruck(Request $request,$id){
        $this->validate($request, [
            'owner_mobile'=>'required|numeric',
            'driver_mobile'=>'required|numeric',
            'truck_type' => 'required',
            'source_city'=>'required',
            'capacity'=>'required',
            'truck_number'=>'required',
        ]);
        $owner_mobile = $request->input('owner_mobile');
        $driver_mobile = $request->input('driver_mobile');

        $check_owner = User::where('mobile',$owner_mobile)->where('user_type',1);
        if ($check_owner->count() == 0) {
            return redirect()->back()->with('error','Owner Not Found');
        }
        $check_driver = User::where('mobile',$driver_mobile)->where('user_type',2);
        if ($check_driver->count() == 0) {
            return redirect()->back()->with('error','Driver Not Found');
        }
        $owner_data = $check_owner->first();
        $driver_data = $check_driver->first();

        $truck = Truck::findOrFail($id);
        $truck->truck_type = $request->input('truck_type');
        $truck->weight_id = $request->input('capacity');
        $truck->owner_id =$owner_data->id;
        $truck->driver_id = $driver_data->id;
        $truck->source = $request->input('source_city');
        $truck->truck_number = $request->input('truck_number');
        if($truck->save()){
            return redirect()->back()->with('message','Truck Data Updated Successfully');
        }else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function truckImages($id)
    {
        $images = TruckImage::where('truck_id',$id)->get();
        $truck = Truck::findOrFail($id);
        return view('admin.truck.images',compact('images','truck'));
    }

    public function makeCoverImage($truck_id,$image_id)
    {
        $image = TruckImage::findOrFail($image_id);
        $truck = Truck::FindOrFail($truck_id);
        $truck->image = $image->image;
        $truck->save();
        return redirect()->back();
    }

    public function addNewImages(Request $request)
    {
        $this->validate($request, [
            'truck_id'=>'required',
            'images.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $id = $request->input('truck_id');
        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->file('images')); $i++) {
                $image = $request->file('images')[$i];
                $image_name = $i . time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();

                $image_name =$i .time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();

                //Product Original Image
                $destinationPath = public_path() . '/images/trucks';
                $img = Image::make($image->getRealPath());
                $img->save($destinationPath . '/' . $image_name);
                //Product Thumbnail
                $destination = public_path() . '/images/trucks/thumb';
                $img = Image::make($image->getRealPath());
                $img->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);

                $truck_image = new TruckImage();
                $truck_image->image = $image_name;
                $truck_image->truck_id = $id;
                $truck_image->save();
            }
        }

        return redirect()->back();
    }

    public function deleteImage($image_id)
    {
        $image = TruckImage::findOrFail($image_id);
        if ($image) {
            $path = public_path() . '/images/trucks/' . $image->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $path_thumb = public_path() . '/images/trucks/thumb/' . $image->image;
            if (File::exists($path_thumb)) {
                File::delete($path_thumb);
            }
        }
        TruckImage::where('id', $image_id)->delete();
        return redirect()->back();
    }
}