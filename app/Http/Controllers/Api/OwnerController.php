<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use File;
use Intervention\Image\Facades\Image;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;
use App\Http\Resources\ClientProfileResource;

class OwnerController extends Controller
{
    public function registration(Request $request)
    {
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

        $owner = User::where('mobile',$request->input('mobile'))->first();
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
            'message' => 'Owner Profile',
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
    }
}
