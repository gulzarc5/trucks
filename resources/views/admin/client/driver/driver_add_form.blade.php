@extends('admin.template.admin_master')

@section('content')
<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Add New Driver</h2>
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
    	                {{ Form::open(['method' => 'post','route'=>'admin.add_driver' , 'enctype'=>'multipart/form-data']) }}
    	            	<div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="name">Driver Name<span><b style="color: red"> * </b></span></label>
                                <input type="text"class="form-control" name="name"  placeholder="Enter Name" >
                                @if($errors->has('name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_name">Owner Name<span><b style="color: red"> * </b></span></label>
                                {{-- <input class="typeahead form-control" id="owner_name" type="text"> --}}
                                <select  class="form-control" name="owner_name">
                                
                                @foreach($owner_name as $names)
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
                                <label for="driving">Driving By<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="driving">
                                    <option selected disabled value="">Choose Driving </option>
                                    <option value="1" name="driving">By Owner</option>
                                    <option value="2" name="driving">By Driver</option>
                                </select>
                                @if($errors->has('driving'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('driving') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="mobile">Mobile<span><b style="color: red"> * </b></span></label>
                                <input type="tel" class="form-control" name="mobile"  placeholder="Enter mobile" >
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
                                <select class="form-control" id ="state" name="state" >
                                    @foreach($state as $values)
                                        <option value="{{ $values->id }}" name="state">{{ $values->name }}</option>
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
 @section('script')
 <script type="text/javascript">
//  $(document).ready(function(){
//      $('#owner_name').on('keyup',function(){
//         var owner_name = $('#owner_name').val();
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//         });
//         $.ajax({
//             method: "GET",
//             url   : "{{ route('admin.retrive_owner_names') }}",
//             data: {owner_name: $('#owner_name').val()},
//             dataType:'json',
//             success: function(response) {
//                 response = JSON.stringify(response);
                
//                 $('#owner_name').html(response);
//             }
//         }); 
//     });
// });
     


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





        
    