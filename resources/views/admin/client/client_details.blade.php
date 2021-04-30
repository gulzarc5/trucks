@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Owner Details</h2>
                <div class="clearfix"></div>
            </div>
            <!-- top tiles -->
            <div class="row tile_count">
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count" style="text-align: center">
                    <span class="count_top">Pending Bids</span>
                    <div class="count green">{{ $pending_bids }}</div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count" style="text-align: center">
                    <span class="count_top">Rejected Bids</span>
                    <div class="count green">{{ $rejected_bids }}</div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count" style="text-align: center">
                    <span class="count_top">Accepted Bids</span>
                    <div class="count green">{{ $accepted_bids }}</div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count" style="text-align: center">
                    <span class="count_top">Assigned Journey</span>
                    <div class="count green">{{ $assigned_journey }}</div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
                    <span class="count_top">On The Way Journey</span>
                    <div class="count green">{{ $on_the_way_journey }}</div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
                    <span class="count_top">Completed Journey</span>
                    <div class="count green">{{ $completed_journey }}</div>
                </div>   
            </div>
            <!-- /top tiles -->
            <div class="x_content">

                <hr>
                @if (isset($client) && !empty($client))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        <div class="row product-view-tag">
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Name:</strong>
                                    {{$client->name}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Client Type:</strong>
                                @if ($client->user_type == '1')
                                    Owner
                                @elseif($client->type == '2')
                                    Driver
                                @else
                                    Broker
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

                        </div>
                        <br/>

                    </div>

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
                                    <th>Source City</th>
                                    <th>Service Available</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->trucks as $item)
                                    <tr>
                                        <td>{{ $item->truckType->name ?? null }}</td>
                                        <td>{{ $item->truck_number }}</td>
                                        <td>{{ $item->capacity->weight." M.T." ?? null }}</td>
                                        <td>{{ $item->sourceCity->name ?? null }}</td>
                                        <td>
                                            @foreach ($item->serviceCity as $item)
                                                {{ $item->city->name ?? null }},
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($client->drivers as $item)
                                    <tr>
                                        <td> {{$item->name}} </td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->mobile}}</td>
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
