@extends('admin.layout.master')

@section('body')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<div class="page-content-wrapper">
    <div class="page-content">

        <h3 class="page-title uppercase bold"> Posts </h3>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <table class="table table-hover table-responsive table-bordered table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>By</th>
                                    <th>Created</th>
                                    <th>Views</th>
                                    <th>Likes</th>
                                    <th>Shares</th>
                                    <th>Comments</th>
                                    <th>Reports</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal for Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></i> <strong>Delete Post</strong> </h4>
            </div>
            <form method="POST" action="{{ route('admin.post.delete') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input type="hidden" name="id" id="delete-id">
                <div class="modal-body">
                    <h3 class="text-center text-danger">Are You Sure To Delete This Post?</h3>
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
    $(document).ready(function () {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.posts.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.name', name: 'user.name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'views', name: 'views' },
                { data: 'likes', name: 'likes' },
                { data: 'shares', name: 'shares' },
                { data: 'comments', name: 'comments' },
                { data: 'reports', name: 'reports' },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return data;
                    }
                }
            ]
        });

        // Handle Delete Modal
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#delete-id').val(id);
            $('#delete').modal();
        });

        // Handle Pin Post
        $(document).on('click', '.pin', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.post("{{ route('admin.post.pin') }}", {
                id: id,
                _token: "{{ csrf_token() }}"
            }).done(function () {
                location.reload();
            });
        });

        // Handle Unpin Post
        $(document).on('click', '.unpin', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.post("{{ route('admin.post.unpin') }}", {
                id: id,
                _token: "{{ csrf_token() }}"
            }).done(function () {
                location.reload();
            });
        });
    });
</script>
@endsection