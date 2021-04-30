@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/jquery-confirm-v3.3.4/dist/jquery-confirm.min.css')}}">

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
                        {{ Form::open(['method' => 'post','route'=>'admin.add_truck' , 'enctype'=>'multipart/form-data', 'onsubmit'=>"return checkform()"]) }}
                        <div class="well" style="overflow: auto">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_mobile">Owner Mobile<span><b style="color: red"> * </b></span> <span id="owner_verify_error"></span></label>
                                <input type="text" class="form-control" name="owner_mobile" id="owner_mobile" placeholder="Enter Owner Mobile" onblur="checkOwner(this.value)"/>

                                @if($errors->has('truck'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('truck') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_mobile">Owner Name<span><b style="color: red"> * </b></span></label>
                                <input type="text" class="form-control"  id="owner_name" disabled/>
                            </div>
                        </div>
    	            	<div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="truck_type">Truck Type<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="truck_type">
                                    <option value="">Please Select Truck Type</option>
                                    @if (isset($truck_type) && !empty($truck_type))
                                        @foreach ($truck_type as $item)
                                            <option value="{{$item->id}}">{{ $item->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('truck_type'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('truck_type') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="source_state">Source State</label>
                                <select class="form-control" name="source_state" onchange="cityFetch(this.value)" id="source_state_data">
                                    <option value="">Select State</option>
                                    @foreach($state as $values)
                                        <option value="{{ $values->id }}">{{ $values->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('source_state'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('source_state') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="source_city">Source City<span><b style="color: red"> * </b></span></label>
                                <select class="form-control" name="source_city" id="city">
                                    <option value="">Please Select Source</option>
                                </select>
                                @if($errors->has('source_city'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('source_city') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="capacity">Truck Capacity<span><b style="color: red"> * </b></span></label>
                                <select class="form-control" name="capacity">
                                    <option value="">Please Select Capacity</option>
                                    @foreach($weight as $value)
                                        <option value="{{ $value->id }}" name="weight">{{ $value->weight }} MT</option>
                                    @endforeach
                                </select>
                                @if($errors->has('capacity'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('capacity') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="truck_number">Truck Number<span><b style="color: red"> * </b></span></label>
                                <input type="text"class="form-control" name="truck_number" placeholder="Enter Truck Number"/>
                                @if($errors->has('truck_number'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('truck_number') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="well" style="overflow: auto" id="service_city_div">
                            <div class="col-md-5 col-sm-12 col-xs-12 mb-3">
                                <label for="source_state">Service State</label>
                                <select class="form-control" name="source_state" onchange="serviceCityFetch(this.value,1)">
                                    <option value="">Select State</option>
                                    @foreach($state as $values)
                                        <option value="{{ $values->id }}">{{ $values->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('source_state'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('source_state') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-5 col-sm-12 col-xs-12 mb-3">
                                <label for="service_city">Service City<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="service_city[]" id="city1" required>
                                    <option value="">Please Select Truck Type</option>
                                </select>
                                @if($errors->has('service_city[]'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('service_city[]') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mb-3" style="margin-top: 25px;">
                                <button type="button" class="btn btn-sm btn-info" onclick="addServiceCityDiv()">Add More</button>
                            </div>


                        </div>

                        <div class="well" style="overflow: auto">
                            <div class="form-group">
                                <label for="truck_number">Images
                                    <span><b style="color: red"> * (Maximum 3 Images Can Be Upload)</b></span>
                                </label>

                                <input type="file" class="form-control" name="images[]" multiple>
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
<script src="{{asset('admin/jquery-confirm-v3.3.4/dist/jquery-confirm.min.js')}}"></script>
    <script>
        function cityFetch(state_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"GET",
                url:"{{ url('/admin/city/fetch/by/state/')}}"+"/"+state_id+"",
                success:function(data){
                    if ($.isEmptyObject(data)) {
                        $("#city").html("<option value=''>No City Found</option>");
                    }else {
                        $("#city").html("<option value=''>Please Select City</option>");
                        $.map( data, function( val, i ) {
                            $("#city").append("<option value='"+i+"'>"+val+"</option>");
                        });
                    }
                }
            });
        }
        function serviceCityFetch(state_id,city_div_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"GET",
                url:"{{ url('/admin/city/fetch/by/state/')}}"+"/"+state_id+"",
                success:function(data){
                    if ($.isEmptyObject(data)) {
                        $("#city"+city_div_id).html("<option value=''>No City Found</option>");
                    }else {
                        $("#city"+city_div_id).html("<option value=''>Please Select City</option>");
                        $.map( data, function( val, i ) {
                            $("#city"+city_div_id).append("<option value='"+i+"'>"+val+"</option>");
                        });
                    }
                }
            });
        }

        function checkOwner(mobile){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
            $.ajax({
                method: "GET",
                url   : "{{ url('admin/client/owner/verify/') }}"+"/"+mobile+"",
                success: function(data) {
                    $("#owner_name").val('');
                    $("#owner_verify_error").html('');
                    if ($.isEmptyObject(data.name)) {
                        $("#owner_verify_error").html(`<b style="color:red">Sorry No Owner Found</b>`);
                    } else {
                        $("#owner_name").val(data.name);
                    }
                }
            });
        }

        // function checkDriver(mobile){
        //     var owner = $('#owner_mobile').val();
        //     if (owner) {
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //         });
        //         $.ajax({
        //             method: "GET",
        //             url   : "{{ url('admin/client/driver/verify/') }}"+"/"+mobile+"/"+owner,
        //             success: function(data) {
        //                 $("#driver_name").val('');
        //                 $("#driver_mobile_error").html('');
        //                 if ($.isEmptyObject(data.name)) {
        //                     $("#driver_mobile_error").html(`<b style="color:red">Sorry No Driver Found</b>`);
        //                 } else {
        //                     $("#driver_name").val(data.name);
        //                 }
        //             }
        //         });
        //     }else{
        //         $("#driver_mobile_error").html('<span style="color:red">Please Select Owner First</span>');
        //         $("#driver_mobile").val("");
        //     }
        // }

        function checkform(){
            var numFiles = $('input[type=file]').get(0).files.length;
            if (numFiles < 1) {
                $.confirm({
                    title: 'Oops Validation error!',
                    content: 'Please Choose Atleast One Image',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Try again',
                            btnClass: 'btn-red',
                            action: function(){
                            }
                        },
                        // close: function () {
                        // }
                    }
                });
                return false;
            }else if(numFiles > 3){
                $.confirm({
                    title: 'Oops Validation error!',
                    content: 'Please Select Maximum 3 Images',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Try again',
                            btnClass: 'btn-red',
                            action: function(){
                            }
                        },
                        // close: function () {
                        // }
                    }
                });
                return false;
            }else{
                return true;
            }
        }

        var service_city_count = 2;
        function addServiceCityDiv() {
            var state_data = $("#source_state_data").html();
            var html = `<span id="more_city_div${service_city_count}">
                <div class="col-md-5 col-sm-12 col-xs-12 mb-3">
                    <label for="source_state">Service State</label>
                    <select class="form-control" name="source_state" onchange="serviceCityFetch(this.value,${service_city_count})">
                        ${state_data}
                    </select>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12 mb-3">
                    <label for="service_city">Service City<span><b style="color: red"> * </b></span></label>
                    <select  class="form-control" name="service_city[]" id="city${service_city_count}" required>
                        <option value="">Please Select Truck Type</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-12 col-xs-12 mb-3" style="margin-top: 25px;">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeServiceCityDiv(${service_city_count})">Remove</button>
                </div>
                </span>`;
            service_city_count++;
            $("#service_city_div").append(html);
        }

        function removeServiceCityDiv(id) {
            $("#more_city_div"+id).remove();
            service_city_count--;
        }
    </script>
@endsection
