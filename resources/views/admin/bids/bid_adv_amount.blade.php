
@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                        <h2>Add Advance Amount</h2>
                    <div class="clearfix"></div>
                </div>

                 <div>
                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                </div>

                <div>
                    <div class="x_content">

                        {{ Form::open(['method' => 'put','route'=>['admin.bidAdvanceAmountinsert',$bid->id]]) }}
                        <div class="form-group">
                            {{ Form::label('bid_amount', 'Bid Amount')}} 
                            <input type="text" value="{{$bid->bid_amount}}" disabled class="form-control">
                            @if($errors->has('bid_amount'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('bid_amount') }}</strong>
                                </span> 
                            @enderror
                        </div>
                        @if (isset($bid->order->customer->user_type) && !empty($bid->order->customer->user_type))                            
                            <div class="form-group">
                                {{ Form::label('user_type', 'User Type')}} 
                                @if ($bid->order->customer->user_type == '1')                                    
                                    <input type="text"  name="user_type" class="form-control" value="Individual User" disabled>
                                @else                                    
                                    <input type="text"  name="user_type" class="form-control" value="Corporate User" disabled>
                                @endif
                            </div>
                        @endif
                        <div class="form-group">
                            {{ Form::label('adv_amount', 'Advance Amount')}} 
                            <input type="text"  name="adv_amount" class="form-control" value="0">
                            @if($errors->has('adv_amount'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('adv_amount') }}</strong>
                                </span> 
                            @enderror
                        </div>
                       
                       
                        <div class="form-group">                            
                            {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
                            <a href="{{route('admin.city_list')}}" class="btn btn-warning">Back</a>                            
                        </div>
                        {{ Form::close() }}
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="clearfix"></div>
</div>


 @endsection