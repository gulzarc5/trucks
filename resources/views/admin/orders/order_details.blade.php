@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                Order Details
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (isset($order) && !empty($order))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        {{-- <h3 class="prod_title">{{$client->name}} <a href="{{route('admin.edit_customer_form',['id'=>$customer->id])}}" class="btn btn-warning" style="float:right;margin-top: -8px;"><i class="fa fa-edit"></i></a></h3> --}}
                        {{-- <p>{{$product->p_short_desc}}</p> --}}
                        <div class="row product-view-tag">
                            <h5 class="col-md-12 col-sm-12 col-xs-12"><strong>Customer Details</strong><hr>
                            </h5>
                            
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Name :</strong>
                                    {{isset($order->customer->name) ? $order->customer->name : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>User Type:</strong>
                                @if (isset($order->customer->user_type))                                    
                                    @if ($order->customer->user_type == '1')
                                        Owner
                                    @else
                                        Driver
                                    @endif
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Mobile:</strong>
                                {{isset($order->customer->mobile) ? $order->customer->mobile : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Email:</strong>
                                {{isset($order->customer->email) ? $order->customer->email : ''}}
                            </h5>



                            <h5 class="col-md-12 col-sm-12 col-xs-12"><hr><strong>Order Details</strong><hr>
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Order Id :</strong>
                                    {{$order->id}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Truck type :</strong>
                                    {{isset($order->truckType->name) ? $order->truckType->name : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Source City:</strong>
                                {{isset($order->sourceCity->mobile) ? $order->sourceCity->mobile : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Destination City:</strong>
                                {{isset($order->destinationCity->mobile) ? $order->destinationCity->mobile : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Weight:</strong>
                                {{isset($order->weight->weight) ? $order->weight->weight : ''}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>No. of trucks:</strong>
                                {{$order->no_of_trucks}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Schedule Date:</strong>
                                {{$order->schedule_date}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Order Date:</strong>
                                {{$order->created_at}}
                            </h5>
                            
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Total Bid:</strong>
                                {{$order->bidTotal->count()}}
                            </h5>
                           
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Approved Bid Amount :</strong>
                                {{$order->amount}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Advance Payment Amount:</strong>
                                {{$order->adv_amount}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Bid Approval Status:</strong>
                                @if ($order->bid_approval_status == '1')
                                    <button class="btn btn-warning btn-xs">Not Approved</button>   
                                @else
                                    <button class="btn btn-info btn-xs">Approved</button>                                 
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Bid Status:</strong>
                                @if ($order->bid_status == '1')
                                    <button class="btn btn-warning btn-xs">New</button>   
                                @elseif ($order->bid_status == '2')
                                    <button class="btn btn-info btn-xs">Open</button> 
                                @elseif ($order->bid_status == '3')
                                    <button class="btn btn-success btn-xs">New</button> 
                                @else
                                    <button class="btn btn-danger btn-xs">New</button> 
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Payment Status:</strong>
                                @if ($order->bid_status == '1')
                                    <button class="btn btn-danger btn-xs">Failed</button>   
                                @elseif ($order->bid_status == '2')
                                    <button class="btn btn-info btn-xs">Paid</button> 
                                @else
                                    <button class="btn btn-warning btn-xs">Pending</button> 
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
