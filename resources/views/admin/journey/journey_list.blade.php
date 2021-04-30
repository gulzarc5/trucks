@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/dialog_master/simple-modal.css')}}">
<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Journey List</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Acton</th>
                                    <th>JourneyId</th>
                                    <th>OrderId</th>
                                    <th>TruckNumber</th>
                                    <th>OwnerName</th>
                                    <th>DriverName</th>
                                    <th>JourneyEndDate</th>
                                    <th>Status</th>
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
            ajax: "{{ route('admin.journey_list_ajax') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false,orderable: false},
                {data: 'action', name: 'action',searchable: false,orderable: false},
                {data: 'id', name: 'id' ,searchable: true},
                {data: 'order_id', name: 'order_id' ,searchable: true},
                {data: 'truck_no', name: 'truck_no' ,searchable: true},
                {data: 'owner.name', name: 'owner.name' ,searchable: true},
                {data: 'driver_name', name: 'driver_name' ,searchable: true},
                {data: 'journey_end_date', name: 'journey_end_date' ,searchable: true},
                {data: 'status_tab', name: 'status_tab' ,searchable: false,orderable: false},
                {data: 'created_at', name: 'created_at' ,searchable: true},
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
                    url:"{{url('admin/journey/status/update/')}}"+"/"+order_item_id+"/"+status,

                    beforeSend: function() {
                        // setting a timeout
                        $("#action"+action_id).html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success:function(data){
                        if (status == '2') {
                            $("#action"+action_id).html(`<a href="#" class="btn btn-xs btn-primary">On The Way</a>`);
                        }else if(status == '3'){
                            $("#action"+action_id).html('<a href="#" class="btn btn-xs btn-success">Completed</a>');
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
