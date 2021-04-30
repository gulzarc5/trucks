@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">
    <div class="x_panel">
      <div class="x_title">
        <h3>Product Images</h3>
        <div class="clearfix"></div>
          <div>
             @if (Session::has('message'))
                <div class="alert alert-success" >{{ Session::get('message') }}</div>
             @endif
             @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
             @endif
          </div>
      </div>
      <div class="x_content">
        @if(isset($truck) && isset($images) && !empty($truck) && !empty($images))

        @foreach($images as $image)
        <div class="col-md-4">
          <div class="thumbnail" style="height: 300px; width: 300px;" >
            <div class="image view view-first" style="height: 300px; width: 300px;">
              <img style="width: 100%; display: block;" src="{{ asset('images/trucks/thumb/'.$image->image.'')}}" />
            </div>
          </div>
          <div>

            @if($truck->image == $image->image)
              <a href="" class="btn btn-sm btn-primary">Thumb Image</a>
            @else
                <a href="{{ route('admin.truck_make_cover_image',['truck_id'=>$truck->id,'image_id' =>$image->id ])}}" class="btn btn-sm btn-success">Set As Main Image</a>

              <a href="{{ route('admin.truck_delete_image',['image_id' =>$image->id])}}" class="btn btn-sm btn-danger" >Delete</a>
            @endif
          </div>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="x_panel">
        <div class="x_title">
            <h2>Add More Images</h2>
            <div class="clearfix"></div>
        </div>
        <div>
            <div class="x_content">

              {{ Form::open(['method' => 'post','route'=>'admin.truck_add_new_images' , 'enctype'=>'multipart/form-data']) }}
                <input type="hidden" name="truck_id" value="{{ $truck->id}}">
                 <div class="well" style="overflow: auto" id="image_div">
                      <div class="form-row mb-10">
                          <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                              <label for="size">Image</label>
                              <input type="file" name="images[]" class="form-control" multiple>
                          </div>
                      </div>
                      @if($errors->has('image'))
                          <span class="invalid-feedback" role="alert" style="color:red">
                              <strong>{{ $errors->first('image') }}</strong>
                          </span>
                      @enderror

                 </div>

              <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn btn-success')) }}
              </div>
              {{ Form::close() }}

            </div>
        </div>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>


 @endsection

@section('script')


 @endsection
