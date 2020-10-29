<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use File;
use Intervention\Image\Facades\Image;

class ClientController extends Controller
{
    // For Owner //

    public function ownerList(){
        return view('admin.client.owner.owner_list');
    }

    public function ownerListAjax(Request $request){
        return datatables()->of(User::where('user_type',1)->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'. route('admin.edit_owner_form',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">Edit</a>
                <a href="'. route('admin.owner_detail',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">View Details</a>';
                if ($row->status == '1') {
                    $btn .='<a href="'.route('admin.owner_status',['id'=>encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                } else {
                    $btn .='<a href="'. route('admin.owner_status',['id'=>encrypt($row->id),'status'=>2]) .'" class="btn btn-primary btn-sm" >Enable</a>';
                }
                return $btn;
            })
            ->rawColumns(['action',])
            ->make(true);
    }

    public function ownerAddForm(){
        $state = State::where('status',1)->get();
        return view('admin.client.owner.owner_add_form',compact('state'));
    }

    public function addOwner(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $owner = new User();
        $owner->name = $request->input('name');
        $owner->mobile =$request->input('mobile');
        $owner->email = $request->input('email');
        $owner->user_type = 1;
        $owner->city = $request->input('city');
        $owner->state = $request->input('state');
        $owner->address = $request->input('address');
        $owner->pin = $request->input('pin');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
            $destination = public_path(). '/images/owner';
            File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);

            $destinationPath = public_path() . '/images/owner';
            $img = Image::make($image->getRealPath());
            $img->save($destinationPath . '/' . $image_name);

            $thumb = public_path().'/images/owner/thumb';
            $img = Image::make($image->getRealPath());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb . '/' . $image_name);
            $owner->image = $image_name;
        }
        $owner->save();
        if($owner){
            return redirect()->back()->with('message','Owner Added Successfully');
        }else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function status($id,$status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $user_type = User::where('id',$id)->first();

        $user_type->status=$status;
        $user_type->save();
        return redirect()->back();
    }

    public function editOwnerForm($id){
        $owner = User::where('id',$id)->first();
        $state = State::where('status',1)->get();
        $city = null;
        if(!empty($owner->state)){
            $city = City::where('state_id',$owner->state)->get();
        }
        return view('admin.client.owner.edit_owner_form',compact('owner','state','city'));
    }

    public function updateOwner(Request $request,$id){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile,'.$id,
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $owner =User::where('id',$id)->first();
        $owner->name = $request->input('name');
        $owner->mobile =$request->input('mobile');
        $owner->email = $request->input('email');
        $owner->user_type = 1;
        $owner->city = $request->input('city');
        $owner->state = $request->input('state');
        $owner->address = $request->input('address');
        $owner->pin = $request->input('pin');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $main_path = public_path() . '/images/owner/' . $owner->image;
            if (File::exists($main_path)) {
                File::delete($main_path);
            }
            $thumb_path = public_path() . '/images/owner/thumb/' . $owner->image;
            if (File::exists($thumb_path)) {
                File::delete($thumb_path);
            }

            $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
            $destination = public_path() . '/images/owner';
            File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);

            $destinationPath = public_path() . '/images/owner';
            $img = Image::make($image->getRealPath());
            $img->save($destinationPath . '/' . $image_name);

            $thumb = public_path() . '/images/owner/thumb';
            $img = Image::make($image->getRealPath());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb . '/' . $image_name);
            $owner->image = $image_name;
        }
        $owner->save();

        if($owner){
            return redirect()->back()->with('message','Owner Details Updated Successfully');
        }else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function ownerVerify($mobile)
    {
        $owner = User::select('id','name')->where('mobile',$mobile)->where('user_type',1)->first();
        return $owner;
    }

    public function ownerDetail($id)
    {
        $owner = User::findOrFail($id);
        return view('admin.client.owner.owner_details',compact('owner'));
    }

    // For Driver //

    public function driverList(){
        $drivers = User::where('user_type',2)->get();
        return view('admin.client.driver.driver_list',compact('drivers'));
    }

    public function driverListAjax(Request $request){
        return datatables()->of(User::where('user_type',2)->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.  route('admin.edit_driver_form',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                if ($row->status == '1') {
                    $btn .='<a href="'.route('admin.driver_status',['id'=>encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                } else {
                    $btn .='<a href="'. route('admin.driver_status',['id'=>encrypt($row->id),'status'=>1]) .'" class="btn btn-primary btn-sm" >Enable</a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function driverAddForm(){
        $owner_name = User::where('user_type',1)->get();
        $state = State::where('status',1)->get();
        return view('admin.client.driver.driver_add_form',compact('owner_name','state'));
    }

    public function addDriver(Request $request){
        $this->validate($request, [
            'client_mobile'=>'required',
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile',
            'image.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $check_owner = User::where('mobile',$request->input('client_mobile'));
        if ($check_owner->count() == 0) {
            return redirect()->back()->with('error','Sorry Owner Not Found In Our Database');
        }
        $owner = $check_owner->first();
        $driver = new User();
        $driver->name = $request->input('name');
        $driver->mobile =$request->input('mobile');
        $driver->email = $request->input('email');
        $driver->owner_id = $owner->id;
        $driver->user_type = 2;
        $driver->city = $request->input('city');
        $driver->state = $request->input('state');
        $driver->address = $request->input('address');
        $driver->pin = $request->input('pin');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
            $destination = public_path() . '/images/driver';
            File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
            $img = Image::make($image->getRealPath());
            $img->save($destination . '/' . $image_name);

            $thumb = public_path() . '/images/driver/thumb';
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb . '/' . $image_name);
            $driver->image = $image_name;
        }
        $driver->save();

        if($driver){
            return redirect()->back()->with('message','Driver Added Successfully');
        }else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function editDriverForm($id){
        $driver = User::where('id',$id)->first();
        $owner = User::where('user_type',1)->get();
        $state = State::where('status',1)->get();

        return view('admin.client.driver.edit_driver_form',compact('driver','owner','state'));
    }

    public function updateDriver(Request $request,$id){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile,'.$id,
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $driver =User::where('id',$id)->first();
        $driver->name = $request->input('name');
        $driver->mobile =$request->input('mobile');
        $driver->email = $request->input('email');
        $driver->city = $request->input('city');
        $driver->state = $request->input('state');
        $driver->address = $request->input('address');
        $driver->pin = $request->input('pin');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = public_path() . '/images/driver/' . $driver->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $thumb = public_path() . '/images/driver/thumb/' . $driver->image;
            if (File::exists($thumb)) {
                File::delete($thumb);
            }

            $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
            $destination = public_path() . '/images/driver';
            File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
            $img = Image::make($image->getRealPath());
            $img->save($destination . '/' . $image_name);

            $thumb = public_path() . '/images/driver/thumb';
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb . '/' . $image_name);
            $driver->image = $image_name;
        }
        $driver->save();
        if($driver){
            return redirect()->back()->with('message','driver Details Updated Successfully');
        }else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function driverStatus($id,$status){

        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $user_type = User::where('id',$id)->first();

        $user_type->status=$status;
        $user_type->save();
        return redirect()->back();
    }

    public function driverVerify($driver_mobile,$owner_mobile)
    {
        $owner = User::select('id')->where('mobile',$owner_mobile)->where('user_type',1)->first();
        $driver = null;
        if($owner){
            $driver = User::select('id','name')->where('mobile',$driver_mobile)->where('owner_id',$owner->id)->where('user_type',2)->first();
        }
        return $driver;
    }

}
