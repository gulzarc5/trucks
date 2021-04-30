@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Truck Capacity List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{ route('admin.truck_capacity_add_form') }}">Add New Truck Capacity</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <div class="table-responsive">

                            <table class="table table-striped jambo_table bulk_action table-hover">
                                <thead>
                                    <tr>
                                    <th>Sl</th>
                                    <th>Capacity</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                    $count=1;
                                    @endphp
                                    @forelse ($truck_capacity as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $item->weight }} MT</td>
                                        <td>
                                            <a href="{{ route('admin.edit_truck_capacity_form',['id'=>$item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" style="text-align: center">No Truck Capacity Found</td>
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
