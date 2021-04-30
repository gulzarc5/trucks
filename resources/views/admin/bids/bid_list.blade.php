@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/dialog_master/simple-modal.css')}}">
<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Bid List of order ::</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Acton</th>
                                    <th>Bid by</th>
                                    <th>Bid Amouunt</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($bids) && !empty($bids) && (count($bids) > 0 ))
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($bids as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td id="action{{$item->id}}">
                                            @if ($item->status == '1')
                                                <a href="#" class="btn btn-sm btn-primary"  onclick="openModal({{$item->id}},2,{{$item->id}},'Are You Sure To Approve')">Approve</a>
                                                <a href="#" class="btn btn-sm btn-danger"  onclick="openModal({{$item->id}},3,{{$item->id}},'Are You Sure To Reject')">Reject</a>
                                            @elseIf($item->status == '2')
                                                <a href="#" class="btn btn-sm btn-primary">Approved</a>
                                            @else 
                                                <a href="#" class="btn btn-sm btn-danger">Rejected</a>
                                            @endif
                                        </td>
                                        <td>{{ isset($item->client->name) ? $item->client->name : ''}}</td>
                                        <td>{{ $item->bid_amount}}</td>
                                        <td>
                                            @if ($item->status == '1')
                                                <a href="#" class="btn btn-sm btn-primary">New</a>
                                            @elseIf($item->status == '2')
                                                <a href="#" class="btn btn-sm btn-primary">Accepted</a>
                                            @else
                                                <a href="#" class="btn btn-sm btn-danger">Rejected</a>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at}}</td>
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
                    if (status =='2') {
                        window.location.href = "{{url('admin/order/bid/adv/amount/add/form/')}}"+"/"+order_item_id;
                    } else {                        
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type:"GET",
                            url:"{{url('admin/order/bid/status/update/')}}"+"/"+order_item_id+"/"+status,
    
                            beforeSend: function() {
                                // setting a timeout
                                $("#action"+action_id).html('<i class="fa fa-spinner fa-spin"></i>');
                            },
                            success:function(data){
                                if (status == '2') {
                                    $("#action"+action_id).html(`<button class="btn btn-sm btn-primary">Approved</button>`);
                                }else if(status == '3'){
                                    $("#action"+action_id).html('<button class="btn btn-sm btn-danger">Rejected</button>');
                                }
                            }
                        });
                    }
                }
            }catch(err) {
                console.log(err);
            }
        }
     </script>
@endsection
