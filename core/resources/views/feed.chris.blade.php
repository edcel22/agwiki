@extends('layouts.auth') @section('content')

<div class="page-content ">

    <div>

        <div class="posts">

            <div>

                <form method="post" action="{{ route('user.post.store') }}">

                    <div class="post-meta">

                        <a href="#" data-menu="menu-add-topic" alt="Add Topics" class="add-topics">Add Topics</a> @if(isset($_GET['topic'])) @php $oneinterest=App\Interest::getTopic($_GET['topic']); @endphp

                        <a class="topic active  " href="/feed"><i class="fas fa-minus-circle"></i> {{$oneinterest[0]->name}}</a> @endif

                        </span>

                        <div class="col-md-12" style="visibility:hidden; height:1px; overflow:hidden">

                            <label>Interests - this is just temporary </label>

                            <div class="form-group form-check crossposting-input input-style-1">

                                @foreach($interest as $int)

                                <div class="col-md-6">

                                    <label style="width:50%; float:left" for="interest{{$int->id}}">{{$int->name}}</label>

                                    <input style="width:50%; float:left" type="checkbox" class="form-control input-style-1" name="interest[]" id="interest{{$int->id}}" value="{{$int->id}}">

                                </div>

                                @endforeach

                            </div>

                        </div>

                        <!--<span>With: <a href="#"> <i class="fas fa-user-plus">

</i> </a>

</span>-->

                    </div>

                    <div class="preloader" id="post-ajax-loader" style="display: none;">

                        <div class="progress">

                            <div id="prog" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">

                            </div>

                        </div>

                    </div>

                    <div class="post-input">

                        <div class="input-style">

                            @csrf

                            <input type="hidden" name="urldataval" id="urldataval" value="">

                            <input type="hidden" name="hrefurl" id="hrefurl" value="">

                            <textarea class="post-input-field article-emoji-input textarea nice-scroll" placeholder="Paste a URL, video link, or enter your post..." name="article"></textarea>

                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="urldatadiv" style="display:none;"></div>

                        </div>

                        <div class="post-addons">

                            <ul>

                                <li>

                                    <div class="single-input-wrapper">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" style="display:none">
                                    </div>

                                </li>

                                <li>

                                    <div class="single-input-wrapper hidden-mobile">
                                        <label for="doc">Document</label>
                                        <input type="file" name="doc" id="doc" style="display:none">
                                    </div>

                                </li>

                                <li>

                                    <div class="single-input-wrapper">
                                        <a href="#" alt="Select a Group">Add to Group</a>
                                    </div>

                                </li>

                                <!-- <li>

                                    <div>

                                        <select name="poststatus_id" class="form-control">

                                            <option value="0">Public</option>

                                            <option value="1">Friends</option>

                                        </select>

                                    </div>

                                </li> -->

                                <li>

                                    <div>

                                        <button style="background-color:#A0D468; padding:5px 10px; margin-left: 10px; " type="submit" class="button">
                                            <span class="posting-submit-icon"><i class="fa fa-paper-plane"></i></span>
                                            <span class="posting-submit-btn"> Share<span>
										</button>

									</div>

								</li>

							</ul>

						</div>

						<div id="cont" style="display:none" class="instrant-upload-show">

							<span class="cross">

<i class="fa fa-times" aria-hidden="true">

</i>

</span>

                                            <div class="contai">

                                            </div>

                                    </div>

                                    <!-- image modal start change by dinesh -->

                                    <div class="modal fade" id="imageModal" role="dialog" style="display:none">

                                        <div id="imgmodalwidth" class="modal-dialog modal-lg" style="width:400px">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                                </div>

                                                <div class="modal-body">

                                                    <img id="imagesrc" class="showimage img-responsive" src="" />

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <!-- image modal end change by dinesh -->

                </form>

                <img style="display:none;width:50px;" id="loaderimg" src="{{ url('assets/front/img/loader.gif') }}">

                </div>

                </div>

            </div>

            <div class="divider divider-margins">

            </div>

            <div class="post-loop-wrapper">

                @if($shares && count($shares))

                <div class="post-loop-inner infinite-scroll">

                    @foreach($shares as $share) @if($share->post) @php $post = $share->post; $res=App\User::getfollowandmutual($post->poststatus_id); @endphp @php $postTopics=App\Post::postTopics($post->id); @endphp @if($post->type=='feed')

                    <div class="post">

                        <div>

                            <div class="post-meta">

                                @if($postTopics[0]->interests->count() > 0)

                                <span>Topics:

							@foreach($postTopics as $theinterest)

							@foreach($theinterest->interests as $myinterest)

							<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>,

							@endforeach

							@endforeach

							</span> @endif

                            </div>

                            <article>

                                <p class="pubDate">{{ \Carbon\Carbon::parse($post->pubDate)->format('m/d/Y')}}</p>

                                <p>
                                    <!--<span class="url">{{ $post->link }}</span>-->{!! $post->content !!} <a target="_blank" href="{{ $post->link }}" class="pull-right readmore">Read More</a>

                                </p>

                            </article>

                        </div>

                        <div class="post-addons likes">

                            <ul>

                                <li>

                                    <div class="single-input-wrapper">

                                        <i onClick="$(this).addClass('active');" class="fas fa-thumbs-up post-action like {{ $post->isLiked()?' active':'' }}" data-post="{{$post->id}}"></i><span>({{App\Like::countLIke($post->id)}})</span>

                                    </div>

                                </li>

                                <li>

                                    <div class="single-input-wrapper">

                                        <i class="fas fa-share-square share {{ $post->isShared()?' active':'' }}" data-post="{{$post->id}}"></i><span> Share({{ number_format_short($post->shareCount()-1) }})</span>

                                    </div>

                                </li>

                                <li>

                                    <div class="single-input-wrapper">

                                        <i onClick="$(this).addClass('active');" class="fas fa-star post-action favorite {{ $post->isFavorited()?' active':'' }}" data-post="{{$post->id}}">

</i>

                                    </div>

                                </li>

                                <li>

                                    <a href="/post/{{$post->id}}">Comments ({{ number_format_short($post->commentCount()) }})</a>

                                </li>

                            </ul>

                            <ul class="socialShare">

                                <li>

                                    <a data-original-title="Twitter" href="{{ route('social.share', [$post->id, 'twitter']) }}" target="_blank" class="btn btn-twitter" data-placement="left">

                                        <i class="fab fa-twitter"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="Facebook" href="{{ route('social.share', [$post->id, 'facebook']) }}" target="_blank" class="btn btn-facebook" data-placement="left">

                                        <i class="fab fa-facebook"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="Google+" href="{{ route('social.share', [$post->id, 'google']) }}" target="_blank" class="btn btn-google" data-placement="left">

                                        <i class="fab fa-google-plus"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="LinkedIn" href="{{ route('social.share', [$post->id, 'linkedin']) }}" target="_blank" class="btn btn-linkedin" data-placement="left">

                                        <i class="fab fa-linkedin"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="Pinterest" href="{{ route('social.share', [$post->id, 'pinterest']) }}" target="_blank" class="btn btn-pinterest" data-placement="left">

                                        <i class="fab fa-pinterest"></i>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                    @else

                    <!--other posts-->

                    @if(! $share->user->isBlockedByMe(Auth::user()->id) && ! $post->user->isBlockedByMe(Auth::user()->id)) @if( empty($res) || ( count($res)>0 && in_array($post->user_id,$res) || $post->user_id==Auth::user()->id)) @php $postTopics=App\Post::postTopics($post->id); @endphp

                    <div class="post post-meta">

                        @if($post->user_id == Auth::user()->id || Auth::user()->id == 9)

                        <ul class="postedit">

                            <li>

                                <a href="/posts/edit/{{$post->id}}"><i class="fa fa-edit" ></i></a>

                            </li>

                            <li>

                                <a href="#" class="delete-post" data-post="{{$post->id}}"><i class="fa fa-trash" ></i></a>

                            </li>

                        </ul>

                        @endif

                        <div>

                            <img src="{{ asset('assets/front/img/' . optional($share->user)->avatar) }}" class="profile-image" alt="{{ optional($share->user)->name }}">

                            <a href="{{ route('profile', optional($share->user)->username) }}" class="user">{{ optional($share->user)->name }} @if(optional($share->user)->verified == 1)<span class="varifed">

<i class="fa fa-check-circle">

</i>

</span>@endif</a>

                            <Br>

                            <date>shared this {{ $post->type }} {{ $post->created_at->diffForHumans() }}</date>

                            <br> @if($postTopics[0]->interests->count() > 0)

                            <span>Topics: 

						@foreach($postTopics as $theinterest)

						@foreach($theinterest->interests as $myinterest)

						<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>,

						@endforeach

						@endforeach

						</span>

                            <!--<span>With: <a href="#">User Name</a>, <a href="#">Tagged User</a>, <a href="#"> <i class="fas fa-user-plus">

</i> </a>

</span>-->

                            @endif

                            <article>

                                <br> @if($post->type == 'article') @if($post->scrabingcontent!='')

                                <p class="scrabingcontent">{!! $post->scrabingcontent !!}</p>

                                @else

                                <p>{!! excerpt($post) !!}</p>

                                @endif @elseif($post->type == 'image')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <img src="{{ asset('assets/front/content/' . $post->link) }}" class="img-responsive imgclickcls preload-image responsive-image" data-toggle="modal" data-target="#imageModal"> @elseif($post->type == 'video')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <video class="player" playsinline controls id="{{ str_random(20) }}" style="width: 100%;">

                                    <source src="{{ asset('assets/front/content/' . $post->link) }}" type="video/mp4">

                                </video>

                                @elseif($post->type == 'audio')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <audio class="player" controls id="{{ str_random(20) }}" style="width: 100%;">

                                    <source src="{{ asset('assets/front/content/' . $post->link) }}" type="audio/mp3">

                                </audio>

                                @elseif($post->type == 'youtube')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <div class="plyr__video-embed player">

                                    <iframe id="{{ str_random(20) }}" src="https://www.youtube.com/embed/{{ $post->link }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay">

                                    </iframe>

                                </div>

                                @elseif($post->type == 'vimeo')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <div class="plyr__video-embed player">

                                    <iframe id="{{ str_random(20) }}" src="https://player.vimeo.com/video/{{ $post->link }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay">

                                    </iframe>

                                </div>

                                @elseif($post->type == 'doc')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <div class="doc" style="border: 1px solid aliceblue;padding: 15px;">

                                    <div style="max-width: 75%;overflow: hidden;">{{ $post->link }}</div>

                                    <a target="_blank" href="{{ asset('assets/front/content/' . $post->link) }}" class="pull-right btn btn-default btn-xs" download style="color: #0c0c0c !important;">Download</a>

                                </div>

                                @elseif($post->type == 'feed')

                                <p>{!! excerpt($post) !!}</p>

                                <br>

                                <a target="_blank" href="{{ $post->link }}" class="pull-right btn btn-default btn-xs readmore" download style="color: #0c0c0c !important;">Read More</a> @endif

                            </article>

                        </div>

                        <div class="post-addons likes">

                            <ul>

                                <li>

                                    <div class="single-input-wrapper">

                                        <i onClick="$(this).addClass('active');" class="fas fa-thumbs-up post-action like {{ $post->isLiked()?' active':'' }}" data-post="{{$post->id}}"></i><span>({{App\Like::countLIke($post->id)}})</span>

                                    </div>

                                </li>

                                <li>

                                    <div class="single-input-wrapper">

                                        <i class="fas fa-share-square share {{ $post->isShared()?' active':'' }}" data-post="{{$post->id}}"></i><span> Share({{ number_format_short($post->shareCount()-1) }})</span>

                                    </div>

                                </li>

                                <li>

                                    <div class="single-input-wrapper">

                                        <i onClick="$(this).addClass('active');" class="fas fa-star post-action favorite {{ $post->isFavorited()?' active':'' }}" data-post="{{$post->id}}">

</i>

                                    </div>

                                </li>

                                <li>

                                    <a href="/post/{{$post->id}}">Comments ({{ number_format_short($post->commentCount()) }})</a>

                                </li>

                            </ul>

                            <ul class="socialShare">

                                <li>

                                    <a data-original-title="Twitter" href="{{ route('social.share', [$post->id, 'twitter']) }}" target="_blank" class="btn btn-twitter" data-placement="left">

                                        <i class="fab fa-twitter"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="Facebook" href="{{ route('social.share', [$post->id, 'facebook']) }}" target="_blank" class="btn btn-facebook" data-placement="left">

                                        <i class="fab fa-facebook"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="Google+" href="{{ route('social.share', [$post->id, 'google']) }}" target="_blank" class="btn btn-google" data-placement="left">

                                        <i class="fab fa-google-plus"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="LinkedIn" href="{{ route('social.share', [$post->id, 'linkedin']) }}" target="_blank" class="btn btn-linkedin" data-placement="left">

                                        <i class="fab fa-linkedin"></i>

                                    </a>

                                </li>

                                <li>

                                    <a data-original-title="Pinterest" href="{{ route('social.share', [$post->id, 'pinterest']) }}" target="_blank" class="btn btn-pinterest" data-placement="left">

                                        <i class="fab fa-pinterest"></i>

                                    </a>

                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="divider divider-margins">

                    </div>

                    @endif @endif @endif @endif @endforeach

                    <div style="display:none">{{ $shares->links() }}</div>

                    @else

                    <div class="col-md-12 single text-center">No Post Found.</div>

                    @endif

                </div>

            </div>

        </div>

        <div id="menu-share" class="menu menu-box-bottom" data-menu-height="310" data-menu-effect="menu-parallax">

            <div class="link-list link-list-1 content bottom-0">

                <a href="#" class="shareToFacebook">

                    <i class="font-18 fab fa-facebook color-facebook">

</i>

                    <span class="font-13">Facebook</span>

                    <i class="fa fa-angle-right">

</i>

                </a>

                <a href="#" class="shareToTwitter">

                    <i class="font-18 fab fa-twitter-square color-twitter">

</i>

                    <span class="font-13">Twitter</span>

                    <i class="fa fa-angle-right">

</i>

                </a>

                <a href="#" class="shareToLinkedIn">

                    <i class="font-18 fab fa-linkedin color-linkedin">

</i>

                    <span class="font-13">LinkedIn</span>

                    <i class="fa fa-angle-right">

</i>

                </a>

                <a href="#" class="shareToGooglePlus">

                    <i class="font-18 fab fa-google-plus-square color-google">

</i>

                    <span class="font-13">Google +</span>

                    <i class="fa fa-angle-right">

</i>

                </a>

                <a href="#" class="shareToWhatsApp">

                    <i class="font-18 fab fa-whatsapp-square color-whatsapp">

</i>

                    <span class="font-13">WhatsApp</span>

                    <i class="fa fa-angle-right">

</i>

                </a>

                <a href="#" class="shareToMail no-border">

                    <i class="font-18 fa fa-envelope-square color-mail">

</i>

                    <span class="font-13">Email</span>

                    <i class="fa fa-angle-right">

</i>

                </a>

            </div>

        </div>

        <div id="menu-2" class="menu menu-box-right" data-menu-width="75" data-menu-effect="menu-over">

            <div class="highlight-changer">

                <a href="#" data-change-highlight="red1">

                    <i class="fa fa-circle color-red1-dark">

</i>

                    <span class="color-red2-light">Red</span>

                </a>

                <a href="#" data-change-highlight="orange">

                    <i class="fa fa-circle color-orange-dark">

</i>

                    <span class="color-orange-light">Orange</span>

                </a>

                <a href="#" data-change-highlight="pink2">

                    <i class="fa fa-circle color-pink2-dark">

</i>

                    <span class="color-pink2-light">Pink</span>

                </a>

                <a href="#" data-change-highlight="magenta2">

                    <i class="fa fa-circle color-magenta2-dark">

</i>

                    <span class="color-magenta2-light">Purple</span>

                </a>

                <a href="#" data-change-highlight="blue2">

                    <i class="fa fa-circle color-blue2-dark">

</i>

                    <span class="color-blue2-light">Blue</span>

                </a>

                <a href="#" data-change-highlight="aqua">

                    <i class="fa fa-circle color-aqua-dark">

</i>

                    <span class="color-aqua-light">Aqua</span>

                </a>

                <a href="#" data-change-highlight="teal">

                    <i class="fa fa-circle color-teal-dark">

</i>

                    <span class="color-teal-light">Teal</span>

                </a>

                <a href="#" data-change-highlight="mint">

                    <i class="fa fa-circle color-mint-dark">

</i>

                    <span class="color-mint-light">Mint</span>

                </a>

                <a href="#" data-change-highlight="green2">

                    <i class="fa fa-circle color-green2-dark">

</i>

                    <span class="color-green2-light">Green</span>

                </a>

                <a href="#" data-change-highlight="green1">

                    <i class="fa fa-circle color-green1-dark">

</i>

                    <span class="color-green1-light">Grass</span>

                </a>

                <a href="#" data-change-highlight="yellow2">

                    <i class="fa fa-circle color-yellow2-dark">

</i>

                    <span class="color-yellow2-light">Sunny</span>

                </a>

                <a href="#" data-change-highlight="yellow1">

                    <i class="fa fa-circle color-yellow1-dark">

</i>

                    <span class="color-yellow1-light">Goldish</span>

                </a>

                <a href="#" data-change-highlight="brown1">

                    <i class="fa fa-circle color-brown1-dark">

</i>

                    <span class="color-brown1-light">Wood</span>

                </a>

                <a href="#" data-change-highlight="brown2">

                    <i class="fa fa-circle color-brown2-dark">

</i>

                    <span class="color-brown2-light">Earth</span>

                </a>

                <a href="#" data-change-highlight="dark1">

                    <i class="fa fa-circle color-dark1-dark">

</i>

                    <span class="color-dark1-light">Night</span>

                </a>

                <a href="#" data-change-highlight="dark2">

                    <i class="fa fa-circle color-dark2-dark">

</i>

                    <span class="color-dark2-light">Dark</span>

                </a>

                <a href="#" data-change-highlight="gray2">

                    <i class="fa fa-circle color-gray2-dark">

</i>

                    <span class="color-gray2-light">Gray</span>

                </a>

            </div>

        </div>

    </div>

    <div id="menu-forgot" class="menu menu-box-bottom" data-menu-height="230" data-menu-effect="menu-over">

        <div class="content">

            <h2 class="uppercase ultrabold top-20">Forgot Password?</h2>

            <p class="font-11 under-heading bottom-20">

                Let's get you back into your account. Enter your email to reset.

            </p>

            <div class="input-style has-icon input-style-1 input-required bottom-30">

                <i class="input-icon fa fa-at">

</i>

                <span>Email</span>

                <em>(required)</em>

                <input type="email" placeholder="Email">

            </div>

            <a href="#" class="button button-full button-m shadow-large button-round-small bg-blue1-dark top-20">SEND RECOVERY EMAIL</a>

        </div>

    </div>

    <div id="menu-signin" class="menu menu-box-bottom" data-menu-height="500" data-menu-effect="menu-over">
        <div class="content">
            <h1 class="uppercase ultrabold top-20">LOGIN</h1>
            <p class="font-11 under-heading bottom-20">
                Hello, stranger! Please enter your credentials below.
            </p>
    
            <!-- Email Input -->
            <div class="input-style has-icon input-style-1 input-required">
                <i class="input-icon fa fa-at"></i>
                <span>Email</span>
                <em>(required)</em>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
    
            <!-- Password Input -->
            <div class="input-style has-icon input-style-1 input-required">
                <i class="input-icon fa fa-lock font-11"></i>
                <span>Password</span>
                <em>(required)</em>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
    
            <!-- Show Password Checkbox -->
            <div class="top-10">
                <input type="checkbox" id="showPasswordCheckbox" onclick="showPassword()"> Show Password
            </div>
    
            <div class="top-30">
                <div class="one-half">
                    <a href="#" data-menu="menu-forgot" class="left-text font-10">Forgot Password?</a>
                </div>
                <div class="one-half last-column">
                    <a data-menu="menu-signup" href="#" class="right-text font-10">Create Account</a>
                </div>
            </div>
            <div class="clear"></div>
    
            <!-- Login Button (Uncomment if needed) -->
            <!-- <a href="dashboard.html" class="button button-full button-s shadow-large button-round-small bg-green1-dark top-10">LOGIN</a> -->
    
            <div class="divider"></div>
    
            <!-- Social Login Buttons -->
            <a href="#" class="button bg-linkedin button-l shadow-large button-icon-left">
                <i class="fab fa-linkedin-in"></i> Log In With LinkedIn
            </a>
            <br>
            <a href="#" class="button bg-facebook button-l shadow-large button-icon-left">
                <i class="fab fa-facebook-f"></i> Log In With Facebook
            </a>
            <br>
        </div>
    </div>

    <div id="menu-signup" class="menu menu-box-bottom" data-menu-height="300" data-menu-effect="menu-parallax">

        <div class="content">

            <h1 class="uppercase ultrabold top-20">Register</h1>

            <p class="font-11 under-heading bottom-20">

                Don't have an account? Register below.

            </p>

            <div class="input-style has-icon input-style-1 input-required">

                <i class="input-icon fa fa-at">
</i>

                <span>Email</span>

                <em>(required)</em>

                <input type="email" placeholder="Email">

            </div>

            <div class="top-20 bottom-20">

                <a href="#" data-menu="menu-signin" class="center-text font-11 color-gray2-dark">Already Registered? Sign In Here.</a>

            </div>

            <div class="clear">

            </div>

            <a href="#" class="button button-full button-s shadow-large button-round-small bg-blue2-dark top-10">Register</a>

        </div>

    </div>

    @endsection @section('js')

    <script src="https://cdn.plyr.io/3.2.4/plyr.js">
    </script>

    <script type="text/javascript" src="https://cdn.rawgit.com/zenorocha/clipboard.js/v2.0.0/dist/clipboard.min.js">
    </script>

    <script src="/assets/front/twitter/emojionearea.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/smoothState.js/0.7.2/jquery.smoothState.min.js">
    </script>

    <script>
        (function($) {

            $(document).ready(function() {

                const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));

                $(document).on('click', '.mail-share', function(e) {

                    e.preventDefault();

                    var post_id = $(this).data('id');

                    console.log(post_id)

                })

            })

        })(jQuery);
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js">
    </script>

    <script>
        function showPassword() {
            var passwordField = document.getElementById("password");
            var checkbox = document.getElementById("showPasswordCheckbox");
            
            // Toggle password visibility
            if (checkbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

    <script>
        (function($) {

            $(document).ready(function() {

                @if(isset($_GET['topic']))

                $('.page-link').each(function() {

                    var href = $(this).attr('href');

                    console.log(href);

                    if (href) {

                        href += (href.match(/\?/) ? '&' : '?') + 'topic={{$_GET["topic"]}}';

                        $(this).attr('href', href);

                        console.log(href);

                    }

                });

                @endif

                $(document).on('click', '.delete-post', function(e) {

                    e.preventDefault();

                    console.log('in delete');

                    var post = $(this).data('post');

                    $(this).addClass('deletable');

                    swal({

                        title: "Are you sure? You Want To Delete This Post.",

                        text: "Once deleted, you will not be able to recover this post.",

                        icon: "warning",

                        buttons: !0,

                        dangerMode: !0,

                    }).then((willDelete) => {

                        if (willDelete) {

                            $.ajax({

                                data: {

                                    _token: '{{ csrf_token() }}',

                                    post_id: post

                                },

                                url: "{{ route('user.post.delete') }}",

                                type: 'POST',

                                success: function(response) {

                                    if (response.success && response.success == 1) {

                                        $('.deletable').parent().parent().parent().slideUp().remove();

                                        swal("Poof! Post has been deleted!", {

                                            icon: "success",

                                        })

                                    } else {

                                        $('.deletable').removeClass('deletable')

                                    }

                                }

                            })

                        }

                    })

                });

                $(document).on('click', '#mobile-right-nav-icon', function() {

                    $('.mobile-nav-header-right .sidebar-area').css('display', 'block');

                    $(this).attr('id', 'mobile-right-nav-icon-opened')

                });

                $(document).on('click', '#mobile-right-nav-icon-opened', function() {

                    $('.mobile-nav-header-right .sidebar-area').css('display', 'none');

                    $(this).attr('id', 'mobile-right-nav-icon')

                });

                $('[data-toggle="tooltip"]').tooltip();

                $(document).on('click', '.like', function(e) {

                    e.preventDefault();

                    var post = $(this).data('post');

                    $(this).addClass('actv');

                    var myString = $(this).parent().find('span').prop('innerHTML');

                    var result = myString.match(/\((.*)\)/);

                    var currentValue = result[1];

                    var newValue = parseInt(currentValue.trim()) + 1;

                    $(this).parent().find('span').prop('innerHTML', '(' + newValue + ')');

                    $.ajax({

                        type: "POST",

                        url: "{{ route('user.like') }}",

                        data: {

                            post_id: post,

                            _token: '{{ csrf_token() }}'

                        },

                        success: function(data) {

                            if (data.success && data.success == 1) {

                                if (data.message) {

                                    toastr.success(data.message)

                                }

                            }

                        }

                    })

                });

                $(document).on('click', '.share', function(e) {

                    e.preventDefault();

                    var post = $(this).data('post');

                    var myString = $(this).parent().find('span').prop('innerHTML');

                    console.log(myString);

                    myString = myString.replace("Share", "")

                    var result = myString.match(/\((.*)\)/);

                    var currentValue = result[1];

                    console.log(currentValue);

                    var newValue = parseInt(currentValue.trim()) + 1;

                    console.log(newValue);

                    $(this).parent().find('span').prop('innerHTML', ' Share(' + newValue + ')');

                    $(this).addClass('active');

                    $.ajax({

                        type: "POST",

                        url: "{{ route('user.share') }}",

                        data: {

                            post_id: post,

                            _token: '{{ csrf_token() }}'

                        },

                        success: function(data) {

                            if (data.success && data.success == 1) {

                                toastr.success("Successfully Shared On Your Profile")

                            } else {

                                toastr.error("Unexpected Error! Please try Again.")

                            }

                        }

                    })

                })

            })

        })(jQuery);
    </script>

    <script src="/assets/front/js/jquery.jscroll.min.js">
    </script>

    <script type="text/javascript">
        $(function() {

            $('.infinite-scroll').jscroll({

                autoTrigger: !0,

                loadingHtml: '<div class="section-box infinite-loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw" aria-hidden="true"></i></div>',

                padding: 0,
                nextSelector: 'ul.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                    constplayers = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p))
                }
            })
        });
    </script>

    <script>
        (function($) {

            $(document).ready(function() {

                $(document).on('click', '#get_search-form', function(e) {

                    e.preventDefault();

                    $('.search-area-mobile').css('display', 'block');

                    $(this).attr('id', 'get_search_clicked')

                })

                $(document).on('click', '#get_search_clicked', function(e) {

                    e.preventDefault();

                    $('.search-area-mobile').css('display', 'none');

                    $(this).attr('id', 'get_search-form')

                })

                // toastr.success("Post Published Successfully.")

            });

            $(document).on('click', '.imgclickcls', function() {

                var image = $(this).attr('src');

                var theImage = new Image();

                $(theImage).load(function() {

                    if (this.width >= 1000) {

                        $('#imgmodalwidth').css('width', '1050')

                    } else {

                        $('#imgmodalwidth').css('width', this.width + 50)

                    }

                });

                theImage.src = image;

                $("#imagesrc").attr("src", image)

            })

        })(jQuery);
    </script>

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b028cce69cdbe02">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            const emoeditor = $(".article-emoji-input").emojioneArea({

                pickerPosition: "bottom",

                filtersPosition: "bottom",

            });

            emoeditor[0].emojioneArea.on("paste", function(editor, event) {

                var value = this.getText();

                var urlpat = /^https?:\/\//i;

                if (urlpat.test(value)) {

                    $("#loaderimg").show();

                    $('#urldatadiv').css('display', 'none');

                    setTimeout(function() {

                        $.ajax({

                            type: "POST",

                            url: "{{ route('user.urllink.data') }}",

                            data: {

                                'urllink': value,

                                _token: '{{ csrf_token() }}'

                            },

                            async: !1,

                            success: function(data) {

                                console.log('link success');

                                var res = data.split("!~");

                                $('#urldatadiv').css('display', 'block');

                                $('#urldatadiv').html(res[0]);

                                $('#urldataval').val(res[0]);

                                $('#hrefurl').val(res[1]);

                                $("#loaderimg").hide();

                                //emoeditor[0].emojioneArea.html('');

                                //$(".emojionearea-editor").html('');

                                //$(".article-emoji-input").val('');

                            }

                        })

                    }, 100)

                }

            });

            emoeditor[0].emojioneArea.on("keyup", function(editor, event) {

                var value = this.getText();

                if (value == "") {

                    $('#urldatadiv').css('display', 'none');

                    $('#urldatadiv').html('');

                    $('#urldataval').val('');

                    $('#hrefurl').val('')

                }

            });

            $('[rel="tooltip"]').tooltip();

            const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));

            $(document).on('change', '#image', function(e) {

                console.log('in image');

                if (this.files.length) {

                    console.log('in image length');

                    var file = this.files[0];

                    upload(file, 'image');

                    $('#video').val(null);

                    $('#audio').val(null);

                    $('#youtube').val(null);

                    $('#vimeo').val(null);

                    $('#doc').val(null)

                }

            });

            $(document).on('change', '#video', function(e) {

                if (this.files.length) {

                    var file = this.files[0];

                    if (file.type === 'video/mp4') {

                        upload(file, 'video');

                        $('#image').val(null);

                        $('#audio').val(null);

                        $('#youtube').val(null);

                        $('#vimeo').val(null);

                        $('#doc').val(null)

                    } else {

                        toastr.warning('Only MP4 is supported')

                    }

                }

            });

            $(document).on('change', '#doc', function(e) {

                if (this.files.length) {

                    var file = this.files[0];

                    $('#type').val('doc');

                    upload(file, 'doc');

                    $('#image').val(null);

                    $('#video').val(null);

                    $('#audio').val(null);

                    $('#youtube').val(null);

                    $('#vimeo').val(null)

                }

            });

            $(document).on('change', '#audio', function(e) {

                if (this.files.length) {

                    var file = this.files[0];

                    if (file.type === 'audio/mpeg' || file.type == 'audio/mp3') {

                        upload(file, 'audio');

                        $('#image').val(null);

                        $('#video').val(null);

                        $('#youtube').val(null);

                        $('#vimeo').val(null);

                        $('#doc').val(null)

                    } else {

                        toastr.warning('Only MP3 is supported')

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

                        var html = '<div id="player" data-plyr-provider="youtube" data-plyr-embed-id="' + value + '"> < /div>\n';
                        $('#cont div').html(html);
                        const player = new Plyr('#player');
                        $('#cont div').css('height', '300px');
                        $('#cont').fadeIn();
                        $('.emojionearea-editor').attr('placeholder', 'Caption');
                        $('#image').val(null);
                        $('#video').val(null);
                        $('#audio').val(null);
                        $('#vimeo').val(null);
                        $('#doc').val(null)
                    }
                })
            });
            $(document).on('click', 'label[for="vimeo"]', function(e) {
                swal("Enter Vimeo Video ID (Like 114042185)", {
                    content: "input",
                }).then((value) => {
                    if (value != '') {
                        $('#vimeo').val(value);
                        $('#type').val('vimeo');
                        var html = '<div id="player" data-plyr-provider="vimeo" data-plyr-embed-id="' + value + '"> < /div>\n';
                        $('#cont div').html(html);
                        const player = new Plyr('#player');
                        $('#cont div').css('height', '300px').fadeIn();
                        $('#cont').fadeIn();
                        $('.emojionearea-editor').attr('placeholder', 'Caption');
                        $('#image').val(null);
                        $('#video').val(null);
                        $('#audio').val(null);
                        $('#youtube').val(null);
                        $('#doc').val(null)
                    }
                })
            });
            $(document).on('click', '#cont span', function(e) {
                $('#cont').fadeOut();

                $('#cont div').html('');
                $('.emojionearea-editor').attr('placeholder', 'New Article');
                var link = $('#link').val();
                if (link != '') {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.file.delete') }}",
                        data: {
                            link: link,
                            _token: '{{ csrf_token() }}'
                        }
                    })
                }

                $('#type').val('')

            });
            $(".article-emoji-input").emojioneArea({

                pickerPosition: "bottom",

                filtersPosition: "bottom",

            });
            $(".nice-scroll").niceScroll({

                cursorcolor: "#07cb79",

                cursorwidth: "10px",

                background: "rgba(26, 39, 53, 0.3)",

                cursorborder: "1px solid aquamarine",

                cursorborderradius: 10

            })

        });

        function upload(file, type) {

            var formdata = new FormData();

            formdata.append("_token", "{{ csrf_token() }}");

            formdata.append("type", type);

            formdata.append("file", file);

            var ajax = new XMLHttpRequest();

            ajax.upload.addEventListener("progress", progressHandler, !1);

            ajax.addEventListener("load", completeHandler, !1);

            ajax.addEventListener("error", errorHandler, !1);

            ajax.addEventListener("abort", abortHandler, !1);

            ajax.open("POST", "{{ route('file.store') }}");

            ajax.send(formdata)

        }

        function progressHandler(event) {

            var percent = (event.loaded / event.total) * 100;

            $("#post-ajax-loader").fadeIn();

            $("#prog").css('width', Math.round(percent) + '%');

            $("#prog").text(Math.round(percent) + '%')

        }

        function completeHandler(event) {

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

                $('.emojionearea-editor').attr('placeholder', 'New Article')

            } else {

                $("#prog").text("Upload Completed");

                $("#link").val(jso.link);

                $('#type').val(jso.type);

                $('.emojionearea-editor').attr('placeholder', 'Caption');

                $('input[type="file"]').val(null);

                toastr.success('Uploaded Successfully. Just Share This');

                if (jso.type == 'image') {

                    $('#cont').fadeIn();

                    $('#cont div').html('<img src="{{ url('
                        assets / front / content / ') }}/' + jso.link + '" class="img-responsive" style="width: 100%;margin-bottom: 20px;">')

                } else if (jso.type == 'video') {

                    $('#cont').fadeIn();

                    var html = '<video id="player" playsinline controls>\n' + '<source src="{{ url('
                    assets / front / content / ') }}/' + jso.link + '" type="video/mp4" id="player-src">\n' + '</video>';

                    $('#cont div').html(html);

                    const player = new Plyr('#player')

                } else if (jso.type == 'audio') {

                    $('#cont').fadeIn();

                    var html = '<audio id="player" controls> <source src="{{ url('
                    assets / front / content / ') }}/' + jso.link + '" type="audio/mp3" id="player-src"> < /audio>';
                    $('#cont div').html(html);
                    const player = new Plyr('#player')
                }

                setTimeout(function() {

                    $("#prog").css('width', '0%');

                    $("#prog").text('0%');

                    $("#prog").fadeOut();

                    $('#post-ajax-loader').fadeOut()

                }, 1500)

            }

        }

        function errorHandler(event) {

            $("#link").val(null);

            $('#type').val(null);

            $('input[type="file"]').val(null);

            $("#prog").css('width', '0%');

            $("#prog").text('0%');

            $("#prog").fadeOut();

            $('#post-ajax-loader').fadeOut();

            toastr.error('Upload Failed. Please Try Again.');

            $('.emojionearea-editor').attr('placeholder', 'New Article')

        }

        function abortHandler(event) {

            $("#link").val(null);

            $('#type').val(null);

            $('input[type="file"]').val(null);

            $("#prog").css('width', '0%');

            $("#prog").text('0%');

            $("#prog").fadeOut();

            $('#post-ajax-loader').fadeOut();

            toastr.error('Upload Aborted. Please Try Again.');

            $('.emojionearea-editor').attr('placeholder', 'New Article')

        }
    </script>

    @endsection