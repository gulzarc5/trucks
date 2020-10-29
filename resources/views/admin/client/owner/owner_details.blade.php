@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="">
        {{-- <div class="page-title">
            <div class="title_left">
                <h3>Owner Detail</h3>
            </div>
        </div> --}}

        <div class="clearfix"></div>

        <div class="row vpanel">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Owner Details </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <section class="content invoice">
                            {{-- <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h3>
                                       Client Tracking ID: <span> 0FGS45GHY56D</span>
                                    </h3>
                                </div>
                            </div> --}}
                            <!-- info row -->
                            @if (isset($owner) && !empty($owner))
                                <div class="row invoice-info">
                                    <div class="col-md-8">
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>Name : </strong>{{$owner->name}}
                                        </address>
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>Email : </strong>{{$owner->email}}
                                        </address>
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>Mobile : </strong>{{$owner->mobile}}
                                        </address>
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>State : </strong>{{!empty($owner->state) ? $owner->state_data->name :''}}
                                        </address>
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>City : </strong>{{!empty($owner->city) ? $owner->city_data->name :''}}
                                        </address>
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>Address : {{$owner->address}}</strong>

                                        </address>
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <address class="font-15">
                                        <strong>Pin : </strong>{{$owner->pin}}
                                        </address>
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="{{asset('images/owner/thumb/'.$owner->image.'')}}" alt="dsfs">
                                    </div>
                                </div>
                            @endif
                            <!-- /.row -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

 @endsection
