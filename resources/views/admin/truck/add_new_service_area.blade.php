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
                        {{ Form::open(['method' => 'put','route'=>['admin.truck_add_new_service_area',$truck_id]]) }}


                        <div class="well" style="overflow: auto" id="service_city_div">
                            <div class="col-md-5 col-sm-12 col-xs-12 mb-3">
                                <label for="source_state">Service State</label>
                                <select class="form-control" name="source_state" id="source_state_data" onchange="serviceCityFetch(this.value,1)">
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
