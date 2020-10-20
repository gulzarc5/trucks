<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Image;
use App\Models\City;
use App\Models\State;
use File;
class ClientController extends Controller
{
    // For Owner //

    public function ownerList(){
        $owners = User::where('user_type',1)->get();
        return view('admin.client.owner.owner_list',compact('owners'));
    }

    public function ownerAddForm(){
        $state = State::where('status',1)->get();
        return view('admin.client.owner.owner_add_form',compact('state'));
    }

    public function addOwner(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile',
            'email'=>'required|email|unique:user,email',
            'driving'=>'required',
            'city'=>'required',
            'image.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'state'=>'required',
            'address'=>'required',
            'pin'=>'required',

        ]);


        $owner = new User();
        $owner->name = $request->input('name');
        $owner->mobile =$request->input('mobile');
        $owner->email = $request->input('email');
        $owner->user_type = 1;
        $owner->driving = $request->input('driving');
        $owner->city = $request->input('city');
        $owner->state = $request->input('state');
        $owner->address = $request->input('address');
        $owner->pin = $request->input('pin');
        
        if ($request->hasFile('images')) {
            $image = $request->file('images');
                
                $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                $destination = base_path() . '/public/images/owner';
                File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
                $img = Image::make($image->getRealPath());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);
                $owner->image = $image_name;
                $owner->save();
        }
        else{
            $owner->save();
        }

        if($owner){
            return redirect()->back()->with('message','Owner Added Successfully');
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
        return view('admin.client.owner.edit_owner_form',compact('owner','state'));
    }

    public function updateOwner(Request $request,$id){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile,'.$id,
            'email'=>'required|email|unique:user,email,'.$id,
            'city'=>'required',
            'driving'=>'required',
            'image.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'state'=>'required',
            'address'=>'required',
            'pin'=>'required',
        ]);

        $owner =User::where('id',$id)->first();
        $owner->name = $request->input('name');
        $owner->mobile =$request->input('mobile');
        $owner->email = $request->input('email');
        $owner->user_type = 1;
        $owner->driving = $request->input('driving');
        $owner->city = $request->input('city');
        $owner->state = $request->input('state');
        $owner->address = $request->input('address');
        $owner->pin = $request->input('pin');
        
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $path = base_path() . '/public/images/owner/' . $owner->image;
            if (File::exists($path)) {
                File::delete($path);
            }
                $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                $destination = base_path() . '/public/images/owner';
                File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
                $img = Image::make($image->getRealPath());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);
                $owner->image = $image_name;
                $owner->save();
        }
        else{
            $owner->save();
        }

        if($owner){
            return redirect()->back()->with('message','Owner Details Updated Successfully');
        }



    }

    // For Driver //
    
    public function driverList(){
        $drivers = User::where('user_type',2)->get();
        return view('admin.client.driver.driver_list',compact('drivers'));
    }

    public function driverAddForm(){
        $owner_name = User::where('user_type',1)->get();
        $state = State::where('status',1)->get();
        return view('admin.client.driver.driver_add_form',compact('owner_name','state'));
    }

    public function addDriver(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile',
            'email'=>'required|email|unique:user,email',
            'driving'=>'required',
            'owner_name'=>'required',
            'city'=>'required',
            'image.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'state'=>'required',
            'address'=>'required',
            'pin'=>'required',

        ]);


        $driver = new User();
        $driver->name = $request->input('name');
        $driver->mobile =$request->input('mobile');
        $driver->email = $request->input('email');
        $driver->owner_id = $request->input('owner_name');
        $driver->user_type = 2;
        $driver->driving = $request->input('driving');
        $driver->city = $request->input('city');
        $driver->state = $request->input('state');
        $driver->address = $request->input('address');
        $driver->pin = $request->input('pin');
        
        if ($request->hasFile('images')) {
            $image = $request->file('images');
                
                $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                $destination = base_path() . '/public/images/driver';
                File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
                $img = Image::make($image->getRealPath());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);
                $driver->image = $image_name;
                $driver->save();
        }
        else{
            $driver->save();
        }

        if($driver){
            return redirect()->back()->with('message','Driver Added Successfully');
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
            'email'=>'required|email|unique:user,email,'.$id,
            'city'=>'required',
            'driving'=>'required',
            'image.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'state'=>'required',
            'address'=>'required',
            'pin'=>'required',
        ]);

        $driver =User::where('id',$id)->first();
        $driver->name = $request->input('name');
        $driver->mobile =$request->input('mobile');
        $driver->email = $request->input('email');
        $driver->owner_id = $request->input('owner_name');
        $driver->user_type = 2;
        $driver->driving = $request->input('driving');
        $driver->city = $request->input('city');
        $driver->state = $request->input('state');
        $driver->address = $request->input('address');
        $driver->pin = $request->input('pin');
        
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $path = base_path() . '/public/images/driver/' . $driver->image;
            if (File::exists($path)) {
                File::delete($path);
            }
                $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
                $destination = base_path() . '/public/images/driver';
                File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
                $img = Image::make($image->getRealPath());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destination . '/' . $image_name);
                $driver->image = $image_name;
                $driver->save();
        }
        else{
            $driver->save();
        }

        if($driver){
            return redirect()->back()->with('message','driver Details Updated Successfully');
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

    public function fetchCity($state_id){
       $city = City::where('state_id',$state_id)->where('status',1)->get();
       return $city;
    }

    public function ownerListAjax(Request $request){
        return datatables()->of(User::get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'. route('admin.edit_owner_form',['id'=>$row->id]) .'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                if ($row->status == '1') {
                    $btn .='<a href="'.route('admin.owner_status',['id'=>encrypt($row->id),'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                } else {
                    $btn .='<a href="'. route('admin.owner_status',['id'=>encrypt($row->id),'status'=>2]) .'" class="btn btn-primary btn-sm" >Enable</a>';
                }       
                return $btn;
            })
            ->addColumn('driving_status', function($row){
                if($row->driving == 1){
                    return '<button class="btn btn-sm btn-primary" disabled>By Owner</button>';
                }else{
                    return '<button class="btn btn-sm btn-info" disabled>By Driver</button>';
                }   
            })
            ->addColumn('user_type', function($row){
                if($row->user_type == 1){
                    return '<button class="btn btn-sm btn-primary" disabled>Owner</button>';
                }else{
                    return '<button class="btn btn-sm btn-info" disabled>Driver</button>';
                }   
            })
            ->addColumn('image', function($row){
               
                return '<img src="'. asset('images/owner/'.$row->image ).'"/>'; 
            })
            ->rawColumns(['action','driving_status','user_type','image'])
            ->make(true);
    }

    public function driverListAjax(Request $request){
        return datatables()->of(User::get())
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
            ->addColumn('driving_status', function($row){
                if($row->driving == 1){
                    return '<button class="btn btn-sm btn-primary" disabled>By Owner</button>';
                }else{
                    return '<button class="btn btn-sm btn-info" disabled>By Driver</button>';
                }   
            })
            ->addColumn('user_type', function($row){
                if($row->user_type == 1){
                    return '<button class="btn btn-sm btn-primary" disabled>Owner</button>';
                }else{
                    return '<button class="btn btn-sm btn-info" disabled>Driver</button>';
                }   
            })
            ->addColumn('image', function($row){
               
                return '<img src="'. asset('images/driver/'.$row->image ).'"/>'; 
            })
            ->rawColumns(['action','driving_status','user_type','image'])
            ->make(true);
    }


    // public function retriveOwnerNames(Request $request){
       
    //     $owner_name = $request->input('owner_name');
        
    //     $data = User::select("name")
    //         ->where("name","LIKE",'%'.$owner_name.'%')
    //         ->where("user_type",1)
    //         ->get();
        
        
    //     return response()->json($data);
    // }


}
