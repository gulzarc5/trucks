@extends('admin.template.admin_master')

@section('content')
<link rel="stylesheet" href="{{asset('admin/dialog_master/simple-modal.css')}}">
<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Journey Details</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="user" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Acton</th>
                                    <th>OrderId</th>
                                    <th>TruckNumber</th>
                                    <th>OwnerName</th>
                                    <th>DriverName</th>
                                    <th>JourneyStartDate</th>
                                    <th>JourneyEndDate</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($journey) && !empty($journey) && (count($journey) > 0 ))
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($journey as $item)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td id="action{{$item->id}}">
                                            @if ($item->status == '1')
                                                <a href="#" class="btn btn-xs btn-primary"  onclick="openModal({{$item->id}},2,{{$item->id}},'Are You Sure To Update On The Way')">On The Way</a>
                                                <a href="#" class="btn btn-xs btn-success"  onclick="openModal({{$item->id}},3,{{$item->id}},'Are You Sure To Update Completed')">Completed</a>
                                            @elseif($item->status == '2')
                                                <a href="#" class="btn btn-xs btn-success"  onclick="openModal({{$item->id}},3,{{$item->id}},'Are You Sure To Update Completed')">Completed</a>
                                            @else
                                                <button class="btn btn-xs btn-success">Done</button>
                                            @endif
                                        </td>
                                        <td>{{ $item->order_id}}</td>
                                        <td>{{ isset($item->truck->truck_number) ? $item->truck->truck_number : ''}}</td>
                                        <td>{{ isset($item->owner->name) ? $item->owner->name : ''}}</td>
                                        <td>{{ isset($item->driver->name) ? $item->driver->name : ''}}</td>
                                        <td>{{ $item->journey_start_date}}</td>
                                        <td>{{ $item->journey_end_date}}</td>
                                        <td>
                                            @if ($item->status == '1')
                                                <a href="#" class="btn btn-xs btn-warning">Assigned</a>
                                            @elseIf($item->status == '2')
                                                <a href="#" class="btn btn-xs btn-primary">On The Way</a>
                                            @else
                                                <a href="#" class="btn btn-xs btn-success">Completed</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="9" style="text-align: center">No Journey Found</td>
                                </tr>
                                @endif
                                <tr>
                                    <td  colspan="9" style="text-align: center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="window.close()">Close</button>
                                    </td>
                                </tr>
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
