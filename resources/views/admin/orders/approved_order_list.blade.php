@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/dialog_master/simple-modal.css')}}">
<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Approved Orders List</h2>

    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>Sl</th>
                                <th>Action</th>
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
                                @if (isset($approved_orders) && !empty($approved_orders) && (count($approved_orders) > 0 ))
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($approved_orders as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td id="action{{$item->id}}">
                                            <a href="{{route('admin.bid_list',['order_id'=>$item->id])}}" class="btn btn-sm btn-primary" target="_blank">View Bids</a>
                                        </td>
                                        <td>{{ isset($item->customer->name) ? $item->customer->name : ''}}</td>
                                        <td>{{ isset($item->truckType->name) ? $item->truckType->name : ''}}</td>
                                        <td>{{ isset($item->sourceCity->name) ? $item->sourceCity->name : ''}}</td>
                                        <td>{{ isset($item->destinationCity->name) ? $item->destinationCity->name : ''}}</td>
                                        <td>{{ isset($item->weight->weight) ? $item->weight->weight : ''}}</td>
                                        <td>{{ $item->no_of_trucks}}</td>
                                        <td>{{ $item->schedule_date}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9" style="text-align: center">No Orders Found</td>
                                </tr>
                                @endif
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

       var table = $('#user').DataTable();

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
