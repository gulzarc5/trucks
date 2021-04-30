@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">

      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
                <h2>Truck Details</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (isset($truck) && !empty($truck))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        {{-- <h3 class="prod_title">{{$client->name}} <a href="{{route('admin.edit_customer_form',['id'=>$customer->id])}}" class="btn btn-warning" style="float:right;margin-top: -8px;"><i class="fa fa-edit"></i></a></h3> --}}
                        {{-- <p>{{$product->p_short_desc}}</p> --}}
                        <div class="row product-view-tag">
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Owner Name : </strong>
                                   {{ $truck->owner->name ?? null }}
                            </h5>
                            {{-- <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Driver Name : </strong>
                                {{isset($truck->driver->name) ? $truck->driver->name : ''}}
                            </h5> --}}
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Truck Type : </strong>
                                {{ $truck->truckType->name ?? null}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Source State : </strong>
                                {{ $truck->sourceCity->state->name ?? null }}
                            </h5>

                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Source City : </strong>
                                {{ $truck->sourceCity->name ?? null }}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Truck Capacity : </strong>
                                {{ $truck->capacity->weight ?? null }} M.T.
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Truck Number :</strong>
                                {{$truck->truck_number}}
                            </h5>

                        </div>
                        <br/>

                    </div>

                    @if (isset($truck->serviceCity) && ($truck->serviceCity->count() > 0))
                        <div class="col-md-12">
                            <hr>
                            <h3>Service City List </h3>
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>State</th>
                                    <th>Ciity</th>
                                    <th>Is Source</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($truck->serviceCity as $item)
                                    <tr>
                                        <td>{{isset($item->city->state->name) ? $item->city->state->name : ''}}</td>
                                        <td>{{isset($item->city->name) ? $item->city->name : ''}}</td>
                                        <td>
                                            @if($item->is_source == 2)
                                               <label class="label label-success">Yes</label>
                                           @else
                                            <label class="label label-danger">No</label>
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
