@extends('layouts.user')

@section('content')
    <div class="col-md-12 single">
        <h4 class="title">{{ $page_title }}</h4>
            @if($users && count($users))
            <div class="top-author-list">
                <ul>
                    @foreach($users as $user)
                    <li>
                        <div class="single-top-author">
                            <div class="thumb">
                                <img src="{{ asset('assets/front/img/' . $user->avatar) }}" alt="{{ $user->name }}">
                            </div>
                            <div class="content">
                                <a href="{{ route('profile', $user->username) }}" class="nam">{{ $user->name }} @if($user->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif</a>
                                @if(! $user->isFollowedMe())
                                <a onclick="event.preventDefault();
              document.getElementById('follow-form-{{ $user->id }}').submit();" style="cursor: pointer;" class="follow-btn" title="Follow" data-toggle="tooltip"><i class="fa fa-user-plus"></i></a>
                                <form action="{{ route('user.follow', $user->username) }}" id="follow-form-{{ $user->id }}" method="post" style="display: none;">
                                    @csrf
                                </form>
                                @endif
                                <a href="{{ route('message', $user->username) }}" class="follow-btn" title="Message" data-toggle="tooltip"><i class="fa fa-comments"></i></a>
                            </div>
                        </div> 
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        @if($groups && count($groups))
            <div class="top-author-list">
                <h4 class="title">Groups</h4>
                <ul>
                    @foreach($groups as $group)
                        <li>
                            <div class="single-top-author">
                                <div class="thumb">
                                    <img src="{{ asset('assets/front/img/' . $group->cover) }}" alt="{{ $group->name }}">
                                </div>
                                <div class="content">
                                    <a href="{{ route('user.groups', $group->slug) }}" class="nam">{{ $group->name }}</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    @if($posts && count($posts))
    <div class="post-loop-wrapper">
        <div class="post-loop-inner">
        @foreach($posts as $post)
                        @if(! $post->user->isBlockedByMe(Auth::user()->id))
                            <div class="single-post-item">
                                <div class="thumb">
                                    <img src="{{ asset('assets/front/img/' . optional($post->user)->avatar) }}" alt="{{ optional($post->user)->name }}">
                                </div>
                                <div class="content">
                                    <h4 class="name"><a href="{{ route('profile', optional($post->user)->username) }}">{{ optional($post->user)->name }} @if(optional($post->user)->verified == 1)<span class="varifed"><i class="fa fa-check-circle"></i></span>@endif</a>@if($post->group) &#8658;
                                        <a href="{{ route('user.groups', $post->group->slug) }}">{{ $post->group->name }}</a>@endif <span class="days"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->created_at->diffForHumans() }}</span></h4>
                                    <article>
                                        @if($post->type == 'article')
                                            <p>{!! excerpt($post) !!}</p>
                                        @elseif($post->type == 'image')
                                            <p>{!! excerpt($post) !!}</p><br>
                                            <img src="{{ asset('assets/front/content/' . $post->link) }}" class="img-responsive">
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
                                                            <li>
                                                                <a data-original-title="Email" rel="tooltip" class="btn btn-mail mail-share" data-placement="left" data-id="{{ $post->id }}">
                                                                    <i class="fa fa-envelope"></i>
                                                                </a>
                                                            </li>
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
        @endforeach
        </div>
    </div>
    @endif
@endsection