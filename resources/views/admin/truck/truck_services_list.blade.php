@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Truck Services List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{ route('admin.truck_add_new_service_area_form',['truck_id'=>$truck_id]) }}">Add New Service Area</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <div class="table-responsive">

                            <table class="table table-striped jambo_table bulk_action table-hover">
                                <thead>
                                    <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Is Source</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($service_area as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ isset($item->city->name) ? $item->city->name : ''}}</td>
                                        <td>
                                            @if ($item->is_source == '2')
                                                <button type="button" class="btn btn-xs btn-primary">Yes</button>
                                            @else
                                                <button type="button"  class="btn btn btn-xs btn-warning">No</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == '1')
                                                <button type="button" class="btn btn-xs btn-primary">Enabled</button>
                                            @else
                                                <button type="button"  class="btn btn btn-xs btn-danger">Disabled</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == '1')
                                                <a href="{{ route('admin.truck_services_area_status_update',['service_id'=>$item->id,'status'=>2]) }}" class="btn btn-sm btn-danger">Disable</a>
                                            @else
                                                <a href="{{ route('admin.truck_services_area_status_update',['service_id'=>$item->id,'status'=>1])}}" class="btn btn-sm btn-primary">Enable</a>
                                            @endif
                                            @if ($item->is_source != '2')
                                                <a href="{{ route('admin.truck_services_area_set_source',['service_id'=>$item->id])}}" class="btn btn-sm btn-primary">Set As Source</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center">No Truck Type Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>
	</div>


 @endsection

@section('script')
 @endsection
