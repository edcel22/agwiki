@extends('layouts.auth')

@section('content')

<div class="page-content header-clear-small ">

	<div class="profile-2">
			<center>
                @if(Auth::check())
                    @if(isset($user) && $user->id == Auth::user()->id)
                        <a href="/profile-edit" class="button button-s shadow-large button-round-small bg-black">EDIT PROFILE <i class="fas fa-edit"></i></a>
                        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="button button-s shadow-large button-round-small bg-red1-dark">LOG OUT</a>
                        <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
                    
                        <a href="/interests" class="button button-s shadow-large button-round-small bg-black">EDIT TOPICS <i class="fas fa-edit"></i></a>
                    @endif
                @endif
			</center>
		<img class="profile-image preload-image" src="{{ asset('assets/front/img/' . ($user->avatar ?? 'default.jpg')) }}" data-src="{{ asset('assets/front/img/' . ($user->avatar ?? 'default.jpg')) }}" alt="img">

		<div class="profile-body">

			<h1 class="profile-heading">{{ $user->name ?? 'User' }}</h1>

			<h2 class="profile-sub-heading"><a href="#" class="color-highlight">@if(isset($user->workplace)){{ optional($user->job($user->workplace))['name'] ?? 'Unknown' }}@endif</a></h2>

			<h2 class="profile-sub-heading"> @if(isset($user->city)){{ $user->city }} {{ $user->state ?? '' }} {{ $user->zip ?? '' }} {{ $user->country ?? '' }} @endif</h2>

			<h2 class="profile-sub-heading">Joined: {{ optional($user->created_at)->format('d M, Y') }}</h2>

            @if(Auth::check())
                @if(isset($user) && $user->id == Auth::user()->id)
                <h2 class="profile-sub-heading"><a href="/peoples">Following ({{App\User::Staticfollowing($user->id )}}) / Followers ({{App\User::Staticfollowers($user->id )}})</a></h2>
                @else
                <h2 class="profile-sub-heading"><a href="/peoples?user={{$user->id}}">Following ({{App\User::Staticfollowing($user->id )}}) / Followers ({{App\User::Staticfollowers($user->id )}})</a></h2>
                @endif
            @endif

            @if(Auth::check())
                @if(isset($user) && $user->id != Auth::user()->id)
                <a onclick="event.preventDefault();document.getElementById('follow-form-{{ $user->id }}').submit();" class="button bg-highlight button-primary button-s button-center-small shadow-large top-30 bottom-30">
                @if($user->isFollowedMe())Unfollow @else Follow @endif
                </a>

                <a class="message button-center-small" href="/message/{{$user->username}}"><i class="fa fa-comments post-action comment"></i> Message</a>

                <form action="{{ route('user.follow', $user->username) }}" id="follow-form-{{ $user->id }}" method="post" style="display: none;">
                    @csrf
                </form>
                @endif
            @endif

			<div class="divider divider-margins bottom-15"></div>

			<div class="profile-stats">
            @if(isset($user->facebook) && $user->facebook)
                <a target="_blank" href="https://facebook.com/{{$user->facebook}}"><i style="color:white" class="fab center-text bg-facebook shadow-large fa-facebook-f"></i></a>
            @endif

            @if(isset($user->twitter) && $user->twitter)
                <a target="_blank" href="https://twitter.com/{{$user->twitter}}"><i style="color:white" class="fab center-text bg-twitter shadow-large fa-twitter"></i></a>
            @endif

            @if(isset($user->linkedin) && $user->linkedin)
                <a target="_blank" href="https://linkedin.com/in/{{$user->linkedin}}"><i style="color:white"s class="fab center-text bg-linkedin shadow-large fa-linkedin"></i></a>
            @endif
				<div class="clear"></div>
			</div>

			<div class="divider divider-margins"></div>

			<h4>BIO</h4>
			<p class="description">{{ $user->bio ?? 'No bio available' }}</p>

			<div class="clear"></div>
			<div class="divider divider-margins"></div>

			<div class="accordion-style-2">
				<a href="#" data-accordion="accordion-content-5">
					<i class="accordion-icon-left far fa-file-alt"></i>	Topics	<i class="fa fa-angle-down padding-10"></i>
				</a>
				<p id="accordion-content-5" class="accordion-content bottom-10" style="display: none;">
					@if(isset($user->interests) && count($user->interests))
                        @foreach($user->interests as $interest)
                        <a href="/feed?topic={{$interest->id}}" class="topic active">{{$interest->name}}</a>
                        @endforeach
                    @else
                        No topics found
                    @endif
				</p>
			</div>

			<div class="clear"></div>

            @if(isset($groups) && count($groups))
            <div class="accordion-style-2">
				<a href="#" data-accordion="accordion-content-6">
					<i class="accordion-icon-left fas fa-users"></i>	Groups	<i class="fa fa-angle-down padding-10"></i>
				</a>
				<div id="accordion-content-6" class="accordion-content bottom-10" style="display: none;">
                    @foreach($groups as $group)
                        @if(isset($group->group))
                        <div class="one-half">
                            <div class="content content-box bg-white shadow-large">
                                <a href="{{ route('user.groups', optional($group->group)->slug ?? '#') }}">
                                    <h3 class="top-10">{{ optional($group->group)->name ?? 'Unnamed Group' }}</h3>
                                    <p class="bottom-10 description block">
                                        {{ optional($group->group)->description ?? 'No description available' }}
                                    </p>
                                </a>
                                <p>
                                    @if(isset($group->group) && method_exists($group->group, 'creator') && $group->group->creator())
                                    <a href="{{ route('profile', optional($group->group->creator())->username ?? '#') }}">
                                        <span><i class="fas fa-user-alt"></i>{{ optional($group->group->creator())->name ?? 'Unknown Creator' }}</span>
                                    </a>
                                    @endif
                                    <span><i class="fas fa-user-check"></i>{{ number_format_short(optional($group->group)->memberCount() ?? 0) }} Members</span>
                                    <span><i class="far fa-file-alt"></i>
                                    @if(isset($group->group->topics) && count($group->group->topics))
                                        @foreach($group->group->topics as $myinterest)
                                        <a href="#">{{$myinterest->name ?? 'Unknown Topic'}}</a>,
                                        @endforeach
                                    @endif
                                    </span>
                                </p>
                                <p>
                                    <br>
                                    <a href="{{ route('user.groups', optional($group->group)->slug ?? '#') }}" class="button button-xs bg-highlight bg-blue1-light"><i class="fas fa-arrow-alt-circle-right"></i> Visit Group</a>
                                </p>
                            </div>
                        </div>
                        @endif
                    @endforeach
				</div>
			</div>
            <div class="clear"></div>
            @endif

			<div class="clear"></div>

            @if(isset($shares) && count($shares))
            <div class="post-loop-inner infinite-scroll">
                @foreach($shares as $share)
                    @if(isset($share->post))
                        @php
                            $post = $share->post;
                        @endphp

                        @php $postTopics = isset($post) ? App\Post::postTopics($post->id) : []; @endphp

                        @if(isset($post->type) && $post->type=='feed')
                            <!-- Feed post section code omitted for brevity -->
                        @else
                            <!-- Other post types section code omitted for brevity -->
                        @endif
                    @endif
                @endforeach
                @endif
                <div style="display:none">{{ isset($shares) ? $shares->links() : '' }}</div>
            </div>

			<div class="divider-margins top-15"></div>
		</div>
	</div>
</div>

@endsection