@extends('layouts.user')

@section('content')
    <div class="clearfix"></div>
    
    <div class="create-new-post-wrapper">
        <div class="preloader" id="post-ajax-loader" style="display: none;">
            <div class="progress">
                <div id="prog" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('user.post.store') }}">
        @csrf
        <input type="hidden" name="urldataval" id="urldataval" value="">
        <input type="hidden" name="hrefurl" id="hrefurl" value="">
            <div class="profile-pic">
                <img src="{{ asset('assets/front/img/' . Auth::user()->avatar) }}" alt="">
            </div>
            <div class="content">
                <textarea class="post-input-field article-emoji-input textarea nice-scroll" placeholder="Your Cross Post" name="article"></textarea>

                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="urldatadiv" style="display:none;"></div>

                <div class="bottom-content">
                    <div class="left-content">
                        <ul>
                            <li>
                                <div class="single-input-wrapper">
                                    <label for="image"><i class="fa fa-image"></i></label>
                                    <input type="file" name="image" id="image">
                                </div>
                            </li>
                            <li>
                                <div class="single-input-wrapper">
                                    <label for="video"><i class="fa fa-youtube-play"></i></label>
                                    <input type="file" name="video" id="video">
                                </div>
                            </li>
                            <li>
                                <div class="single-input-wrapper">
                                    <label for="audio"><i class="fa fa-headphones"></i></label>
                                    <input type="file" name="audio" id="audio">
                                </div>
                            </li>
                            <li>
                                <div class="single-input-wrapper">
                                    <label for="youtube"><i class="fa fa-youtube"></i></label>
                                    <input type="text" name="youtube" id="youtube">
                                </div>
                            </li>
                            <li>
                                <div class="single-input-wrapper">
                                    <label for="vimeo"><i class="fa fa-vimeo"></i></label>
                                    <input type="text" name="vimeo" id="vimeo">
                                </div>
                            </li>
                            <li>
                                <div class="single-input-wrapper">
                                    <label for="doc"><i class="fa fa-file-pdf-o"></i></label>
                                    <input type="file" name="doc" id="doc">
                                    <input type="hidden" name="type" id="type">
                                    <input type="hidden" name="link" id="link">
                                </div>
                            </li>

                            <li>
                                <div><select name="poststatus_id" class="form-control">
                                    <option value="0">Public</option>
                                    <option value="1">Following</option>
                                    <option value="2">Mutual Followers</option>
                                    </select>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="right-content">
                        <button type="submit" class="btn btn-sm btn-block btn-success"><span class="posting-submit-icon"><i class="fa fa-paper-plane"></i></span><span class="posting-submit-btn">Share<span></button>
                    </div>
                </div>
                <div id="cont" class="instrant-upload-show">
                    <span class="cross"><i class="fa fa-times" aria-hidden="true"></i></span>
                    <div class="contai"></div>
                </div>
            </div>
        </form>
        <img id="loaderimg" src="{{ url('assets/front/img/loader.gif') }}">
    </div>

    <div class="post-loop-wrapper">
       @if($shares && count($shares))
            <div class="post-loop-inner infinite-scroll">
                @foreach($shares as $share)
                    @if($share->post)
                        @php
                            $post = $share->post;
                            $res=App\User::getfollowandmutual($post->poststatus_id);
                        @endphp
                        @if(! $share->user->isBlockedByMe(Auth::user()->id) && ! $post->user->isBlockedByMe(Auth::user()->id))

                        @if( empty($res) || ( count($res)>0 && in_array($post->user_id,$res) || $post->user_id==Auth::user()->id))
                            <div class="single-post-item">
                                @if($share->user_id != $post->user_id)
                                    <div class="share-div">
                                        <a href="{{ route('profile', optional($share->user)->username) }}">{{ optional($share->user)->name }} @if(optional($share->user)->verified == 1)<span class="varifed"><i class="fa fa-check-circle"></i></span>@endif</a> shared this {{ $post->type }}
                                    </div>
                                @endif
                                <div class="thumb">
                                    <img src="{{ asset('assets/front/img/' . optional($post->user)->avatar) }}" alt="{{ optional($post->user)->name }}">
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="{{ route('profile', optional($post->user)->username) }}">{{ optional($post->user)->name }} @if(optional($post->user)->verified == 1)<span class="varifed"><i class="fa fa-check-circle"></i></span>@endif</a>@if($post->group) &#8658;
                                        <a href="{{ route('user.groups', $post->group->slug) }}">{{ $post->group->name }}</a>@endif <span class="days"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</span></h4>
                                    <article>
                                        @if($post->type == 'article')
                                            @if($post->scrabingcontent!='')
                                                <p>{!! $post->scrabingcontent !!}</p>
                                            @else
                                                <p>{!! excerpt($post) !!}</p>
                                            @endif
                                            

                                        @elseif($post->type == 'image')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <img src="{{ asset('assets/front/content/' . $post->link) }}" class="img-responsive imgclickcls" data-toggle="modal" data-target="#imageModal">
                                        @elseif($post->type == 'video')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <video class="player" playsinline controls id="{{ str_random(20) }}" style="width: 100%;">
                                                <source src="{{ asset('assets/front/content/' . $post->link) }}" type="video/mp4">
                                            </video>
                                        @elseif($post->type == 'audio')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <audio class="player" controls id="{{ str_random(20) }}" style="width: 100%;">
                                                <source src="{{ asset('assets/front/content/' . $post->link) }}" type="audio/mp3">
                                            </audio>
                                        @elseif($post->type == 'youtube')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <div class="plyr__video-embed player">
                                                <iframe id="{{ str_random(20) }}" src="https://www.youtube.com/embed/{{ $post->link }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                            </div>
                                        @elseif($post->type == 'vimeo')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <div class="plyr__video-embed player">
                                                <iframe id="{{ str_random(20) }}" src="https://player.vimeo.com/video/{{ $post->link }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                            </div>
                                        @elseif($post->type == 'doc')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <div class="doc" style="border: 1px solid aliceblue;padding: 15px;"><div style="max-width: 75%;overflow: hidden;">{{ $post->link }}</div> <a href="{{ asset('assets/front/content/' . $post->link) }}" class="pull-right btn btn-default btn-xs" download style="color: #0c0c0c !important;">Download</a></div>
                                        @endif
                                        <ul class="post-action-ul">
                                            <li>
                                                <div class="single-post-action">

                                                    <i class="fa fa-thumbs-up post-action{{ $post->isLiked()?' actv':'' }} like" data-post="{{ $post->id }}"></i>
                                                    <a href="{{ route('view.like', $post->id) }}" class="post-action-count">{{ number_format_short($post->likeCount()) }}</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="single-post-action">

                                                    <span><a href="{{ route('user.post.single', $post->id) }}"><i class="fa fa-comments post-action comment"></i></a></span>
                                                    <a class="post-action-count">{{ number_format_short($post->commentCount()) }}</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="single-post-action">
                                                    <div class="btn-group share-group home-page-share-btn">
                                                        <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
                                                            <i class="fa fa-share"></i> <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a data-original-title="Timeline" rel="tooltip"  href="#" class="btn btn-timeline share" data-placement="left"  data-post="{{ $post->id }}">
                                                                    <i class="fa fa-share-alt"></i> {{ number_format_short($post->shareCount()) }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-original-title="Twitter" rel="tooltip"  href="{{ route('social.share', [$post->id, 'twitter']) }}" target="_blank" class="btn btn-twitter" data-placement="left">
                                                                    <i class="fa fa-twitter"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-original-title="Facebook" rel="tooltip"  href="{{ route('social.share', [$post->id, 'facebook']) }}" target="_blank" class="btn btn-facebook" data-placement="left">
                                                                    <i class="fa fa-facebook"></i>
                                                                </a>
                                                            </li>                   
                                                            <li>
                                                                <a data-original-title="Google+" rel="tooltip"  href="{{ route('social.share', [$post->id, 'google']) }}" target="_blank" class="btn btn-google" data-placement="left">
                                                                    <i class="fa fa-google-plus"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-original-title="LinkedIn" rel="tooltip"  href="{{ route('social.share', [$post->id, 'linkedin']) }}" target="_blank" class="btn btn-linkedin" data-placement="left">
                                                                    <i class="fa fa-linkedin"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-original-title="Pinterest" rel="tooltip" href="{{ route('social.share', [$post->id, 'pinterest']) }}" target="_blank" class="btn btn-pinterest" data-placement="left">
                                                                    <i class="fa fa-pinterest"></i>
                                                                </a>
                                                            </li>
                                                            {{--<li>
                                                                <a data-original-title="Email" rel="tooltip" class="btn btn-mail mail-share" data-placement="left" data-id="{{ $post->id }}">
                                                                    <i class="fa fa-envelope"></i>
                                                                </a>
                                                            </li>--}}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="single-post-action">
                                                    <span><a href="{{ route('user.post.report', $post->id) }}"><i class="fa fa-flag post-action report"></i></a></span>
                                                </div>
                                            </li>
                                            @if($post->user_id == Auth::user()->id || Auth::user()->id == 9)
                                                <li>
                                                    <div class="single-post-action">
                                                        <i class="fa fa-trash post-action delete-post" data-post="{{ $post->id }}"></i>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </article>
                                </div>
                            </div>
                            @endif
                        @endif
                    @endif
                @endforeach
                {{ $shares->links() }}
            </div>
        @else
            <div class="col-md-12 single text-center">No Post Found.</div>
        @endif
    </div>
@endsection

@section('js')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b028cce69cdbe02"></script>
    <script type="text/javascript">
        $(document).ready(function() {

        	const emoeditor = $(".article-emoji-input").emojioneArea({
                pickerPosition: "bottom",
                filtersPosition: "bottom",
            });

            /*change by dinesh start*/
            emoeditor[0].emojioneArea.on("paste", function(editor, event) {
                var value = this.getText();
                
                var urlpat = /^https?:\/\//i;
                    if (urlpat.test(value)){
                        $("#loaderimg").show();
                        $('#urldatadiv').css('display','none');
                        setTimeout(function() {
                            $.ajax({
                                type:"POST",
                                url:"{{ route('user.urllink.data') }}",
                                data: {'urllink': value,_token: '{{ csrf_token() }}'},
                                async:false,
                                success:function(data){
                                    var res = data.split("!~");
                                    $('#urldatadiv').css('display','block');
                                    $('#urldatadiv').html(res[0]);
                                    $('#urldataval').val(res[0]);
                                    $('#hrefurl').val(res[1]);
                                    $("#loaderimg").hide();
                                }
                            });
                        }, 100 );
                    }
            });

            emoeditor[0].emojioneArea.on("keyup", function(editor, event) {
                var value = this.getText();
                if(value==""){
                    $('#urldatadiv').css('display','none');
                    $('#urldatadiv').html('');
                    $('#urldataval').val('');
                    $('#hrefurl').val('');
                }
            });
            /*change by dinesh end*/

            $('[rel="tooltip"]').tooltip();

            const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));

            $(document).on('change', '#image', function(e) {

                if (this.files.length) {

                    var file = this.files[0];
                    upload(file, 'image');

                    /*Just Null All File value Except this*/

                    $('#video').val(null);
                    $('#audio').val(null);
                    $('#youtube').val(null);
                    $('#vimeo').val(null);
                    $('#doc').val(null);

                    /*Just Null All File value Except this*/

                }

            });

            $(document).on('change', '#video', function(e) {

                if (this.files.length) {

                    var file = this.files[0];

                    if (file.type === 'video/mp4') {

                        upload(file, 'video');

                        /*Just Null All File value Except this*/

                        $('#image').val(null);
                        $('#audio').val(null);
                        $('#youtube').val(null);
                        $('#vimeo').val(null);
                        $('#doc').val(null);

                        /*Just Null All File value Except this*/


                    } else {
                        toastr.warning('Only MP4 is supported');
                    }

                }

            });

            $(document).on('change', '#doc', function(e) {

                if (this.files.length) {

                    var file = this.files[0];

                    $('#type').val('doc');
                    upload(file, 'doc');

                    /*Just Null All File value Except this*/

                    $('#image').val(null);
                    $('#video').val(null);
                    $('#audio').val(null);
                    $('#youtube').val(null);
                    $('#vimeo').val(null);

                    /*Just Null All File value Except this*/

                }

            });

            $(document).on('change', '#audio', function(e) {

                if (this.files.length) {

                    var file = this.files[0];

                    if (file.type === 'audio/mpeg' || file.type == 'audio/mp3') {

                        upload(file, 'audio');

                        /*Just Null All File value Except this*/

                        $('#image').val(null);
                        $('#video').val(null);
                        $('#youtube').val(null);
                        $('#vimeo').val(null);
                        $('#doc').val(null);

                        /*Just Null All File value Except this*/


                    } else {
                        toastr.warning('Only MP3 is supported');
                    }

                }

            });


            $(document).on('click', 'label[for="youtube"]', function(e) {

                swal("Enter Youtube Video ID (Like 2X9eJF1nLiY)", {
                    content: "input",
                }).then((value) => {

                	if (value != '') {

	                    $('#youtube').val(value);
	                    $('#type').val('youtube');

	                    var html = '<div id="player" data-plyr-provider="youtube" data-plyr-embed-id="' + value + '"></div>\n';
	                    $('#cont div').html(html);
	                    const player = new Plyr('#player');

	                    $('#cont div').css('height', '300px');
	                    $('#cont').fadeIn();
	                    $('.emojionearea-editor').attr('placeholder', 'Caption');

	                        /*Just Null All File value Except this*/

	                        $('#image').val(null);
	                        $('#video').val(null);
	                        $('#audio').val(null);
	                        $('#vimeo').val(null);
	                        $('#doc').val(null);

	                        /*Just Null All File value Except this*/

                	}

                });

            });

            $(document).on('click', 'label[for="vimeo"]', function(e) {

                swal("Enter Vimeo Video ID (Like 114042185)", {
                    content: "input",
                }).then((value) => {

                	if (value != '') {

	                    $('#vimeo').val(value);
	                    $('#type').val('vimeo');

	                    var html = '<div id="player" data-plyr-provider="vimeo" data-plyr-embed-id="' + value + '"></div>\n';
	                    $('#cont div').html(html);
	                    const player = new Plyr('#player');

	                    $('#cont div').css('height', '300px').fadeIn();
	                    $('#cont').fadeIn();
	                    $('.emojionearea-editor').attr('placeholder', 'Caption');

	                        /*Just Null All File value Except this*/

	                        $('#image').val(null);
	                        $('#video').val(null);
	                        $('#audio').val(null);
	                        $('#youtube').val(null);
	                        $('#doc').val(null);

	                        /*Just Null All File value Except this*/

                	}


                });

            });

            $(document).on('click', '#cont span', function (e) {
                $('#cont').fadeOut();
                $('#cont div').html('');
                $('.emojionearea-editor').attr('placeholder', 'New Article');
                var link = $('#link').val();
                if (link != '') {
                    $.ajax({
                        type:"POST",
                        url:"{{ route('user.file.delete') }}",
                        data: {
                            link: link,
                            _token: '{{ csrf_token() }}'
                        }
                    });
                }
                $('#type').val('');
            });

            $(".article-emoji-input").emojioneArea({
                pickerPosition: "bottom",
                filtersPosition: "bottom",
            });
                 $(".nice-scroll").niceScroll({
                     cursorcolor:"#07cb79",
                     cursorwidth:"10px",
                     background:"rgba(26, 39, 53, 0.3)",
                     cursorborder:"1px solid aquamarine",
                     cursorborderradius:10
                 });
        });

        function upload(file, type) {

            var formdata = new FormData();
            formdata.append("_token", "{{ csrf_token() }}");
            formdata.append("type", type);
            formdata.append("file", file);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "{{ route('file.store') }}");
            ajax.send(formdata);

        }

        function progressHandler(event){
            var percent = (event.loaded / event.total) * 100;
            $("#post-ajax-loader").fadeIn();
            $("#prog").css('width', Math.round(percent)+'%');
            $("#prog").text(Math.round(percent)+'%');
        }
        function completeHandler(event){

            var jso = JSON.parse(event.target.responseText);

            if (jso.error) {

                $("#link").val(null);
                $('#type').val(null);
                $('input[type="file"]').val(null);

                $("#prog").css('width', '0%');
                $("#prog").text('0%');
                $("#prog").fadeOut();
                $('#post-ajax-loader').fadeOut();

                toastr.error(jso.error);
                $('.emojionearea-editor').attr('placeholder', 'New Article');

            } else {

                $("#prog").text("Upload Completed");
                $("#link").val(jso.link);
                $('#type').val(jso.type);
                $('.emojionearea-editor').attr('placeholder', 'Caption');
                $('input[type="file"]').val(null);
                toastr.success('Uploaded Successfully. Just Share This');

                if (jso.type == 'image') {

                    $('#cont').fadeIn();
                    $('#cont div').html('<img src="{{ url('assets/front/content/') }}/' + jso.link + '" class="img-responsive" style="width: 100%;height: 300px;margin-bottom: 20px;">');

                } else if (jso.type == 'video') {

                    $('#cont').fadeIn();
                    var html = '<video id="player" playsinline controls>\n' +
                        '    <source src="{{ url('assets/front/content/') }}/' + jso.link + '" type="video/mp4" id="player-src">\n' +
                        '</video>';

                    $('#cont div').html(html);

                    const player = new Plyr('#player');

                }  else if (jso.type == 'audio') {

                    $('#cont').fadeIn();
                    var html = '<audio id="player" controls><source src="{{ url('assets/front/content/') }}/'+ jso.link +'" type="audio/mp3" id="player-src"></audio>';

                    $('#cont div').html(html);

                    const player = new Plyr('#player');

                }

                setTimeout(function () {
                    $("#prog").css('width', '0%');
                    $("#prog").text('0%');
                    $("#prog").fadeOut();
                    $('#post-ajax-loader').fadeOut();
                }, 1500);

            }

        }
        function errorHandler(event){
            $("#link").val(null);
            $('#type').val(null);
            $('input[type="file"]').val(null);

            $("#prog").css('width', '0%');
            $("#prog").text('0%');
            $("#prog").fadeOut();
            $('#post-ajax-loader').fadeOut();

            toastr.error('Upload Failed. Please Try Again.');
            $('.emojionearea-editor').attr('placeholder', 'New Article');
        }
        function abortHandler(event){
            $("#link").val(null);
            $('#type').val(null);
            $('input[type="file"]').val(null);

            $("#prog").css('width', '0%');
            $("#prog").text('0%');
            $("#prog").fadeOut();
            $('#post-ajax-loader').fadeOut();

            toastr.error('Upload Aborted. Please Try Again.');
            $('.emojionearea-editor').attr('placeholder', 'New Article');
        }

    </script>
@endsection 