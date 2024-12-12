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
                                <span class="caption-subject bold uppercase"> {{ $log_title }}</span>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover order-column">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>#TRX</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Charge</th>
                                    <th>Status</th>
                                    <th>At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td><a href="{{ route('ad.withdraw.log', $log->user->id) }}">{{ $log->user->name }}</a></td>
                                        <td>{{$log->transaction_id}}</td>
                                        <td>{{$log->method->name}}</td>
                                        <td>{{$log->amount}} {{$gnl->cur}}</td>
                                        <td>{{$log->charge}} {{$gnl->cur}}</td>
                                        <td>
                                            @if($log->status == 1)
                                                Pending
                                            @elseif($log->status == 2)
                                                Completed
                                            @elseif($log->status == 3)
                                                Refunded
                                            @endif
                                        </td>
                                        <td>{{ $log->created_at->diffForHumans() }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" title="Additional Information" data-toggle="popover" data-trigger="click" data-placement="left" data-content="{{ $log->send_details }} <br><br> {{ $log->message }}"><i class="fa fa-eye"></i></button>
                                            @if($log->status == 1)
                                                <button class="btn btn-success btn-sm btn-approve" title="Approve Request" data-toggle="tooltip" data-id="{{ $log->id }}"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-danger btn-sm btn-refund" title="Refund Request" data-toggle="tooltip" data-id="{{ $log->id }}"><i class="fa fa-sign-out"></i></button>
                                            @endif
                                        </td>
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


    <div class="modal fade" id="approve">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></i> <strong>Approve Request</strong> </h4>
                </div>
                <form method="POST" action="{{ route('ad.withdraw.action', 'approve') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="mo-a-id">
                    <div class="modal-body">
                        <h3 class="text-center text-success">Are You Sure To Approve This Request?</h3>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button data-dismiss="modal" class="btn btn-default btn-block"> Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-block"> Approve</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="refund">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></i> <strong>Refund Request</strong> </h4>
                </div>
                <form method="POST" action="{{ route('ad.withdraw.action', 'refund') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="mo-r-id">
                    <div class="modal-body">
                        <h3 class="text-center text-danger">Are You Sure To Refund This Request?</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Message</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="message" placeholder="Custom Message"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button data-dismiss="modal" class="btn btn-default btn-block"> Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger btn-block"> Refund</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover({
                html: true
            });
            $('[data-toggle="tooltip"]').tooltip({
                html: true
            });
            $(document).on('click', '.btn-approve', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#mo-a-id').val(id);
                $('#approve').modal('show');
            });
            $(document).on('click', '.btn-refund', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#mo-r-id').val(id);
                $('#refund').modal('show');
            });
        });
    </script>
@endsection