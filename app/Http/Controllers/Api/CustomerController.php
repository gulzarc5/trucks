<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SignUpOtp;
use App\SmsHelper\Sms;
use Validator;
use Illuminate\Support\Str;
use Hash;
use PHPUnit\Framework\Constraint\IsFalse;

class CustomerController extends Controller
{
    public function signUpOtp($mobile){
        $customer = Customer::where('mobile',$mobile);
        if ($customer->count() > 0) {
            $response = [
                'status' => false,
                'message' => 'Sorry Mobile Number Already Registered With Us'
            ];
            return response()->json($response, 200);
        }

        $customer = SignUpOtp::firstOrCreate(['mobile' => $mobile]);
        $customer->otp =  rand(11111,99999);
        if($customer->save()) {
            $message = "OTP is $customer->otp . Please Do Not Share With Anyone";
            // Sms::smsSend($customer->mobile,$message);
            $response = [
                'status' => true,
                'message' => 'Otp Sent to Your Mobile Number',
                'data' => $customer,
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'status' => false,
                'message' => 'Sorry Mobile Number Already Registered With Us'
            ];
            return response()->json($response, 200);
        }
    }

    public function signUpOtpVerify($mobile,$otp){
        $check = SignUpOtp::where('mobile',$mobile)->where('otp',$otp)->count();
        if($check > 0){
            $response = [
                'status' => true,
                'message' => 'OTP Verified Successfully'
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Sorry OTP is Invalid'
            ];
            return response()->json($response, 200);
        }
    }

    public function customerRegistration(Request $request){
        $messsage = [
            'required_if' => 'Gender Field Is Required If User is Individual',
        ];
        $validator =  Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'user_type' => 'required|in:1,2',
            'mobile' => 'required|numeric|digits:10|unique:customer,mobile',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'pin' => 'required',
            'password' => 'required|string|min:8',
            'gender' => 'required_if:user_type,1|in:M,F,""',
        ],$messsage);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];
            return response()->json($response, 200);
        }

        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->mobile = $request->input('mobile');
        $customer->user_type = $request->input('user_type');
        $customer->email = $request->input('email');
        $customer->gender = $request->input('gender');
        $customer->state = $request->input('state');
        $customer->city = $request->input('city');
        $customer->address = $request->input('address');
        $customer->pin = $request->input('pin');
        $customer->password =  Hash::make($request->input('password'));
        if ($customer->save()) {
            $customer->api_token = Str::random(60);
            $customer->save();
            $response = [
                'status' => true,
                'message' => 'User Registered Successfully',
                'error_code' => false,
                'error_message' => null,
                'data' => $customer,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Sorry Something went wrong Please try again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function customerLogin(Request $request)
    {
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

        $customer = Customer::where('mobile',$request->input('mobile'))->first();
        if ($customer) {
            if(Hash::check($request->input('password'), $customer->password)){
                $customer->api_token = Str::random(60);
                $customer->save();
                $response = [
                    'status' => true,
                    'message' => 'User Successfully Logged In',
                    'error_code' => false,
                    'error_message' => null,
                    'data' => $customer,
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

    public function profileFetch($id)
    {
        $customer = Customer::find($id);
        $response = [
            'status' => true,
            'message' => 'Customer Profile Data',
            'data' => $customer,
        ];
        return response()->json($response, 200);
    }

    public function profileUpdate(Request $request,$id){
        $validator =  Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'mobile' => 'required|numeric|digits:10|unique:customer,mobile,'. $id,
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'pin' => 'required',
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

        $customer = Customer::find($id);
        $customer->name = $request->input('name');
        $customer->mobile = $request->input('mobile');
        $customer->email = $request->input('email');
        $customer->gender = $request->input('gender');
        $customer->state = $request->input('state');
        $customer->city = $request->input('city');
        $customer->address = $request->input('address');
        $customer->pin = $request->input('pin');
        if ($customer->save()) {
            $response = [
                'status' => true,
                'message' => 'User Data Updated Successfully',
                'error_code' => false,
                'error_message' => null,
                'data' => $customer,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Sorry Something went wrong Please try again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function changePassword(Request $request,$id)
    {
        $validator =  Validator::make($request->all(),[
            'current_pass' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'same:confirm_password'],
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

        $user =Customer::find($id);
        if ($user) {
            if(Hash::check($request->input('current_pass'), $user->password)){
                $user->password = Hash::make($request->input('confirm_password'));
                if ($user->save()) {
                    $response = [
                        'status' => true,
                        'message' => 'Password Changed Successfully',
                        'error_code' => false,
                        'error_message' => null,
                    ];
                    return response()->json($response, 200);
                }else{
                    $response = [
                        'status' => false,
                        'message' => 'Something Went Wrong Please Try Again',
                        'error_code' => false,
                        'error_message' => null,
                    ];
                    return response()->json($response, 200);
                }
            }else{
                $response = [
                    'status' => false,
                    'message' => 'Please Enter Correct Corrent Password',
                    'error_code' => false,
                    'error_message' => null,
                ];
                return response()->json($response, 200);
           }
        } else {
            $response = [
                'status' => false,
                'message' => 'User Not Found Please Try Again',
                'error_code' => false,
                'error_message' => null,
            ];
            return response()->json($response, 200);
        }
    }

    public function forgotOtp($mobile)
    {
        $customer = Customer::where('mobile',$mobile);
        if ($customer->count() == 0) {
            $response = [
                'status' => false,
                'message' => 'Sorry User Does Not Exist'
            ];
            return response()->json($response, 200);
        }

        $customer = $customer->first();
        $customer->otp = rand(11111,99999);
        if ($customer->save()) {
            $message = "OTP is $customer->otp . Please Do Not Share With Anyone";
            // Sms::smsSend($customer->mobile,$message);
            $response = [
                'status' => true,
                'message' => 'OTP Sent Successfully To Registered Mobile Number',
                'otp' => $customer->otp,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong Please Try Again'
            ];
            return response()->json($response, 200);
        }
    }

    public function forgotOtpVerify($mobile,$otp){
        $customer = Customer::where('mobile',$mobile)->where('otp',$otp);
        if($customer->count() > 0){
            $customer = $customer->first();
            $customer->otp = null;
            $customer->save();
            $response = [
                'status' => true,
                'message' => 'OTP Verified Successfully'
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Sorry OTP is Invalid'
            ];
            return response()->json($response, 200);
        }
    }

    public function forgotPasswordChange(Request $request){
        $validator =  Validator::make($request->all(),[
            'mobile' => ['required', 'numeric', 'digits:10'],
            'otp' => ['required', 'numeric', 'digits:5'],
            'password' => ['required', 'string', 'min:8', 'same:confirm_password'],
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
        $mobile = $request->input('mobile');
        $otp = $request->input('otp');
        $customer = Customer::where('mobile',$mobile)->where('otp',$otp);
        if($customer->count() > 0){
            $customer = $customer->first();
            $customer->password =  Hash::make($request->input('confirm_password'));
            $customer->otp = null;
            $customer->save();
            $response = [
                'status' => true,
                'message' => 'Password Changed Successfully'
            ];
            return response()->json($response, 200);
        }else {
            $response = [
                'status' => false,
                'message' => 'Sorry OTP is Invalid'
            ];
            return response()->json($response, 200);
        }
    }

}
