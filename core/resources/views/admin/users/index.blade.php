@extends('admin.layout.master')

@section('body')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
                                <span class="caption-subject bold uppercase"> User List</span>
                            </div>
                            <div class="actions">
                                <form method="POST" class="form-inline" action="{{route('search.users')}}">
                                    {{csrf_field()}}
                                   <!-- <input type="text" name="search" class="form-control" placeholder="Search">
                                    <button class="btn btn-outline btn-circle btn-sm green" type="submit"> <i class="fa fa-search"></i></button>-->

                                </form>
                            </div>

                        </div>
                        <div class="portlet-body">

                            <table id="myTable" class="table table-striped table-bordered table-hover order-column">
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
                                        Last Seen
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
                                        @if(Cache::has('user-is-online-' . $user->id))
                                        <td style="color: #40A45B !important; font-weight: 600;">
                                            online
                                        </td>
                                        @else
                                        <td>
                                            {{$user->last_seen}}
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{route('user.single', $user->id)}}" class="btn btn-outline btn-circle btn-sm green">
                                                <i class="fa fa-eye"></i> View </a>
                                                
                                            <a href="#" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm green delete">
                                                 Delete </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tbody>
                            </table>
                            
                        </div>

                    </div><!-- row -->
                </div>
            </div>


    </div>
    </div>
    
    
    
    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></i> <strong>Delete User</strong> </h4>
                </div>
                <form method="POST" action="{{ route('admin.user.delete') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="delete-id">
                    <div class="modal-body">
                        <h3 class="text-center text-danger">Are You Sure To Delete This User?</h3>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button data-dismiss="modal" class="btn btn-default btn-block"> Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger btn-block"> Delete</button>
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
        (function ($) {
            $(document).ready(function (e) {
				$('#myTable').DataTable({
					 "order": [[ 4, "desc" ]]
				});
                $('[data-toggle="tooltip"]').tooltip();
                $(document).on('click', '.delete', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $('#delete-id').val(id);
                    $('#delete').modal();
                });
               
            });
        })(jQuery);
    </script>
@endsection