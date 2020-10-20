@extends('admin.template.admin_master')

@section('content')
<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Update Driver Details</h2>
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
    	           
    	            	{{ Form::open(['method' => 'post','route'=>array('admin.update_driver','id'=>$driver->id) , 'enctype'=>'multipart/form-data']) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="name">Driver Name<span><b style="color: red"> * </b></span></label>
                                <input type="text"class="form-control" name="name"  value="{{ $driver->name }}" >
                                @if($errors->has('name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_name">owner Name<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="owner_name">
                                @foreach ($owner as $owner)
                                    @if($owner->id == $driver->owner_id)
                                        <option class="form-control" name="owner_name"  selected value="{{ $owner->id }}" >{{ $owner->name }}</option>
                                    @else
                                        <option class="form-control" name="owner_name"   value="{{ $owner->id }}" >{{ $owner->name }}</option>
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
                                <label for="mobile">Mobile<span><b style="color: red"> * </b></span></label>
                                <input type="tel"class="form-control" name="mobile" value="{{ $driver->mobile }}" >
                                @if($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="email">Email<span><b style="color: red"> * </b></span></label>
                                <input type="email"class="form-control" name="email" value="{{ $driver->email }}" >
                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="driving">Driving By<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="driving">
                                   
                                    @if($driver->driving ==1)
                                        <option value="1" name="driving" selected>By Owner</option>
                                        <option value="2" name="driving">By Driver</option>
                                    @else
                                        <option value="1" name="driving" >By Owner</option>
                                        <option value="2" name="driving" selected>By Driver</option>
                                    @endif
                                </select>
                                @if($errors->has('driving'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('driving') }}</strong>
                                    </span>
                                @enderror
                            </div>
                       </div>

                        <div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="state">State<span><b style="color: red"> * </b></span></label>
                                <select class="form-control" id ="state" name="state" >
                                    @foreach($state as  $value)
                                        @if($value->name == $driver->state)
                                            <option value="{{ $value->id }}" selected name="state">{{ $value->name }}</option>
                                        @else
                                            <option value="{{ $value->id }}"  name="state">{{ $value->name }}</option>
                                        @endif
                                    @endforeach
                                    
                                </select>
                                @if($errors->has('state'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @enderror
                            
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="city">City<span><b style="color: red"> * </b></span></label>
                                <select class="form-control" name="city" id="city">
                                    <option value="">Select City</option>
                                </select>
                                @if($errors->has('city'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="pin">PIN<span><b style="color: red"> * </b></span></label>
                                <input type="pin"class="form-control" name="pin"  value="{{ $driver->pin }}" >
                                @if($errors->has('pin'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('pin') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="address">Address<span><b style="color: red"> * </b></span></label>
                                <textarea class="form-control" name="address"  >{{ $driver->address }}</textarea>
                                @if($errors->has('address'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @enderror
                            </div>
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
                        {{ Form::submit('Save', array('class'=>'btn btn-success')) }}  
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
 @section('script')
 <script type="text/javascript">

     


$(document).ready(function(){
   
        $("#state").change(function(){
                var state_id = $(this).val();
              
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:"GET",
                    url:"{{ url('/admin/client/owner/city/list')}}"+"/"+state_id+"",
                    success:function(data){
                        console.log(data);
                       
                        if ($.isEmptyObject(data)) {
                            $("#city").html("<option value=''>No City Found</option>"); 
                        } else {
                            $("#city").html("<option value=''>Please Select City</option>"); 
                            $.each( data, function( key, value ) {
                                $("#city").append("<option value='"+value.id+"'>"+value.name+"</option>");
                            });                         
                        }
                        

                    }
                });
            });
                
         
});
</script>

@endsection




        
    