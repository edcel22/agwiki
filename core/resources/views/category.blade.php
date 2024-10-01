@extends('layouts.user')

@section('content')

    @if($posts && count($posts))
        <div class="infinite-scroll">
        @foreach($posts as $post)
                    <article class="post-content section-box">
                        <div class="post-inner">
                            <header class="post-header">
                                <div class="post-data">
                                    <div class="post-title-wrap">
                                        <h1 class="post-title">{{ $post->title }}</h1>
                                        <time class="post-datetime" datetime="{{ $post->created_at }}">
                                            <span class="day">{{ $post->created_at->format('d') }}</span>
                                            <span class="month">{{ $post->created_at->format('M') }}</span>
                                        </time>
                                    </div>

                                    <div class="post-info">
                                        <a href="{{ route('profile', optional($post->user)->username) }}"><i class="rsicon rsicon-user"></i>by {{ optional($post->user)->name }}</a>
                                        <a href="{{ route('view.like', [str_slug($post->title), $post->id]) }}"><i class="rsicon rsicon-thumbs-up"></i>{{ number_format_short($post->likeCount()) }}</a>
                                        <a href="{{ route('user.post.single', [str_slug($post->title), $post->id]) }}"><i class="rsicon rsicon-comments"></i>{{ number_format_short($post->commentCount()) }}</a>
                                        <a href="{{ route('view.share', [str_slug($post->title), $post->id]) }}"><i class="rsicon rsicon-share-alt"></i>{{ number_format_short($post->shareCount()) }}</a>
                                    </div>
                                </div>
                            </header>
                            <img src="{{ asset('assets/front/img/post/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100%;height: 300px;margin-bottom: 20px;">
                            <div class="post-editor clearfix">
                                {!! excerpt($post) !!}
                            </div>

                            <div class="post-info row" style="margin-top: 30px;">
                                <div class="col-xs-3">
                                    <i style="font-size: 30px;" class="rsicon rsicon-thumbs-up post-action{{ $post->isLiked()?' actv':'' }} like" data-post="{{ $post->id }}"></i>
                                </div>
                                <div class="col-xs-2">
                                    <a href="{{ route('user.post.single', [str_slug($post->title), $post->id]) }}"><i style="font-size: 30px;" class="rsicon rsicon-comments post-action comment"></i></a>
                                </div>
                                <div class="col-xs-2">
                                    <i style="font-size: 30px;" class="rsicon rsicon-share-alt post-action share" data-post="{{ $post->id }}"></i>
                                </div>
                                <div class="col-xs-3">
                                    <a href="{{ route('user.post.report', $post->id) }}"><i style="font-size: 30px;" class="rsicon rsicon-flag post-action report"></i></a>
                                </div>
                                @if($post->user_id == Auth::user()->id)
                                    <div class="col-xs-2">
                                        <a href="{{ route('user.post.edit', [$post->title, $post->id]) }}"><i style="font-size: 30px;" class="rsicon rsicon-edit post-action"></i></a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
        @endforeach
            {{ $posts->links() }}
        </div>
    @else
        <div class="section-box" style="text-align: center;">No Post Found. <a href="{{ route('user.post.new') }}">Add New Post</a></div>
    @endif

@endsection

@section('js')
    <script src="{{ asset('assets/front/js/jquery.jscroll.min.js') }}"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="section-box" style="text-align: center;">Loading...</div>',
                padding: 0,
                nextSelector: 'ul.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>

    <script>
        (function ($) {
            $(document).ready(function () {
               $(document).on('click', '.like', function (e) {
                  e.preventDefault();

                  var post = $(this).data('post');

                  $(this).addClass('actv');

                   $.ajax({
                       type:"POST",
                       url:"{{ route('user.like') }}",
                       data: {post_id: post, _token: '{{ csrf_token() }}'},
                       success:function(data){
                           if (data.success && data.success == 1) {
                               if (data.message) {
                                    toastr.success(data.message);
                               }
                           }
                       }
                   });

               });

                $(document).on('click', '.share', function (e) {
                    e.preventDefault();

                    var post = $(this).data('post');

                    $.ajax({
                        type:"POST",
                        url:"{{ route('user.share') }}",
                        data: {post_id: post, _token: '{{ csrf_token() }}'},
                        success:function(data){
                            if (data.success && data.success == 1) {
                                toastr.success("Successfully Shared On Your Profile");
                            } else {
                                toastr.error("Unexpected Error! Please try Again.");
                            }
                        }
                    });

                });
            });
        })(jQuery);
    </script>
@endsection