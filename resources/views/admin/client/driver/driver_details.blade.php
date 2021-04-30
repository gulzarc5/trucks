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
                    <h2>Driver Details</h2>
                @endif
              <div class="clearfix"></div>
            </div>
            <!-- top tiles -->
            <div class="row tile_count">
                <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count" style="text-align: center">
                    <span class="count_top"><i class="fa fa-user"></i>Assigned Journey</span>
                    <div class="count green">{{ $assigned_journey }}</div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
                    <span class="count_top"><i class="fa fa-clock-o"></i>On The Way Journey</span>
                    <div class="count green">{{ $on_the_way_journey }}</div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
                    <span class="count_top"><i class="fa fa-user"></i>Completed Journey</span>
                    <div class="count green">{{ $completed_journey }}</div>
                </div>   
            </div>
            <!-- /top tiles -->
            <div class="x_content">
                @if (isset($client) && !empty($client))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
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
                                    <button class="btn btn-xs btn-primary">Enabled</button>
                                @else
                                    <button class="btn btn-xs btn-danger">Disabled</button>
                                @endif
                            </h5>
                        </div>
                        <br/>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        @if (isset($client->driverOwner) && !empty($client->driverOwner))                            
                            <div class="col-md-12 cpol-sm-12 col-xs-12">
                                <h4><strong>Owner Details</strong></h4><hr>
                                <div class="row product-view-tag">
                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Name:</strong>
                                            {{ $client->driverOwner->name ?? null }}
                                    </h5>
                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Mobile:</strong>
                                        {{ $client->driverOwner->mobile ?? null }}
                                    </h5>
                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Email:</strong>
                                        {{ $client->driverOwner->email ?? null }}
                                    </h5>

                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>State:</strong>
                                        {{isset($client->driverOwner->state_data->name) ? $client->driverOwner->state_data->name : ''}}
                                    </h5>
                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>City:</strong>
                                        {{isset($client->driverOwner->city_data->name) ? $client->driverOwner->city_data->name : ''}}
                                    </h5>
                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Address:</strong>
                                        {{ $client->driverOwner->address ?? null }}
                                    </h5>
                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Pin:</strong>
                                        {{ $client->driverOwner->pin ?? null }}
                                    </h5>

                                    <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Status :</strong>
                                        @if ( isset($client->driverOwner->status) && $client->driverOwner->status == '1')
                                            <button class="btn btn-xs btn-primary">Enabled</button>
                                        @else
                                            <button class="btn btn-xs btn-danger">Disabled</button>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        @endif
                    </div>

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
