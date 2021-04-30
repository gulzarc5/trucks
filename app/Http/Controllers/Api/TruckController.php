<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\TruckType;
use App\Models\TruckWeight;
use App\Models\User;
use App\Models\TruckServiceArea;
use Illuminate\Http\Request;
use Validator;
use File;
use Image;
use App\Models\TruckImage;

use App\Http\Resources\Truck\TruckResource;

class TruckController extends Controller
{
    public function addTruck(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'truck_type_id' => 'required',
            'source_city_id'=>'required',
            'capacity_id'=>'required',
            'truck_number'=>'required',
            'images' => 'nullable|array',
            'images.*'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'service_city'=>'required|array|min:1',
            'service_city.*'=>'required'
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
        $owner_id = $request->user()->id;
        $truck = new Truck();
        $truck->truck_type = $request->input('truck_type_id');
        $truck->weight_id = $request->input('capacity_id');
        $truck->owner_id =$owner_id;
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

            //Service Area
            $service_area = new TruckServiceArea();
            $service_area->truck_id = $truck->id;
            $service_area->service_area = $request->input('source_city_id');
            $service_area->is_source = 2;
            $service_area->save();

            $service_city = $request->input('service_city');
            if (isset($service_city) && count($service_city) > 0) {
                foreach ($service_city as $key => $city) {
                     $check = TruckServiceArea::where('truck_id',$truck->id)->where('service_area',$city)->count();
                     if ($check == 0){
                         $service_area = new TruckServiceArea();
                         $service_area->truck_id = $truck->id;
                         $service_area->service_area = $city;
                         $service_area->save();
                     }
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

    public function truckList(Request $request)
    {
        $truck = Truck::where('owner_id', $request->user()->id)->get();
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
        $truck_type = TruckType::select('id','name')->where('status',1)->get();
        $truck_capacity_list = TruckWeight::select('id','weight')->where('status',1)->get();
        $response = [
            'status' => true,
            'message' => 'Truck List Under Owner',
            'data' => [
                'truck_data' => new TruckResource($truck),
                'truck_types_list' => $truck_type,
                'truck_capacity_list' => $truck_capacity_list,
            ],
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

    public function truckUpdate(Request $request, $truck_id)
    {
        $validator =  Validator::make($request->all(), [
            'truck_type_id' => 'required',
            'source_city_id'=>'required',
            'capacity_id'=>'required',
            'truck_number'=>'required',
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
       
        $truck = Truck::find($truck_id);
        if ($truck) {
            $truck->truck_type = $request->input('truck_type_id');
            $truck->weight_id = $request->input('capacity_id');
            $truck->source = $request->input('source_city_id');
            $truck->truck_number = $request->input('truck_number');
            if($truck->save()){
                $response = [
                    'status' => true,
                    'message' => 'Truck Data Updated Successfully',
                    'error_code' => false,
                    'error_message' => null,
                ];
                return response()->json($response, 200);
            }else {
                $response = [
                    'status' => false,
                    'message' => 'Sorry Something Went Wrong Please Try Again',
                    'error_code' => false,
                    'error_message' => null,
                ];
                return response()->json($response, 200);
            }
        }else {
            $response = [
                'status' => false,
                'message' => 'Sorry Something Went Wrong Please Try Again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function addNewImage(Request $request, $truck_id)
    {
        $validator =  Validator::make($request->all(), [
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
        if ($request->hasFile('images')) {
            for ($i = 0; $i < count($request->file('images')); $i++) {
                $image = $request->file('images')[$i];
                $image_name = $i . time() . date('Y-M-d') . '.' . $image->getClientOriginalExtension();

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
                $truck_image->truck_id = $truck_id;
                $truck_image->save();
            }
        }

        $response = [
            'status' => true,
            'message' => 'Images Added Successfully',
            'error_code' => false,
            'error_message' => null,
        ];
        return response()->json($response, 200);
    }

    public function setTruckImageThumb($truck_id,$image_id)
    {
        $truckImage = TruckImage::find($image_id);
        $truck = Truck::find($truck_id);
        if ($truckImage && $truck) {
            $truck->image = $truckImage->image;
            $truck->save();
            $response = [
                'status' => true,
                'message' => 'Thumbnail Set Successfully',
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Sorry Something Went Wrong Please Try Again',
            ];
            return response()->json($response, 200);
        }
    }

    public function truckImageDelete($image_id)
    {
        $image = TruckImage::find($image_id);
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
        $response = [
            'status' => true,
            'message' => 'Image Deleted Successfully',
        ];
        return response()->json($response, 200);
    }

    public function truckStatusUpdate($truck_id,$status)
    {
        $truck = Truck::find($truck_id);
        $truck->status = $status;
        $truck->save();
        $response = [
            'status' => true,
            'message' => 'Status Updated Successfully',
        ];
        return response()->json($response, 200);
    }

    public function changeDriver(Request $request,$truck_id)
    {
        $validator =  Validator::make($request->all(), [
            'driver_mobile'=>'required|numeric|digits:10',
            'owner_id'=>'required|numeric',
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
        $driver_mobile = $request->input('driver_mobile');
        $owner_id = $request->input('owner_id');
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
                'message' => 'Sorry Driver Does Not Exist ! Please check Driver Mobile number',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
        $driver_data = $driver_check->first();
        $truck = Truck::find($truck_id);
        if ($truck) {
            $truck->driver_id = $driver_data->id;
            $truck->save();
        }
        $response = [
            'status' => true,
            'message' => 'Driver Updated Successfully',
            'error_code' => false,
            'error_message' => null,
        ];
        return response()->json($response, 200);
    }

    public function sourceCityUpdate($service_area_id)
    {
        $service_area = TruckServiceArea::find($service_area_id);
        if($service_area){
            // change previous service city
            $previous_source = TruckServiceArea::where('truck_id',$service_area->truck_id)
            ->update([
                'is_source' => 1,
            ]);
            $service_area->is_source = 2;
            $service_area->save();

            // change truck source city id
            $truck = Truck::find($service_area->truck_id);
            $truck->source = $service_area->service_area;
            $truck->save();
        }
        $response = [
            'status' => true,
            'message' => 'Source City Updated Successfully',
        ];
        return response()->json($response, 200);
    }

    public function serviceAreaStatusUpdate($service_area_id,$status)
    {
        $service_area = TruckServiceArea::find($service_area_id);
        if ($service_area && ($service_area->is_source !=2)){
            $service_area->status = $status;
            $service_area->save();
            $response = [
                'status' => true,
                'message' => 'Status Updated Successfully',
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'status' => false,
                'message' => 'Sorry this service area is assigned to source',
            ];
            return response()->json($response, 200);
        }

    }

    public function addNewServiceArea(Request $request,$truck_id)
    {
        $validator =  Validator::make($request->all(), [
            'service_city'=>'required|array|min:1',
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
        $service_city = $request->input('service_city');
        foreach ($service_city as $key => $city) {
            $check = TruckServiceArea::where('truck_id',$truck_id)->where('service_area',$city)->count();
            if ($check == 0){
                $service_area = new TruckServiceArea();
                $service_area->truck_id = $truck_id;
                $service_area->service_area = $city;
                $service_area->save();
            }
        }

        $response = [
            'status' => true,
            'message' => 'New Service Area Added Successfully',
            'error_code' => false,
            'error_message' => null,
        ];
        return response()->json($response, 200);
    }
}
