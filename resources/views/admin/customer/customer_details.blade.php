@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Customer Details</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (isset($customer) && !empty($customer))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        <h3 class="prod_title">{{$customer->name}} <a href="{{route('admin.edit_customer_form',['id'=>$customer->id])}}" class="btn btn-warning" style="float:right;margin-top: -8px;"><i class="fa fa-edit"></i></a></h3>
                        {{-- <p>{{$product->p_short_desc}}</p> --}}
                        <div class="row product-view-tag">
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Name:</strong>
                                    {{$customer->name}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Client Type:</strong>
                                @if ($customer->clientType == '1')
                                    Normal User
                                @else
                                    Corporate Shop
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Mobile:</strong>
                                {{$customer->mobile}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Email:</strong>
                                {{$customer->email}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Gender:</strong>
                                @if ($customer->gender == 'M')
                                    Normal User
                                @else
                                    Corporate Shop
                                @endif
                            </h5>

                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>State:</strong>
                                {{$customer->state}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>City:</strong>
                                {{$customer->city}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Address:</strong>
                                {{$customer->address}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Pin:</strong>
                                {{$customer->pin}}
                            </h5>

                            <h5 class="col-md-4 col-sm-4 col-xs-12"><strong>Status :</strong>
                                @if ($customer->status == '1')
                                    <button class="btn btn-sm btn-primary">Enabled</button>
                                @else
                                    <button class="btn btn-sm btn-danger">Disabled</button>
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-4 col-xs-12"><strong>Profile Approve Status :</strong>
                                @if ($customer->profile_status == '2')
                                    <button class="btn btn-sm btn-primary">Yes</button>
                                @else
                                    <button class="btn btn-sm btn-danger">No</button>
                                @endif
                            </h5>

                        </div>
                        <br/>

                    </div>
                    @if (isset($client->images))
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h3 class="prod_title">Images <a href="{{route('admin.client_images',['client_id' => $client->id])}}" class="btn btn-warning" style="float:right;margin-top: -8px;"><i class="fa fa-edit"></i></a></h3>
                            <div class="product-image" style="text-align: center">
                                <img src="{{asset('images/client/thumb/'.$client->image.'')}}" alt="..." style="height: 200px;width: 300px;"/>
                            </div>

                            <div class="product_gallery">
                                @foreach ($client->images as $item)
                                    @if ($client->image != $item->image)
                                    <a>
                                        <img src="{{asset('images/client/thumb/'.$item->image.'')}}" alt="..." />
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (isset($client->jobs))
                        <div class="col-md-12">
                            <hr>
                            <h3>Client Service List <a class="btn btn-warning" style="float:right" href="{{route('admin.client_services_edit',['client_id'=>$client->id])}}">Edit Services</a></h3>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Description</th>
                                    <th>M.R.P.</th>
                                    <th>Price</th>
                                    <th>Service Available</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->jobs as $item)
                                    <tr>
                                        <td>{{$item->jobCategory->name}}</td>
                                        <td>{{$item->description}}</td>
                                        <td>{{$item->mrp}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>
                                            @if($item->is_man == 2)
                                               <label class="label label-success">MAN</label>
                                            @endif
                                            @if($item->is_woman == 2)
                                                <label class="label label-success">WOMAN</label>
                                            @endif
                                            @if($item->is_kids == 2)
                                                <label class="label label-success">KIDS</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 1)
                                               <label class="label label-success">Enabled</label>
                                           @else
                                            <label class="label label-danger">Disabled</label>
                                           @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    @endif

                    @if (isset($product->productColors))
                        <div class="col-md-12">
                            <hr>
                            <h3>Product Colors <a class="btn btn-warning" style="float:right" href="">Edit colors</a></h3>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><b>Name</b></th>
                                    <th><b>Color</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->productColors as $item)
                                    <tr>
                                        <td>{{$item->color->name}}</td>
                                        <td><div style="background-color:{{$item->color->color}}; height:10px;"></div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    @endif
                    @if (!empty($product->size_chart))
                        <div class="col-md-12">
                            <div class="product_price">
                                <h3 style="margin: 0">Size Chart</h3><hr style="margin: 10px 0;border-top: 1px solid #ddd;">
                                <img src="{{asset('images/products/'.$product->size_chart.'')}}" alt="..." style="height: 400px;"/>
                            </div>
                        </div>
                    @endif

                @endif
                <div class="col-md-12">
                    <button class="btn btn-danger" onclick="window.close();">Close Window</button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

 @endsection
