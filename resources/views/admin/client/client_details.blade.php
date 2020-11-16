@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                @if (isset($client) && !empty($client))
                    @if ($client->user_type == '1')
                        <h2>Owner Details</h2>
                    @else
                        <h2>Driver Details</h2>
                    @endif
                @endif
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (isset($client) && !empty($client))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        {{-- <h3 class="prod_title">{{$client->name}} <a href="{{route('admin.edit_customer_form',['id'=>$customer->id])}}" class="btn btn-warning" style="float:right;margin-top: -8px;"><i class="fa fa-edit"></i></a></h3> --}}
                        {{-- <p>{{$product->p_short_desc}}</p> --}}
                        <div class="row product-view-tag">
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Name:</strong>
                                    {{$client->name}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Client Type:</strong>
                                @if ($client->user_type == '1')
                                    Owner
                                @else
                                    Driver
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Mobile:</strong>
                                {{$client->mobile}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Email:</strong>
                                {{$client->email}}
                            </h5>

                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>State:</strong>
                                {{isset($client->state_data->name) ? $client->state_data->name : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>City:</strong>
                                {{isset($client->city_data->name) ? $client->city_data->name : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Address:</strong>
                                {{$client->address}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Pin:</strong>
                                {{$client->pin}}
                            </h5>

                            <h5 class="col-md-4 col-sm-4 col-xs-12"><strong>Status :</strong>
                                @if ($client->status == '1')
                                    <button class="btn btn-sm btn-primary">Enabled</button>
                                @else
                                    <button class="btn btn-sm btn-danger">Disabled</button>
                                @endif
                            </h5>
                            {{-- <h5 class="col-md-4 col-sm-4 col-xs-12"><strong>Profile Approve Status :</strong>
                                @if ($customer->profile_status == '2')
                                    <button class="btn btn-sm btn-primary">Yes</button>
                                @else
                                    <button class="btn btn-sm btn-danger">No</button>
                                @endif
                            </h5> --}}

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

                    @if (isset($client->trucks) && ($client->trucks->count() > 0))
                        <div class="col-md-12">
                            <hr>
                            <h3>Client Truck List </h3>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Truck Type</th>
                                    <th>Truck Number</th>
                                    <th>Truck Weight</th>
                                    <th>Driver Name</th>
                                    <th>Source City</th>
                                    <th>Service Available</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->trucks as $item)
                                    <tr>
                                        <td>{{isset($item->truckType->name) ? $item->truckType->name : ''}}</td>
                                        <td>{{$item->truck_number}}</td>
                                        <td>{{isset($item->capacity->weight) ? $item->capacity->weight." M.T." : ''}}</td>
                                        <td>{{isset($item->driver->name) ? $item->driver->name : ''}}</td>
                                        <td>{{isset($item->sourceCity->name) ? $item->sourceCity->name : ''}}</td>
                                        <td>
                                            @foreach ($item->serviceCity as $item)
                                                {{isset($item->city->name) ? $item->city->name : ''}},
                                            @endforeach
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

                    @if (isset($client->drivers) && ($client->drivers->count() > 0))
                        <div class="col-md-12">
                            <hr>
                            <h3>Drivers</h3>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Truck No.</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->drivers as $item)
                                    <tr>
                                        <td>{{$item->name}} {{$item->id}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td>{{isset($item->driverTruck->truck_number) ? $item->driverTruck->truck_number : ""}}</td>
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
