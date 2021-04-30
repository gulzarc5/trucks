@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/dialog_master/simple-modal.css')}}">
<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Cancelled Order List</h2>

    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>User Type</th>
                                    <th>Order By</th>
                                    <th>Truck Type</th>
                                    <th>Source</th>
                                    <th>Destinatin</th>
                                    <th>Weight</th>
                                    <th>No of Trucks</th>
                                    <th>Date</th>
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
            ajax: "{{ route('admin.rejected_order_list_ajax') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false,orderable: false},
                {data: 'user_type', name: 'user_type' ,searchable: true},
                {data: 'customer.name', name: 'customer.name' ,searchable: true},
                {data: 'truck_type.name', name: 'truckType.name' ,searchable: true},
                {data: 'source_city.name', name: 'sourceCity.name' ,searchable: true},
                {data: 'destination_city.name', name: 'destinationCity.name' ,searchable: true},
                {data: 'weight.weight', name: 'weight.weight' ,searchable: true},
                {data: 'no_of_trucks', name: 'no_of_trucks' ,searchable: true},
                {data: 'schedule_date', name: 'schedule_date' ,searchable: true},
            ]
        });
    });
 </script>
 <script src="{{asset('admin/dialog_master/simple-modal.js')}}"></script>
     <script>
         async function openModal(order_item_id,status,action_id,msg) {
            this.myModal = new SimpleModal("Attention!", msg);

            try {
                const modalResponse = await myModal.question();
                if (modalResponse) {
                    $.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						type:"GET",
						url:"{{url('admin/order/update/status')}}"+"/"+order_item_id+"/"+status,

						beforeSend: function() {
					        // setting a timeout
					        $("#action"+action_id).html('<i class="fa fa-spinner fa-spin"></i>');
					    },
						success:function(data){
                            if (status == '2') {
                                $("#action"+action_id).html(`<button class="btn btn-sm btn-primary">Approved</button>`);
                            }else if(status == '4'){
                                $("#action"+action_id).html('<button class="btn btn-sm btn-danger">Cancelled</button>');
                            }
						}
					});
                }
            }catch(err) {
                console.log(err);
            }
        }
     </script>
@endsection
