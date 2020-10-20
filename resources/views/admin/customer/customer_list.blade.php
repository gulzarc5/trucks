@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Customer List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{ route('admin.customer_add_form') }}">Add New Customer</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="city" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Mobile</th>
                              <th>Email</th>
                              <th>State</th>
                              <th>City</th>
                              <th>Address</th>
                              <th>PIN</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                            @if (isset($customers) && !empty($customers))
                            @php
                              $count=1;
                            @endphp
                                @foreach ($customers as $item)
                                    <tr>
                                      <td>{{ $count++ }}</td>
                                      <td>{{ $item->name }}</td>
                                      <td>{{ $item->mobile }}</td>
                                      <td>{{ $item->email }}</td>
                                      <td>{{ $item->state }}</td>
                                      <td>{{ $item->city }}</td>
                                      <td>{{ $item->address }}</td>
                                      <td>{{ $item->pin }}</td>
                                      @if ($item->status == '1')
                                        <td class="btn btn-sm btn-primary">Enabled</td>
                                      @else
                                        <td class="btn btn-sm btn-danger">Disabled</td>
                                      @endif
                                      <td>
                                        <a href="{{ route('admin.edit_customer_form',['id'=>$item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @if ($item->status == '1')
                                          <a href="{{ route('admin.customer_status',['id'=>encrypt($item->id),'status'=>2]) }}" class="btn btn-sm btn-danger">Disable</a>
                                        @else
                                          <a href="{{ route('admin.customer_status',['id'=>encrypt($item->id),'status'=>1])}}" class="btn btn-sm btn-primary">Enable</a>
                                        @endif
                                      </td>
                                    </tr>
                                @endforeach
                            @else
                              <tr>
                                <td colspan="4" style="text-align: center">No Category Found</td>
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
            var table = $('#city').DataTable();
        });
     </script>
    
 @endsection