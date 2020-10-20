@extends('admin.template.admin_master')

@section('content')
<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Add New Customer</h2>
    	            <div class="clearfix"></div>
    	        </div>
                <div>
                     @if (Session::has('message'))
                        <div class="alert alert-success" >{{ Session::get('message') }}</div>
                     @endif
                     @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                     @endif

                </div>
    	        <div>
    	            <div class="x_content">
    	           
    	            	{{ Form::open(['method' => 'post','route'=>'admin.add_customer' , 'enctype'=>'multipart/form-data']) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="name">Customer Name<span><b style="color: red"> * </b></span></label>
                                <input type="text"class="form-control" name="name"  placeholder="Enter Name" >
                                @if($errors->has('name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="mobile">Mobile<span><b style="color: red"> * </b></span></label>
                                <input type="tel"class="form-control" name="mobile"  placeholder="Enter mobile" >
                                @if($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="email">Email<span><b style="color: red"> * </b></span></label>
                                <input type="email"class="form-control" name="email"  placeholder="Enter email" >
                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @enderror
                            </div>
                       </div>
                        <div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="state">State<span><b style="color: red"> * </b></span></label>
                                <input type="state"class="form-control" name="state"  placeholder="Enter state" >
                                @if($errors->has('state'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="city">City<span><b style="color: red"> * </b></span></label>
                                <input type="city"class="form-control" name="city"  placeholder="Enter city" >
                                @if($errors->has('city'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="pin">PIN<span><b style="color: red"> * </b></span></label>
                                <input type="pin"class="form-control" name="pin"  placeholder="Enter pin" >
                                @if($errors->has('pin'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('pin') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="address">Address<span><b style="color: red"> * </b></span></label>
                                <textarea class="form-control" name="address"  placeholder="Enter address" ></textarea>
                                @if($errors->has('address'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">    	            	
                        {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}  
    	            	</div>
    	            	{{ Form::close() }}

    	            </div>
    	        </div>
    	    </div>
    	</div>
    	{{-- <div class="col-md-2"></div> --}}
    </div>
</div>


 @endsection




        
    