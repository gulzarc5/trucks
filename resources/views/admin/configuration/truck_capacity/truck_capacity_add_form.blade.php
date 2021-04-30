
@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    @if(isset($truck_type) && !empty($truck_type))
                        <h2>Edit Truck Capacity</h2>
                    @else
                        <h2>Add New Truck Capacity</h2>
                    @endif
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
                        @if(isset($truck_capacity) && !empty($truck_capacity))
                            {{Form::model($truck_capacity, ['method' => 'put','route'=>['admin.truck_capacity_update',$truck_capacity->id]])}}
                        @else
                            {{ Form::open(['method' => 'post','route'=>'admin.add_truck_capacity']) }}
                        @endif

                        <div class="form-group">
                            {{ Form::label('weight', 'Truck Capacity in ( MT )')}}
                            {{ Form::number('weight',null,array('class' => 'form-control','placeholder'=>'Enter Truck Capacity  in ( MT )')) }}
                            @if($errors->has('weight'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            @if(isset($truck_type) && !empty($truck_type))
                                {{ Form::submit('Save', array('class'=>'btn btn-success')) }}
                            @else
                                {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
                            @endif
                            <a href="{{route('admin.truck_capacity_list')}}" class="btn btn-warning">Back</a>

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
