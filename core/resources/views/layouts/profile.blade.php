<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $user->name }} | {{ $gnl->title }}</title>
    <meta name="Title" Content="{{ $user->name }} | {{ $gnl->title }}">
    <meta name="robots" content="index,follow" /> 
    <meta name="Googlebot" content="index, follow, all" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/img/icon.png') }}" />
    <meta property="og:title" content="{{ $user->name }} | {{ $gnl->title }}"/>
    <meta property="og:site_name" content="{{ $gnl->title }}"/>
    <meta property="og:image" content="{{ asset('assets/front/img/' . $user->cover) }}"/>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @auth
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link rel="stylesheet" href="{{ asset('assets/front/twitter/emojionearea.min.css') }}">
    @endauth
    <link rel="stylesheet" href="https://cdn.plyr.io/3.2.4/plyr.css">
    <link rel="stylesheet" href="{{ asset('assets/front/twitter/style.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('assets/front/twitter/responsive.css') }}">
    <link href="{{ asset('assets/front/twitter/simplelightbox.min.css') }}" rel='stylesheet' type='text/css'>
</head>
<body class="profile-page-body">
@include('layouts.nav')

<div class="profile-cover-image">
    <div class="container custom-height profile-page-cover-container" style="background: url('{{ asset('assets/front/img/' . $user->cover) }}');">
    <div class="navbar navbar-default navbar-background-color" style="position: absolute;width: 100%;bottom: 0;left: 0;margin-bottom: unset;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                   <div class="profile-picture-wrapper">
                        <img src="{{ asset('assets/front/img/' . $user->avatar) }}" alt="{{ $user->name }}" class="profile-img-big">
                   </div>
                </div>
                <div class="col-md-9">
                    <ul class="profile-nav">
                        <li>
                            <div class="single-profile-nav-element">
                                <i class="fa fa-edit"></i> 
                                {{ number_format_short($user->postCount()) }}
                                <span class="visible-lg-inline visible-md-inline visible-sm-inline"> Posted</span>
                            </div>
                        </li>
                        <li>
                            <div class="single-profile-nav-element">
                                <i class="fa fa-eye"></i>
                                 {{ number_format_short($user->viewCount()) }}
                                 <span class="visible-lg-inline visible-md-inline visible-sm-inline"> Read</span>
                            </div>
                        </li>
                    </ul>
                    <ul class="profile-navbar"> 
                        @auth 
                            @if(Auth::user()->id != $user->id)
                            <li class="@if($user->isFollowedMe()) active @endif">
                                <a class="follow" style="cursor: pointer;" onclick="event.preventDefault();
              document.getElementById('follow-form').submit();">@if($user->isFollowedMe()) <i class="fa  fa-user-times"></i> <span class="visible-lg-inline visible-md-inline visible-sm-inline"> Unfollow</span> @endif @if(! $user->isFollowedMe()) <i class="fa fa-user-plus"></i> <span class="visible-lg-inline visible-md-inline visible-sm-inline"> Follow</span> @endif</a></li>
                            <form action="{{ route('user.follow', $user->username) }}" id="follow-form" method="post" style="display: none;">
                                @csrf
                            </form>
                            @if($user->isFriend())
                            <li><a href="{{ route('message', $user->username) }}"><i class="fa fa-comments"></i><span class="visible-lg-inline visible-md-inline visible-sm-inline"> Message</span></a></li>
                            @endif
                            <li class="@if(Auth::user()->isBlockedByMe($user->id)) active @endif">
                                <a class="block" style="cursor: pointer;" onclick="event.preventDefault();
          document.getElementById('block-form').submit();">@if(Auth::user()->isBlockedByMe($user->id)) <i class="fa fa-check-circle-o"></i> <span class="visible-lg-inline visible-md-inline visible-sm-inline"> Unblock</span> @endif @if(! Auth::user()->isBlockedByMe($user->id)) <i class="fa fa-ban"></i> <span class="visible-lg-inline visible-md-inline visible-sm-inline"> Block</span> @endif</a></li>
                            <form action="{{ route('user.block', $user->username) }}" id="block-form" method="post" style="display: none;">
                                @csrf
                            </form>
                            @endif
                        @endauth
                            <li>
                                <a href="{{ route('user.profile.photos', $user->username) }}">
                                    <i class="fa fa-picture-o" aria-hidden="true"></i><span class="visible-lg-inline visible-md-inline visible-sm-inline"> Photos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.profile.videos', $user->username) }}">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i><span class="visible-lg-inline visible-md-inline visible-sm-inline"> Videos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.profile.follower', $user->username) }}">
                                    <i class="fa fa-users"></i><span class="visible-lg-inline visible-md-inline visible-sm-inline"> Follower</span> ({{ number_format_short(count($user->followers())) }})
                                </a>
                            </li>
                        @auth
                            @if(Auth::user()->id == $user->id)
                            <li>
                                <a href="{{ route('user.profile.following') }}">
                                    <i class="fa fa-usb"></i><span class="visible-lg-inline visible-md-inline visible-sm-inline"> Following</span> ({{ number_format_short(count($user->following())) }})
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.profile.edit') }}">
                                    <i class="fa fa-edit"></i><span class="visible-lg-inline visible-md-inline visible-sm-inline"> Edit profile</span>
                                </a>
                            </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="container">
    <div class="row">
            <div class="col-md-3">
                @include('layouts.sidebar-left-public')
            </div><!-- .col-sm-4 -->
        <div class="col-md-6">
            @yield('content')
        </div>
            <div class="col-md-3">
                @auth
                    @include('layouts.sidebar-right')
                @endauth
            </div><!-- .col-sm-4 -->
    </div>
</div>

<!-- image modal start change by dinesh -->
<div class="modal fade" id="imageModal" role="dialog">
    <div id="imgmodalwidth" class="modal-dialog modal-lg" style="width:400px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" >
           <img id="imagesrc" class="showimage img-responsive" src="" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div> 
<!-- image modal end change by dinesh -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@auth
    <script src="{{ asset('assets/front/twitter/emojionearea.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.plyr.io/3.2.4/plyr.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/zenorocha/clipboard.js/v2.0.0/dist/clipboard.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/simple-lightbox.js') }}"></script>

    <script>
        (function ($) {
            $(document).ready(function () {

                const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));

                $(document).on('click', '.delete-post', function(e) {

                    e.preventDefault();

                    var post = $(this).data('post');
                    $(this).addClass('deletable');

                    swal({
                      title: "Are you sure? You Want To Delete This Post.",
                      text: "Once deleted, you will not be able to recover this post.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {

                            $.ajax({
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    post_id: post
                                },
                                url: '{{ route('user.post.delete') }}', 
                                type: 'POST',
                                success: function(response) {
                                    if (response.success && response.success == 1) {

                                        $('.deletable').parent().parent().parent().parent().parent().parent().slideUp().remove();

                                        swal("Poof! Post has been deleted!", {
                                          icon: "success",
                                        });

                                    } else {
                                        $('.deletable').removeClass('deletable');
                                    }
                                }
                            });
                      }
                    });

                });
                
                 $(document).on('click','#get_search-form',function(e){
                    e.preventDefault();
                    $('.search-area-mobile').css('display','block');
                    $(this).attr('id','get_search_clicked')
                }) 
                $(document).on('click','#get_search_clicked',function(e){
                    e.preventDefault();
                    $('.search-area-mobile').css('display','none');
                    $(this).attr('id','get_search-form')
                })


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

    <script>
        (function ($) {
            $(document).ready(function () {
                $(document).on('click','#get_search-form',function(e){
                    e.preventDefault();
                    $('.search-area-mobile').css('display','block');
                    $(this).attr('id','get_search_clicked')
                }) 
                $(document).on('click','#get_search_clicked',function(e){
                    e.preventDefault();
                    $('.search-area-mobile').css('display','none');
                    $(this).attr('id','get_search-form')
                })
                $(document).on('click','#mobile-right-nav-icon',function(){
                    $('.mobile-nav-header-right .sidebar-area').css('display','block');
                    $(this).attr('id','mobile-right-nav-icon-opened');
                });
                $(document).on('click','#mobile-right-nav-icon-opened',function(){
                    $('.mobile-nav-header-right .sidebar-area').css('display','none');
                    $(this).attr('id','mobile-right-nav-icon');
                });
                // $(document).on('click', '#copy', function (e) {
                //
                //     e.preventDefault();
                // });

                var clipboard = new ClipboardJS('#copy');

                clipboard.on('success', function(e) {
                    console.info('Action:', e.action);
                    console.info('Text:', e.text);
                    console.info('Trigger:', e.trigger);
                    toastr.success("Link Copied Successfully.");
                    e.clearSelection();
                });

                @if($errors->any())
                @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
                @endforeach
                @endif

                @if(session('success'))
                toastr.success("{{ session('success') }}");
                @endif

                @if(session('alert'))
                toastr.warning("{{ session('alert') }}");
                @endif
            });
            $('[data-toggle="tooltip"]').tooltip();

            /*image in popup change by dinesh start*/
                $(document).on('click','.imgclickcls',function(){
                    var image = $(this).attr('src');
                    var theImage = new Image();
                      $(theImage).load(function() {
                        if(this.width>=1000){
                            $('#imgmodalwidth').css('width','1050');                    
                        }
                        else{
                            $('#imgmodalwidth').css('width',this.width+50);
                        }
                      });
                      theImage.src = image;
                   $("#imagesrc").attr("src", image);
                });
            /*image in popup change by dinesh end*/
            
        })(jQuery);
    </script>
    @yield('js')
@endauth
@include('layouts.aut')
</body>
</html>