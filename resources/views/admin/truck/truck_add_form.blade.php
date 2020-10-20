@extends('admin.template.admin_master')

@section('content')
<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Add Truck</h2>
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
    	                {{ Form::open(['method' => 'post','route'=>'admin.add_truck' , 'enctype'=>'multipart/form-data']) }}
    	            	<div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="truck">Truck Type<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="truck">
                                    <option value="1" name="truck">Container</option>
                                    <option value="2" name="truck">Truck 20MT/12 wheel</option>
                                </select>
                                @if($errors->has('truck'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('truck') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_name">Owner Name<span><b style="color: red"> * </b></span></label>
                                {{-- <input class="typeahead form-control" id="owner_name" type="text"> --}}
                                <select  class="form-control" name="owner_name">
                                
                                @foreach($owner as $names)
                                   @if($names->status ==1)
                                        <option value="{{ $names->id}} " name="owner_name">{{ $names->name }}</option>
                                    @else
                                        <option value="">No Active Owners</option>
                                    @endif
                                @endforeach
                                   
                                   
                                </select>
                                @if($errors->has('owner_name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('owner_name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="driver_name">Driver Name<span><b style="color: red"> * </b></span></label>
                                {{-- <input class="typeahead form-control" id="driver_name" type="text"> --}}
                                <select  class="form-control" name="driver_name">
                                
                                @foreach($driver as $names)
                                   @if($names->status ==1)
                                        <option value="{{ $names->id}} " name="driver_name">{{ $names->name }}</option>
                                    @else
                                        <option value="">No Active drivers</option>
                                    @endif
                                @endforeach
                                </select>
                                @if($errors->has('driver_name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('driver_name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="source">Source<span><b style="color: red"> * </b></span></label>
                                <select class="form-control" id ="source" name="source" >
                                    @foreach($city as $values)
                                        <option value="{{ $values->id }}" name="city">{{ $values->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('source'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('source') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="weight">Weight<span><b style="color: red"> * </b></span></label>
                                <select class="form-control" name="weight" id="weight">
                                    @if(!empty($weight))
                                        @foreach($weight as $value)
                                            <option value="{{ $value->id }}" name="weight">{{ $value->weight }}</option>
                                        @endforeach
                                    @else
                                        <option value="" >No Weight Found</option>
                                    @endif

                                    
                                </select>
                                @if($errors->has('weight'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('weight') }}</strong>
                                    </span>
                                @enderror
                            </div>
                           
                            
                            
                           
                        </div>
                        <div class="well" style="overflow: auto">
                            <div class="form-group">
                                {{ Form::label('image', 'Image')}} 
                                 <input type="file" class="form-control" name="images">
                                 @if($errors->has('images'))
                                     <span class="invalid-feedback" role="alert" style="color:red">
                                         <strong>{{ $errors->first('images') }}</strong>
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
 