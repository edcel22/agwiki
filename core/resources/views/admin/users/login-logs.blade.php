@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{ $data['page_title'] }}</h3>
            <hr>


            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> {{ $page_title }}</span>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover order-column">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>IP</th>
                                    <th>Location</th>
                                    <th>Details</th>
                                    <th>At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td><a href="{{ route('user.login-logs', $log->user->id) }}">{{$log->user->name}}</a></td>
                                        <td>{{$log->user_ip}}</td>
                                        <td>{{$log->location}}</td>
                                        <td>{{$log->details}}</td>
                                        <td>{{ $log->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                <tbody>
                            </table>
                            {{ $logs->links() }}
                        </div>

                    </div><!-- row -->
                </div>
            </div>


        </div>
    </div>
@endsection