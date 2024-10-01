@extends('admin.layout.master')

@section('body')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> Ads</h3>
            <a href='{{route('admin.ads.add')}}'>+ Add</a>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-body">
                            <table class="table table-hover table-responsive table-bordered table-stripped" id="myTable">
                                <thead>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>URL</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                    @foreach($ads as $post)
                                        <tr>
                                            
                                            <td><img src="{{ $post->image }}" width="200px"></td>
                                            <td>{{ $post->created_at }}</td>
                                            <td>{{ $post->link}}</td>
                                            <td>{{ $post->content}}</td>
                                            <td>
                                                
                                                <button class="btn btn-danger delete" data-id="{{ $post->id }}" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                <button class="btn edit" onClick="window.location='ads/{{ $post->id }}'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></i> <strong>Delete Ad</strong> </h4>
                </div>
                <form method="POST" action="{{ route('admin.ads.delete') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="delete-id">
                    <div class="modal-body">
                        <h3 class="text-center text-danger">Are You Sure To Delete This Ad?</h3>
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

    <div class="modal fade" id="cancel">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></i> <strong>Cancel Report</strong> </h4>
                </div>
                <form method="POST" action="{{ route('admin.post.cancel') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="cancel-id">
                    <div class="modal-body">
                        <h3 class="text-center text-danger">Are You Sure To Cancel All Reports Of This Post?</h3>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-block"> Cancel</button>
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
				
				$('#myTable').DataTable();
		
				
				
				
                $('[data-toggle="tooltip"]').tooltip();
                $(document).on('click', '.delete', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $('#delete-id').val(id);
                    $('#delete').modal();
                });
                $(document).on('click', '.cancel', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $('#cancel-id').val(id);
                    $('#cancel').modal();
                });
            });
        })(jQuery);
		
		
		
    </script>
@endsection