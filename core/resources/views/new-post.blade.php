@extends('layouts.user')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">
@endsection

@section('content')
    <article class="post-content section-box">
        <div class="post-inner">
            <header class="post-header">
                <div class="post-data">
                    <div class="post-title-wrap">
                        <h1 class="post-title">New Post</h1>
                    </div>
                </div>
            </header>

            <div class="post-editor clearfix">
                <form action="{{ route('user.post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="post_title" class="control-label">Post Title</label>
                        <input type="text" name="post_title" id="post_title" class="form-control" required>
                    </div>
                    <div class="row" style="margin-top: 15px;margin-bottom: 30px;">
                        <div class="col-md-6">
                            @if($categories && count($categories))
                                <label for="category" class="control-label">Post Category</label>
                                <select name="category" id="category" class="form-control select2">
                                @foreach($categories as $category)
                                    @if($loop->first)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-8">
                                <label class="control-label"></label>
                                <input type="text" id="new_cat" class="form-control" placeholder="New Category">
                            </div>
                            <div class="col-md-4">
                                <label class="control-label"></label>
                                <button class="btn btn-warning" id="addCat">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="post_location" class="control-label">Location</label>
                        <input type="text" name="post_location" id="post_location">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="post_image" class="control-label" style="cursor: pointer;">
                                    <img id="image_container" style="width: 100%;height: 300px;" src="https://via.placeholder.com/517x300?text=Click+For+Select+Image+(517x300)" alt="Select">
                                </label>
                                <input type="file" name="post_image" id="post_image" class="form-control" required style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="post_content" class="control-label">Post Content</label>
                        <textarea name="post_content" id="post_content"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Publish" class="btn btn-success btn-lg pull-right">
                    </div>
                </form>
            </div>
        </div><!-- .post-inner -->
    </article><!-- .post-content -->
@endsection

@section('js')
    <script src="https://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        (function($) {
            $(document).ready(function() {

                $('.select2').select2({
                    width: null,
                    theme: 'bootstrap'
                });

                $(document).on('click', '#addCat', function (e) {
                    e.preventDefault();

                    var name = $('#new_cat').val();

                    $.ajax({
                        type:"POST",
                        url:"{{ route('user.cat.store') }}",
                        data: {name: name, _token: '{{ csrf_token() }}'},
                        success:function(data){
                            if (data.success && data.success == 2) {
                                toastr.warning('Category Already Exists. Just Select');
                            } else if (data.success && data.success == 1) {

                                var html = '<option value="' + data.id + '">' + data.text + '</option>';
                                $('#category').append(html).select2('destroy').val(null);

                                $('#category').select2({
                                    width: null,
                                    theme: 'bootstrap'
                                });

                                toastr.success('Category Added');

                            } else {
                                toastr.error('Unexpected Error. please try Again.');
                            }
                        }
                    });
                });

                $(document).on('change', '#post_image', function(e) {

                    if (this.files.length) {

                        var file = this.files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;

                            $('#image_container').attr('src', data);
                        };

                        reader.readAsDataURL(file);

                    }

                });

            });
        })(jQuery);
    </script>
@endsection
