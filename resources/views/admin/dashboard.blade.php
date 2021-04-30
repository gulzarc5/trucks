@extends('admin.template.admin_master')

@section('content')
<link href="{{asset('admin/vendors/morris.js/morris.css')}}" rel="stylesheet">

<div class="right_col" role="main">
     <!-- top tiles -->
     <div class="row tile_count">
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count" style="text-align: center">
        <span class="count_top"><i class="fa fa-user"></i> Total Owners</span>
        <div class="count green">{{ $owners }}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
        <span class="count_top"><i class="fa fa-clock-o"></i> Total Drivers</span>
        <div class="count green">{{ $drivers }}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
          <span class="count_top"><i class="fa fa-user"></i> Total Customers</span>
          <div class="count green">{{ $customers }}</div>
      </div>
      <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
        <span class="count_top"><i class="fa fa-user"></i> Total Orders</span>
        <div class="count green">{{ $orders }}</div>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count"  style="text-align: center">
        <span class="count_top"><i class="fa fa-user"></i> Total  Journey</span>
        <div class="count green">{{ $journey }}</div>
      </div>      
    </div>
    <!-- /top tiles -->

  <div class="row">

    <div class="col-md-12">
      <div class="col-md-6">
        <div class="table-responsive" style="height: 351px;">
          <h5 style="text-align: center">Latest Orders</h5>
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr>
                  <th>SL No.</th>
                  <th>UserType</th>
                  <th>Source</th>
                  <th>Destination</th>
                  <th>ScheduleDate</th>
              </tr>
            </thead>
            <tbody class="form-text-element">
                  @php
                      $count = 1;
                  @endphp
                  @foreach ($latest_order as $item)
                    <tr>
                      <td>{{$count++}}</td>
                      <td>
                        @if (isset($item->customer->user_type) && !empty($item->customer->user_type))                            
                          @if ($item->customer->user_type == '1')
                              Individual User
                          @else
                              Corporate User
                          @endif
                        @endif
                      </td>
                      <td>{{ isset($item->sourceCity->name) ? $item->sourceCity->name : ''}}</td>
                      <td>{{ isset($item->destinationCity->name) ? $item->destinationCity->name : ''}}</td>
                      <td>{{$item->schedule_date}}</td>
                    </tr>
                  @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6">
          <h5 style="text-align: center">Order Graph</h5>
          <div id="order_graph2"></div>
      </div>
    </div>

    <div class="col-md-12">
      <hr>
      <div class="col-md-6">
        <div class="table-responsive" style="height: 351px;">
          <h5 style="text-align: center">Latest Journey</h5>
          <table class="table table-striped jambo_table bulk_action">
            <thead>
              <tr>
                  <th>JourneyId</th>
                  <th>TruckNumber</th>
                  <th>Source</th>
                  <th>Destination</th>
                  <th>Status</th>
                  <th>Date</th>
              </tr>
            </thead>
            <tbody class="form-text-element">
                  @php
                      $count = 1;
                  @endphp
                  @foreach ($latest_journey as $item)
                  <tr>
                    <td>{{$count++}}</td>
                    <td>{{ isset($item->truck->truck_number)? $item->truck->truck_number : ''}}</td>
                    <td>
                      {{isset($item->order->sourceCity->name) ? $item->order->sourceCity->name : '' }}
                    </td>
                    <td>
                      {{isset($item->order->destinationCity->name) ? $item->order->destinationCity->name : '' }}
                    </td>
                    <td>
                      @if ($item->status == '1')
                          <button class="btn btn-xs btn-warning">Assigned</button>
                      @elseif ($item->status == '2')
                          <button class="btn btn-xs btn-info">On The Way</button>
                      @else
                          <button class="btn btn-xs btn-primary">Completed</button>                          
                      @endif
                    </td>
                    <td>{{ $item->created_at }}</td>
                  </tr>
                  @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6">
        <h5 style="text-align: center">Journey Graph</h5>
        <div id="order_graph1"></div>
      </div>
    </div>

  </div>
</div>
 @endsection

 @section('script')
 <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
 <script src="{{asset('admin/vendors/morris.js/morris.js')}}"></script>

 <script>



    // var data = [
    //   { y: '2014', b: 90},
    //   { y: '2015', b: 75},
    //   { y: '2016', b: 50},
    //   { y: '2017', b: 60},
    //   { y: '2018', b: 65},
    //   { y: '2019', b: 70},
    //   { y: '2020', b: 75},
    //   { y: '2021', b: 75},
    //   { y: '2022', b: 85},
    //   { y: '2023', b: 85},
    //   { y: '2024', b: 95}
    // ],
    var data = [
        @for($i = 0; $i < 11; $i++)
            @if($i==10)
                { y:"{{$chart[$i]['level']}}", b: {{$chart[$i]['orders_count']}}}
            @else
                { y: "{{$chart[$i]['level']}}", b: {{$chart[$i]['orders_count']}}},
            @endif
        @endFor
    ],
        formatY = function (y) {
            return '$'+y;
        },
        formatX = function (x) {
            return x.src.y;
        },
        config = {
            xLabels: 'month',
            data: data,
            xkey: 'y',
            ykeys: ['b'],
            labels: ['Total Orders'],
            fillOpacity: 0.6,
            stacked: true,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['red']
        };

        config.element = 'order_graph2';
        Morris.Area(config);


        var data = [
        @for($i = 0; $i < 11; $i++)
            @if($i==10)
                { y:"{{$chartJourney[$i]['level']}}", b: {{$chartJourney[$i]['journey_count']}}}
            @else
                { y: "{{$chartJourney[$i]['level']}}", b: {{$chartJourney[$i]['journey_count']}}},
            @endif
        @endFor
    ],
        formatY = function (y) {
            return '$'+y;
        },
        formatX = function (x) {
            return x.src.y;
        },
        config = {
            xLabels: 'month',
            data: data,
            xkey: 'y',
            ykeys: ['b'],
            labels: ['Total Journey'],
            fillOpacity: 0.6,
            stacked: true,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors:['red']
        };

        config.element = 'order_graph1';
        Morris.Area(config);
    </script>
 </script>
     
 @endsection
