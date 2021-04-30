
@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="margin-top:50px;">
            <div class="x_panel">

                <div class="x_title">
                    @if(isset($category) && !empty($category))
                        <h2>Update City</h2> 
                    @else
                        <h2>Add New City</h2>
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
                        @if(isset($city) && !empty($city))
                            {{Form::model($city, ['method' => 'put','route'=>['admin.city_update',$city->id],'enctype'=>'multipart/form-data'])}}
                        @else
                            {{ Form::open(['method' => 'post','route'=>'admin.add_city','enctype'=>'multipart/form-data']) }}
                        @endif
                        <div class="form-group">
                            {{ Form::label('state', 'Select State')}} 
                            @if (isset($state))
                                {!! Form::select('state', $state, $city->state_id,['class' => 'form-control','placeholder'=>'Please Select State']); !!}
                            @else
                                {!! Form::select('state', $states, null, ['class' => 'form-control','placeholder'=>'Please Select State']) !!}
                            @endif

                            @if($errors->has('state'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span> 
                            @enderror
                        </div>
                        <div class="form-group">
                            {{ Form::label('name', 'City Name')}} 
                            {{ Form::text('name',null,array('class' => 'form-control','placeholder'=>'Enter City name')) }}
                            @if($errors->has('name'))
                                <span class="invalid-feedback" role="alert" style="color:red">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span> 
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            @if(isset($category) && !empty($category))
                                {{ Form::submit('Save', array('class'=>'btn btn-success')) }}
                            @else
                                {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
                            @endif
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