<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function stateList(){
        $state = State::select('id','name')->where('status',1)->get();
        $response = [
            'status' => true,
            'message' => 'State List',
            'date' => $state,
        ];
        return response()->json($response, 200);
    }

    public function cityList($state_id){
        $city = City::select('id','name')->where('state_id',$state_id)->where('status',1)->get();
        $response = [
            'status' => true,
            'message' => 'City List',
            'date' => $city,
        ];
        return response()->json($response, 200);
    }
}
