@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Truck Type List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{ route('admin.truck_type_add_form') }}">Add New Truck Type</a>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                    $count=1;
                                    @endphp
                                    @forelse ($truck_type as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->status == '1')
                                                <button type="button" class="btn-sm btn-primary">Enabled</button>
                                            @else
                                            <button type="button"  class="btn btn-sm btn-danger">Disabled</button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit_truck_type_form',['id'=>$item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @if ($item->status == '1')
                                            <a href="{{ route('admin.truck_type_status',['id'=>$item->id,'status'=>2]) }}" class="btn btn-sm btn-danger">Disable</a>
                                            @else
                                            <a href="{{ route('admin.truck_type_status',['id'=>$item->id,'status'=>1])}}" class="btn btn-sm btn-primary">Enable</a>
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
