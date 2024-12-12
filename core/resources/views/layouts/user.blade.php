<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <title>{{ $page_title }} | {{ $gnl->title }}</title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
    <meta name="robots" content="index,follow" /> 
    <meta name="Googlebot" content="index, follow, all" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/img/icon.png') }}" />
    
    @yield('meta')
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
    @yield('css')
</head>
<body style="background: #F6ECD8 !important; min-height:674px; margin-top:0">
				<div class="container" style="padding:0 100px 100px 100px;" >

					<a href="/"><img style="width:100%;max-width:300px;" src="/assets/front/img/logo_md.png" alt="AgWiki, Solving World Food Problems Socially"></a>

				</div>

                  <div class="container" id="app">
                      
                          <div class="col-md-6">
                              <div class="mobile-padding-area"></div>
                              @yield('content')
                          </div>
            
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

    <script>
	
	
	
        (function($) {

            $(document).ready(function() {
                
                const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));


                $(document).on('click', '.mail-share', function(e) {
                    e.preventDefault();

                    var post_id = $(this).data('id');
                    console.log(post_id);

                });

            });

        })(jQuery);
    </script>

    <script src="{{ asset('assets/front/js/jquery.jscroll.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="section-box infinite-loading"><i class="fa fa-refresh fa-spin fa-3x" aria-hidden="true"></i></div>',
                padding: 0,
                nextSelector: 'ul.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                    const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>

    <script>
        (function ($) {
            $(document).ready(function () { 

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

                $(document).on('click','#mobile-right-nav-icon',function(){
                    $('.mobile-nav-header-right .sidebar-area').css('display','block');
                    $(this).attr('id','mobile-right-nav-icon-opened');
                });
                $(document).on('click','#mobile-right-nav-icon-opened',function(){
                    $('.mobile-nav-header-right .sidebar-area').css('display','none');
                    $(this).attr('id','mobile-right-nav-icon');
                });
                $('[data-toggle="tooltip"]').tooltip();

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
                // var clipboard = new ClipboardJS('#copy');

                // clipboard.on('success', function(e) {
                //     console.info('Action:', e.action);
                //     console.info('Text:', e.text);
                //     console.info('Trigger:', e.trigger);
                //     toastr.success("Link Copied Successfully.");
                //     e.clearSelection();
                // });

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