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
                                        Current plan
                                    </th>
                                    <th>
                                        Requested Plan
                                    </th>
                                    <th>
                                        Username
                                    </th>
                                    <th>
                                        Balance
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
                                            @if($user->plan == 1 || $user->plan == -2) <strong>FREE</strong>
                                            @elseif($user->plan == 2 || $user->plan == -3) <strong>BASIC</strong>
                                            @elseif($user->plan == 3) <strong>PLUS</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->plan == -2) <strong>BASIC</strong>
                                            @elseif($user->plan == -3) <strong>PLUS</strong>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $user->username }}
                                        </td>
                                        <td>
                                            {{ $user->username }}
                                        </td>
                                        <td>
                                            {{number_format(floatval($user->balance), 2, '.', '')}} {{$gnl->currency}}
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm btn-approve" title="Approve Request" data-toggle="tooltip" data-id="{{ $user->id }}"><i class="fa fa-check"></i></button>
                                            <a href="{{route('user.single', $user->id)}}" class="btn btn-outline btn-circle btn-sm green">
                                                <i class="fa fa-eye"></i> View </a>
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
                <form method="POST" action="{{ route('plan.request.perform') }}" accept-charset="UTF-8">
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
@endsection

@section('script')
    <script>
        $(document).on('click', '.btn-approve', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#mo-a-id').val(id);
            $('#approve').modal('show');
        });
    </script>
@endsection