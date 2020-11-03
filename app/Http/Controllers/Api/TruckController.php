<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\TruckType;
use App\Models\TruckWeight;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use File;
use Image;
use App\Models\TruckImage;

class TruckController extends Controller
{
    public function addTruck(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'owner_id'=>'required|numeric',
            'driver_mobile'=>'required|numeric',
            'truck_type_id' => 'required',
            'source_city_id'=>'required',
            'capacity_id'=>'required',
            'truck_number'=>'required',
            'images.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
        $owner_id = $request->input('owner_id');
        $driver_mobile = $request->input('driver_mobile');
        $driver_check = User::where('status',1)
        ->where(function($q) use ($driver_mobile){
            $q->where('mobile',$driver_mobile)->where('user_type',2);
        })
        ->orWhere(function($q) use ($owner_id,$driver_mobile){
            $q->where('id',$owner_id)->where('mobile',$driver_mobile)->where('user_type',1);
        });
        if ($driver_check->count() == 0){
            $response = [
                'status' => false,
                'message' => 'Driver Mobile Number Does Not Exist',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

        $driver_data = $driver_check->first();
        $truck = new Truck();
        $truck->truck_type = $request->input('truck_type_id');
        $truck->weight_id = $request->input('capacity_id');
        $truck->owner_id =$owner_id;
        $truck->driver_id = $driver_data->id;
        $truck->source = $request->input('source_city_id');
        $truck->truck_number = $request->input('truck_number');
        if($truck->save()){
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
            $response = [
                'status' => true,
                'message' => 'Truck Added Successfully',
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

    public function truckList($owner_id)
    {
        $truck = Truck::where('owner_id', $owner_id)->get();
        $response = [
            'status' => true,
            'message' => 'Truck List Under Owner',
            'data' => $truck,
        ];
        return response()->json($response, 200);
    }

    public function truckFetchById($truck_id)
    {
        $truck = Truck::find($truck_id);
        $response = [
            'status' => true,
            'message' => 'Truck List Under Owner',
            'data' => $truck,
        ];
        return response()->json($response, 200);
    }

    public function truckTypeList()
    {
        $truck_type = TruckType::select('id','name')->where('status',1)->get();
        $capacity = TruckWeight::select('id','weight')->where('status',1)->get();
        $response = [
            'status' => true,
            'message' => 'Truck Type And Capacity List',
            'data' => [
                'truck_type' => $truck_type,
                'capacity' => $capacity,
            ],
        ];
        return response()->json($response, 200);
    }
}
