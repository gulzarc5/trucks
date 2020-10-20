<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function customerlist(){
        $customers = Customer::get();
        return view('admin.customer.customer_list',compact('customers'));
    }

    public function customerAddForm(){
        return view('admin.customer.customer_add_form');
    }

    public function addCustomer(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:customer,mobile',
            'email'=>'required|email|unique:customer,email',
            'city'=>'required',
            'state'=>'required',
            'address'=>'required',
            'pin'=>'required',

        ]);

        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->mobile =$request->input('mobile');
        $customer->email = $request->input('email');
        $customer->city = $request->input('city');
        $customer->state = $request->input('state');
        $customer->address = $request->input('address');
        $customer->pin = $request->input('pin');
        $customer->save();

        if($customer){
            return redirect()->back()->with('message','Customer Added Successfully');
        }

    }

    public function status($id,$status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $customer = Customer::where('id',$id)->first();
        $customer->status=$status;
        $customer->save();
        return redirect()->back();
    }

    public function editCustomerForm($id){
        $customer = Customer::where('id',$id)->first();
        return view('admin.customer.edit_customer_form',compact('customer'));
    }

    public function updateCustomer(Request $request,$id){
        $this->validate($request, [
            'name'=>'required',
            'mobile'=>'required|numeric|digits:10|unique:customer,mobile,'.$id,
            'email'=>'required|email|unique:customer,email,'.$id,
            'city'=>'required',
            'state'=>'required',
            'address'=>'required',
            'pin'=>'required',
        ]);

        $customer = Customer::where('id',$id)->first();
        $customer->name = $request->input('name');
        $customer->mobile =$request->input('mobile');
        $customer->email = $request->input('email');
        $customer->city = $request->input('city');
        $customer->state = $request->input('state');
        $customer->address = $request->input('address');
        $customer->pin = $request->input('pin');
        $customer->save();

        if($customer){
            return redirect()->back()->with('message','Customer Details Updated Successfully');
        }


    }


}
