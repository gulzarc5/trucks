<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bids;
use App\Http\Resources\Journey\ClientPendingJourneyResource;
use App\Http\Resources\Journey\JourneyListResource;
use App\Models\Journey;
use App\Models\OrderCustomer;
use App\Models\Truck;
use App\Models\User;
use Validator;

class JourneyController extends Controller
{
    public function assignJourney(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'bid_id' => 'required',
            'truck_id' => 'required',
            'driver_id' => 'required',
            'truck_no' => 'required_if:truck_id,O',
            'driver_name' => 'required_if:driver_id,O',
            'driver_mobile' => 'required_if:driver_id,O',
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

        $order = OrderCustomer::where('id',$request->input('order_id'))->where('bid_status','!=',4)->first();
        if(!$order){
            $response = [
                'status' => false,
                'message' => 'Sorry Order Not Found',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
        $bid = Bids::where('id',$request->input('bid_id'))->where('status',2)->where('client_id',$request->user()->id)->first();
        if(!$bid){
            $response = [
                'status' => false,
                'message' => 'Sorry Your Bid is Not Approved',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

        $check_started_journey = Journey::where('order_id',$request->input('order_id'))
            ->where('owner_id',$request->user()->id)->count();
        // return $check_started_journey;
        if ($order->no_of_trucks <= $check_started_journey) {
            $response = [
                'status' => false,
                'message' => 'Sorry All The Journey already Added',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }

        $driver = User::find($request->input('driver_id'));
        $journey = new Journey();
        $journey->owner_id = $request->user()->id;
        $journey->order_id = $bid->order_id;
        $journey->bid_id = $bid->id;
        if ($request->input('truck_id') != 'O' ) {
            $truck = Truck::find($request->input('truck_id'));
            if ($truck) {
                $journey->truck_id = $truck->id;
                $journey->truck_no = $truck->truck_number;
            }else{
                $response = [
                    'status' => false,
                    'message' => 'Sorry Truck Not Found',
                    'error_code' => false,
                    'error_message' => null,
                ];
                return response()->json($response, 200);
            }
        }else{
            $journey->truck_no = $request->input('truck_no');
        }
        if ($request->input('driver_id') != 'O' ) {
            $driver = User::find($request->input('driver_id'));
            if ($driver) {
                $journey->driver_id = $driver->id;
                $journey->driver_name = $driver->name;
                $journey->driver_mobile = $driver->mobile;
            }else{
                $response = [
                    'status' => false,
                    'message' => 'Sorry Truck Not Found',
                    'error_code' => false,
                    'error_message' => null,
                ];
                return response()->json($response, 200);
            }
        }else{
            $journey->driver_name = $request->input('driver_name');
            $journey->driver_mobile = $request->input('driver_mobile');
        }

        $journey->save();
        $response = [
            'status' => true,
            'message' => 'Journey Added Successfully',
            'error_code' => false,
            'error_message' => null,
        ];
        return response()->json($response, 200);

    }

    public function JourneyList(Request $request)
    {
        $user_id = $request->user()->id; 
        $user_type = $request->user()->user_type;    // user type  1=owner ,2 =Driver,3 = Broker

        if ($user_type == '1' || $user_type == '3') {
            $journey = Journey::where('owner_id',$user_id)->orderBy('id','desc')->limit(50)->get();
        } else {
            $journey = Journey::where('driver_id',$user_id)->orderBy('id','desc')->limit(50)->get();
        }
        $response = [
            'status' => true,
            'message' => 'My Journey List',
            'data' => JourneyListResource::collection($journey),
        ];
        return response()->json($response, 200);
        
    }

    public function journeyStatusUpdate(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'journey_id' => 'required|numeric',
            'status' => 'required|numeric|in:1,2,3',
        ]);

        $journey_id = $request->input('journey_id');
        $status = $request->input('status');
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Validation Error',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $journey = Journey::find($journey_id);
        $journey->status = $status;
        $journey->save();
        $response = [
            'status' => true,
            'message' => 'Journey Status Updated Successfully',
        ];
        return response()->json($response, 200);
    }
}
