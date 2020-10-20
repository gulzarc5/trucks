@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Driver List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{ route('admin.driver_add_form') }}">Add New Driver</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                    <table id="driver_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                               <th>Sl No.</th>
                              <th>Name</th>
                              <th>Mobile</th>
                              <th>User Type</th>
                              <th>Driving</th>
                              <th>Image</th>
                              <th>Email</th>
                              <th>Address</th>
                              <th>PIN</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          {{-- <tbody>  
                            @if (isset($drivers) && !empty($drivers))
                            @php
                              $count=1;
                            @endphp
                                @foreach ($drivers as $item)
                                    <tr>
                                      <td>{{ $count++ }}</td>
                                      <td>{{ $item->name }}</td>
                                      <td>{{ $item->mobile }}</td>
                                      <td>{{ $item->email }}</td>
                                      @if($item->driving == 1)
                                        <td>By Owner</td>
                                      @else
                                        <td>By Driver</td>
                                      @endif
                                      <td>{{ $item->state }}</td>
                                      <td>{{ $item->city }}</td>
                                      @if(!empty($item->image))
                                        <td><img src="{{  asset('images/owner/'.$item->image ).''}}"/> </td>
                                      @endif
                                      <td>{{ $item->address }}</td>
                                      <td>{{ $item->pin }}</td>
                                      @if ($item->status == '1')
                                        <td class="btn btn-sm btn-primary">Enabled</td>
                                      @else
                                        <td class="btn btn-sm btn-danger">Disabled</td>
                                      @endif
                                      <td>
                                        <a href="{{ route('admin.edit_driver_form',['id'=>$item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @if ($item->status == '1')
                                          <a href="{{ route('admin.owner_status',['id'=>encrypt($item->id),'status'=>2]) }}" class="btn btn-sm btn-danger">Disable</a>
                                        @else
                                          <a href="{{ route('admin.owner_status',['id'=>encrypt($item->id),'status'=>2]) }}" class="btn btn-sm btn-primary">Enable</a>
                                        @endif
                                      </td>
                                    </tr>
                                @endforeach
                            @else
                              <tr>
                                <td colspan="4" style="text-align: center">No Category Found</td>
                              </tr>  
                            @endif                   
                          </tbody> --}}
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
            var table = $('#driver').DataTable();
        });
        var table = $('#driver_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.driver_list_ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name',searchable: true},
                    {data: 'mobile', name: 'mobile' ,searchable: true},
                    {data: 'user_type', name: 'user_type' ,searchable: true},
                    {data: 'driving_status', name: 'driving_status' ,searchable: true},
                    {data: 'image', name: 'image' ,searchable: true},
                    {data: 'email', name: 'email',searchable: true},
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
    </script>
    
 @endsection