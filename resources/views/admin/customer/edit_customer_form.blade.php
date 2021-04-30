@extends('admin.template.admin_master')

@section('content')
<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Update Customer Details</h2>
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

    	            	{{ Form::open(['method' => 'post','route'=>array('admin.update_customer','id'=>$customer->id) , 'enctype'=>'multipart/form-data']) }}

                        <div class="well" style="overflow: auto">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="name">Customer Name<span><b style="color: red"> * </b></span></label>
                                <input type="text"class="form-control" name="name"  value="{{ $customer->name }}" >
                                @if($errors->has('name'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="mobile">Mobile<span><b style="color: red"> * </b></span></label>
                                <input type="tel"class="form-control" name="mobile" value="{{ $customer->mobile }}" >
                                @if($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="email">Email<span><b style="color: red"> * </b></span></label>
                                <input type="email"class="form-control" name="email" value="{{ $customer->email }}" >
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
                                <select name="state" class="form-control" onchange="cityFetch(this.value)">
                                    <option value="">Please select State</option>
                                    @if (isset($state) && !empty($state))
                                        @foreach ($state as $item)
                                            <option value="{{$item->id}}" {{$item->id == $customer->state ? 'selected' : ''}}>{{$item->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('state'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="city">City<span><b style="color: red"> * </b></span></label>
                                <select name="city" class="form-control" id="city" >
                                    <option value="">Please select State</option>
                                    @if (isset($city) && !empty($city))
                                        @foreach ($city as $item)
                                            <option value="{{$item->id}}" {{$item->id == $customer->city ? 'selected' : ''}}>{{$item->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('city'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="pin">PIN<span><b style="color: red"> * </b></span></label>
                                <input type="pin"class="form-control" name="pin"  value="{{ $customer->pin }}" >
                                @if($errors->has('pin'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('pin') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="address">Address<span><b style="color: red"> * </b></span></label>
                                <textarea class="form-control" name="address"  >{{ $customer->address }}</textarea>
                                @if($errors->has('address'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('address') }}</strong>
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
    </script>
@endsection





