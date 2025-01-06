@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{ $data['page_title'] }}</h3>
            <hr>


            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover order-column">
                                <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Username
                                    </th>
                                    <th>
                                        Phone
                                    </th>
                                    <th>
                                        Details
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            {{$user->name}}
                                        </td>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            {{$user->username}}
                                        </td>
                                        <td>
                                            {{$user->mobile}}
                                        </td>
                                        <td>
                                            <a href="{{route('user.single', $user->id)}}" class="btn btn-outline btn-circle btn-sm green" data-toggle="tooltip" title="View Profile">
                                                <i class="fa fa-eye"></i> View </a>
                                            <button class="btn btn-success btn-sm btn-approve" title="Approve Request" data-toggle="tooltip" data-id="{{ $user->id }}"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-success btn-sm btn-cancel" title="Cancel Request" data-toggle="tooltip" data-id="{{ $user->id }}"><i class="fa fa-ban"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                <tbody>
                            </table>
                            <?php echo $users->render(); ?>
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
                <form method="POST" action="{{ route('verify.request.action') }}" accept-charset="UTF-8">
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

    <div class="modal fade" id="cancel">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></i> <strong>Cancel Request</strong> </h4>
                </div>
                <form method="POST" action="{{ route('verify.request.cancel') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="mo-c-id">
                    <div class="modal-body">
                        <h3 class="text-center text-success">Are You Sure To Cancel This Request?</h3>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-warning btn-block"> Cancel</button>
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
        $('[data-toggle="tooltip"]').tooltip();
        
        $(document).on('click', '.btn-approve', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#mo-a-id').val(id);
            $('#approve').modal('show');
        });
        $(document).on('click', '.btn-cancel', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#mo-c-id').val(id);
            $('#cancel').modal('show');
        });
    </script>
@endsection