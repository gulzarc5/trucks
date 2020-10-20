@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Truck List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{ route('admin.truck_add_form') }}">Add New Truck</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                    <table id="truck_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Truck Type</th>
                              <th>Weight</th>
                              <th>Owner</th>
                              <th>Driver</th>
                              <th>Source</th>
                              <th>Image</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                            
                          </tbody>
                        </table>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>
	</div>


 @endsection

 @section('script')
     
 <script type="text/javascript">
     
    $(function () {

        var table = $('#truck_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.truck_list_ajax') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'truck_type', name: 'truck_type',searchable: true},
                {data: 'weight_id', name: 'weight_id' ,searchable: true},
                {data: 'owner_id', name: 'owner_id' ,searchable: true},
                {data: 'driver_id', name: 'driver_id' ,searchable: true},
                {data: 'source', name: 'source' ,searchable: true},
               
                {data: 'image', name: 'image' ,searchable: true},
                {data: 'status', name: 'status', render:function(data, type, row){
                if (row.status == '1') {
                    return "<button class='btn btn-info'>Enable</a>"
                }else{
                    return "<button class='btn btn-danger'>Disabled</a>"
                }                        
                }},                  
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>

@endsection