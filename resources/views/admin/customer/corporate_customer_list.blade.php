@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Customer List</h2>

    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>PIN</th>
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

       var table = $('#user').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ route('admin.corporate_customer_list_ajax') }}",
           columns: [
               {data: 'DT_RowIndex', name: 'DT_RowIndex'},
               {data: 'name', name: 'name',searchable: true},
               {data: 'email', name: 'email',searchable: true},
               {data: 'mobile', name: 'mobile' ,searchable: true},
               {data: 'user_gender', name: 'user_gender' ,searchable: true},
               {data: 'state_name', name: 'state_name' ,searchable: true},
               {data: 'city_name', name: 'city_name' ,searchable: true},
               {data: 'address', name: 'address' ,searchable: true},
               {data: 'pin', name: 'pin' ,searchable: true},
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
