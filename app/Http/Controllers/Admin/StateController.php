<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
class StateController extends Controller
{
    public function stateList(){
        $states = State::get();
        return view('admin.state.state_list',compact('states'));
    }
    public function stateAddForm(){
        return view('admin.state.state_add_form');
    }

    public function addState(Request $request){
        $this->validate($request, [
            'name'=>'required'
        ]);
        $state = new State;
        $state->name = $request->input('name');
        $state->save();
        if($state){
            return redirect()->back()->with('message','State Added Successfully');
        }


    }

    public function stateStatus($id,$status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $states = State::where('id',$id)->first();
        $states->status=$status;
        $states->save();
        return redirect()->back();
    }

    public function editState($id){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }

        $states = State::where('id',$id)->first();
        return view('admin.state.state_add_Form',compact('states'));
    }

    public function updateState(Request $request,$id){   
        $this->validate($request, [
            'name'   => 'required'
            
        ]);
        State::where('id',$id)
            ->update([
                'name'=>$request->input('name'),
                
            ]);
            return redirect()->back()->with('message','State Updated Successfully');
        
    }
}
