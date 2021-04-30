<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\State;
use App\Models\City;
use DataTables;
class CustomerController extends Controller
{
    public function customerList(){
        return view('admin.customer.customer_list');
    }

    public function corporateCustomerList(){
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.customer.corporate_customer_list',compact('customers'));
    }

    public function IndividualCustomerListAjax(Request $request){
       return datatables()->of(Customer::where('user_type',1)->orderBy('id', 'desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
              
                $btn ='<a href="'.route('admin.customer_details',['id'=>$row->id]).'" class="btn btn-info btn-sm" target="_blank">View</a>
                <a href="'.route('admin.edit_customer_form',['id'=>$row->id]).'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                if ($row->status == '1') {
                    $btn .='<a href="'.route('admin.customer_status',['id'=>$row->id,'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                } else {
                    $btn .='<a href="'.route('admin.customer_status',['id'=>$row->id,'status'=>1]).'" class="btn btn-primary btn-sm" >Enable</a>';
                }
                return $btn;
           
            })->addColumn('user_gender', function($row){
               
                    if ($row->gender == 'M'){
                        return 'Male';
                    } else {
                        return 'Female';
                    }
           
            })->addColumn('state_name', function($row){
             
                return isset($row->state) ? $row->state : null;
                
            })->addColumn('city_name', function($row){
                
                return isset($row->city) ? $row->city : null;
               
            })
            ->rawColumns(['action','user_gender','state_name','city_name'])
            ->make(true);
        
    }

    public function CorporateCustomerListAjax(Request $request){
        return datatables()->of(Customer::where('user_type',2)->orderBy('id', 'desc')->get())
             ->addIndexColumn()
             ->addColumn('action', function($row){
               
                 $btn ='<a href="'.route('admin.customer_details',['id'=>$row->id]).'" class="btn btn-info btn-sm" target="_blank">View</a>
                 <a href="'.route('admin.edit_customer_form',['id'=>$row->id]).'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                 if ($row->status == '1') {
                     $btn .='<a href="'.route('admin.customer_status',['id'=>$row->id,'status'=>2]).'" class="btn btn-danger btn-sm" >Disable</a>';
                 } else {
                     $btn .='<a href="'.route('admin.customer_status',['id'=>$row->id,'status'=>1]).'" class="btn btn-primary btn-sm" >Enable</a>';
                 }
                 return $btn;
            
             })->addColumn('user_gender', function($row){
                
                     if ($row->gender == 'M'){
                         return 'Male';
                     } else {
                         return 'Female';
                     }
            
             })->addColumn('state_name', function($row){
              
                 return isset($row->state) ? $row->state : null;
                 
             })->addColumn('city_name', function($row){
                 
                 return isset($row->city) ? $row->city : null;
                
             })
             ->rawColumns(['action','user_gender','state_name','city_name'])
             ->make(true);
         
     }

    
     public function status($id,$status){
        $customer = Customer::where('id',$id)->first();
        $customer->status=$status;
        $customer->save();
        return redirect()->back();
    }

    public function editCustomerForm($id){
        $customer = Customer::where('id',$id)->first();
        $state = State::orderBy('name','asc')->get();
        $city = null;
        if (!empty($customer->state)) {
            $city = City::where('state_id',$customer->state)->orderBy('name','asc')->get();
        }
        return view('admin.customer.edit_customer_form',compact('customer','state','city'));
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

    public function customerDetails($customer_id)
    {
        $customer = Customer::where('id',$customer_id)->first();
        return view('admin.customer.customer_details',compact('customer'));
    }


}
