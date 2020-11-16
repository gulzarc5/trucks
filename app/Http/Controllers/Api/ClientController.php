<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use File;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Wallet;
use Hash;
use Illuminate\Support\Str;
use App\Http\Resources\ClientProfileResource;

class ClientController extends Controller
{
    public function registration(Request $request)
    {
        //user type 1 = owner , 2 = Driver
        $validator =  Validator::make($request->all(), [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:8',
            'user_type' => 'required|in:1,2'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }
        $user_type = $request->input('user_type');
        $owner = new User();
        $owner->name = $request->input('name');
        $owner->mobile =$request->input('mobile');
        $owner->email = $request->input('email');
        $owner->user_type = $user_type;
        $owner->city = $request->input('city');
        $owner->state = $request->input('state');
        $owner->address = $request->input('address');
        $owner->pin = $request->input('pin');
        $owner->password = Hash::make($request->input('password'));

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
            $destination = ($user_type == 1) ? public_path(). '/images/owner' : public_path(). '/images/driver';
            File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);

            $destinationPath = ($user_type == 1) ? public_path() . '/images/owner' :  public_path() . '/images/driver';
            $img = Image::make($image->getRealPath());
            $img->save($destinationPath . '/' . $image_name);

            $thumb =  ($user_type == 1) ? public_path().'/images/owner/thumb' : public_path().'/images/driver/thumb';
            $img = Image::make($image->getRealPath());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb . '/' . $image_name);
            $owner->image = $image_name;
        }
        $owner->save();
        if($owner){
            $wallet = new Wallet();
            $wallet->user_id = $owner->id;
            $owner->save();
            $response = [
                'status' => true,
                'message' => 'Client Registered Successfully',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong Please Try Again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function login(Request $request){
        $validator =  Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $owner = User::where('mobile',$request->input('mobile'))->where('status',1)->first();
        if ($owner) {
            if(Hash::check($request->input('password'), $owner->password)){
                $owner->api_token = Str::random(60);
                $owner->save();
                $response = [
                    'status' => true,
                    'message' => 'User Successfully Logged In',
                    'error_code' => false,
                    'error_message' => null,
                    'data' => $owner,
                ];
                return response()->json($response, 200);
            }else {
                $response = [
                    'status' => false,
                    'message' => 'Sorry !! User Id Or Password Wrong',
                    'error_code' => false,
                    'error_message' => null,
                ];
                return response()->json($response, 200);
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Sorry !! User Id Or Password Wrong',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

    }

    public function clientProfile($id)
    {
        $owner = User::find($id);
        $response = [
            'status' => true,
            'message' => 'Client Profile',
            'error_message' => new ClientProfileResource($owner),
        ];
        return response()->json($response, 200);
    }

    public function clientProfileUpdate(Request $request,$id)
    {
        $validator =  Validator::make($request->all(), [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile,'.$id,
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_type' => 'required|in:1,2'
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }
        $user_type = $request->input('user_type');
        $owner = User::find($id);
        $previous_image = $owner->image;
        $owner->name = $request->input('name');
        $owner->mobile =$request->input('mobile');
        $owner->email = $request->input('email');
        $owner->user_type = $user_type;
        $owner->city = $request->input('city');
        $owner->state = $request->input('state');
        $owner->address = $request->input('address');
        $owner->pin = $request->input('pin');
        $owner->password = Hash::make($request->input('password'));

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name =time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();
            $destination = ($user_type == 1) ? public_path(). '/images/owner' : public_path(). '/images/driver';
            File::isDirectory($destination) or File::makeDirectory($destination, 0777, true, true);
            if(!empty($previous_image)){
                File::exists($destination);
            }

            $destinationPath = ($user_type == 1) ? public_path() . '/images/owner' :  public_path() . '/images/driver';
            $img = Image::make($image->getRealPath());
            $img->save($destinationPath . '/' . $image_name);

            $thumb =  ($user_type == 1) ? public_path().'/images/owner/thumb' : public_path().'/images/driver/thumb';
            $img = Image::make($image->getRealPath());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb . '/' . $image_name);
            $owner->image = $image_name;
        }
        $owner->save();
        if($owner){
            $response = [
                'status' => true,
                'message' => 'Client Data Updated Successfully',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong Please Try Again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function clientVerify($mobile,$type)
    {
        $owner = User::select('id','name')->where('mobile',$mobile)->where('user_type',$type)->first();
        if ($owner) {
            $response = [
                'status' => true,
                'message' => 'Client Varified successfully',
                'data' => $owner,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'No User Found',
                'data' => null,
            ];
            return response()->json($response, 200);
        }

    }

    public function addDriver(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'owner_id'=>'required',
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:user,mobile',
            'password'=>'required|string|min:8',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $check_owner = User::where('id',$request->input('owner_id'))->where('user_type',1);
        if ($check_owner->count() == 0) {
            $response = [
                'status' => false,
                'message' => 'Sorry Owner Not Found',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
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
        $driver->password = Hash::make($request->input('password'));

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
        if($driver->save()){
            $response = [
                'status' => true,
                'message' => 'Driver Registered Successfully',
                'error_code' => true,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong Please Try Again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

    }

    public function ownerDriverList($owner_id){
        $driver = User::select('id','name','mobile','status')->where('owner_id',$owner_id)->get();
        $response = [
            'status' => true,
            'message' => 'Driver List',
            'data' => $driver,
        ];
        return response()->json($response, 200);
    }

    public function driverStatusUpdate($driver_id,$status)
    {
        $driver = User::find($driver_id);
        if($driver){
            $driver->status = $status;
            $driver->save();
        }
        $response = [
            'status' => true,
            'message' => 'Status Updated Successfully',
        ];
        return response()->json($response, 200);
    }

}
