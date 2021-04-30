@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/jquery-confirm-v3.3.4/dist/jquery-confirm.min.css')}}">

<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Edit Truck</h2>
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
                        {{ Form::open(['method' => 'post','route'=>['admin.update_truck',['id'=>$truck->id]]]) }}
                        <div class="well" style="overflow: auto">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_mobile">Owner Mobile<span><b style="color: red"> * </b></span> <span id="owner_verify_error"></span></label>
                                <input type="text" class="form-control" name="owner_mobile" id="owner_mobile" placeholder="Enter Owner Mobile" onblur="checkOwner(this.value)" value="{{$truck->owner_mobile}}"/>

                                @if($errors->has('truck'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('truck') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="owner_mobile">Owner Name<span><b style="color: red"> * </b></span></label>
                                <input type="text" class="form-control"  id="owner_name" value="{{$truck->owner_name}}" disabled/>
                            </div>

                        </div>
    	            	<div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="truck_type">Truck Type<span><b style="color: red"> * </b></span></label>
                                <select  class="form-control" name="truck_type">
                                    <option value="">Please Select Truck Type</option>
                                    @if (isset($truck_type) && !empty($truck_type))
                                        @foreach ($truck_type as $item)
                                            <option value="{{$item->id}}" {{ $item->id == $truck->truck_type ? 'selected' : ''}}>{{ $item->name }}</option>
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
                                <select class="form-control" name="source_state" onchange="cityFetch(this.value)">
                                    <option value="">Select State</option>
                                    @if (isset($state) && !empty($state))
                                        @foreach($state as $item)
                                            <option value="{{ $item->id }}"  {{$item->id == $selected_state ? 'selected' : ''}}>{{ $item->name }}</option>
                                        @endforeach
                                    @endif
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
                                    @if (isset($city) && !empty($city))
                                        @foreach ($city as $item)
                                            <option value="{{ $item->id }}" {{$item->id == $truck->source ? 'selected' : ''}}>{{ $item->name }}</option>
                                        @endforeach
                                    @endif
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
                                    @if (isset($weight) && !empty($weight))
                                        @foreach($weight as $value)
                                            <option value="{{ $value->id }}" name="weight" {{ $value->id == $truck->weight_id ? 'selected' : '' }}>{{ $value->weight }} MT</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('capacity'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('capacity') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="truck_number">Truck Number<span><b style="color: red"> * </b></span></label>
                                <input type="text"class="form-control" name="truck_number" placeholder="Enter Truck Number" value="{{ $truck->truck_number }}"/>
                                @if($errors->has('truck_number'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('truck_number') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                        {{ Form::submit('Save', array('class'=>'btn btn-sm btn-success')) }}
                        <a class="btn btn-sm btn-danger" onclick="window.close();">Close</a>
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
    </script>
@endsection
