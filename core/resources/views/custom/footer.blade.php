@php
$theUser = Auth::user();

if(isset($theUser->id)) {
   
$count=App\User::StaticunreadMessageCount($theUser->id);
$messages=App\User::StaticunreadMessages($theUser->id);
$notifications = App\User::StaticgetLatestNotifications($theUser->id);
$countN = App\User::StaticunreadNotificationsCount($theUser->id);
//die(print_r($notifications));
// $messages=array_merge($messages, $notifications);
}
@endphp


<!-- if the user is logged in -->
@if(isset($theUser->id))
<div id="footer-menu" class="bg-green1-light">

	<a href="/home"><i class="fas fa-th"></i><span>Dashboard</span></a>

    @if (Auth::check())
	<a href="#" data-menu="menu-alerts"><i class="fas fa-bell"></i><span>Alerts</span>
	    @if($countN>0)<span class="badge">{{$countN}}</span>@endif</a>
    @else
        <a onclick= "return registerPopup()"><i class="fas fa-bell"></i><span>Alerts</span>
	@endif

    @if (Auth::check())
	    <a href="#" data-menu="menu-messages"><i class="fas fa-envelope"></i><span>Messages</span>
	    @if($count>0)<span class="badge">{{$count}}</span>@endif</a>
    @else
        <a onclick= "return registerPopup()"><i class="fas fa-envelope"></i><span>Messages</span>
    @endif

</div>

<div id="menu-alerts" class="menu menu-box-bottom" data-menu-height="70%" data-menu-effect="menu-over">

	<div id="readAlerts" style="cursor:pointer">Mark all as read</div>

	<div class="messages">

		@if($notifications && count($notifications)>0)
		@foreach($notifications as $notification)
        @if(isset($notification))
		<div data-message="{{$notification->id}}" class="notification item {{ (($notification->status == 0)?"active":"read") }} ">

			@php
			//$notification->status = 1;
			//$notification->save();
			//|| $notification->post->type == 'article'
			@endphp
			@if($notification->type == 'post' && isset($notification->post) && isset($notification->post->user))

			<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}" data-src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}"> </a>
			 <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>

			<span>
				<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}">
					<h4 class="name">{{ optional($notification->post->user)->name ?? 'Unknown User' }} </h4>
				</a>
			</span>

			<span class="notify-name">
            <a href="{{ route('user.post.single', optional($notification->post)->id ?? 0) }}">
            <i class="fas fa-newspaper" aria-hidden="true"></i> Posted a new {{ optional($notification->post)->type ?? 'post' }}.</a>
			</span>
			
			@elseif($notification->type == 'follow')
			@php
			$follower = App\User::find($notification->by_id);
			@endphp
			@if(isset($follower))

			<a href="/profile/{{ $follower->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $follower->avatar) }}" data-src="{{ asset('assets/front/img/' . $follower->avatar) }}"></a>
				<span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="{{ route('profile', $follower->username ?? '') }}">
					<h4 class="name">{{ $follower->name ?? 'Unknown User' }} </h4>
				</a>
			</span>

			@if($follower->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fas fa-users" aria-hidden="true"></i> following you.</span>

			@endif

			@elseif($notification->type == 'group' && isset($notification->post) && isset($notification->post->group) && isset($notification->post->user))

			<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}" data-src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}">
					<h4 class="name">{{ optional($notification->post->user)->name ?? 'Unknown User' }} </h4>
				</a>
			</span>

			@if(optional($notification->post->user)->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif
            <a href="{{ route('user.post.single', optional($notification->post)->id ?? 0) }}">
                <span class="notify-name">
                <i class="fas fa-newspaper" aria-hidden="true"></i> Posted a new {{ optional($notification->post)->type ?? 'post' }} in {{ optional($notification->post->group)->name ?? 'a group' }}.</span>
            </a>

			@elseif($notification->type == 'group_request')

			@php
			$invitie = App\User::find($notification->to_id);
			@endphp

			@if(isset($invitie) && isset($notification->group))

			<a href="/profile/{{ $invitie->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $invitie->avatar) }}" data-src="{{ asset('assets/front/img/' . $invitie->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="{{ route('user.groups', optional($notification->group)->slug ?? '') }}">
					<h4 class="name">{{ $invitie->name ?? 'Unknown User' }}</h4>
				</a>
			</span>

			@if($invitie->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fas fa-users" aria-hidden="true"></i> asked to join {{ optional($notification->group)->name ?? 'a group' }}.</span>

			@endif

			@elseif($notification->type == 'group_accepted')

			@php
			$invitie = App\User::find($notification->to_id);
            $invitor = App\User::find($notification->by_id);
			@endphp

			@if(isset($invitie) && isset($invitor) && isset($notification->group))

			<a href="/profile/{{ $invitor->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $invitor->avatar) }}" data-src="{{ asset('assets/front/img/' . $invitor->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="{{ route('user.groups', optional($notification->group)->slug ?? '') }}">
					<h4 class="name">{{ $invitor->name ?? 'Unknown User' }}</h4>
				</a>
			</span>

			@if($invitie->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fas fa-users" aria-hidden="true"></i> accepted you to {{ optional($notification->group)->name ?? 'a group' }}.</span>

			@endif

			@elseif($notification->type == 'like')

			@php
			$liker = App\User::find($notification->by_id);
			@endphp

			@if(isset($liker) && isset($notification->post))

			<a href="/profile/{{ $liker->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $liker->avatar) }}" data-src="{{ asset('assets/front/img/' . $liker->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="/profile/{{ $liker->username ?? '#' }}">
					<h4 class="name">{{ $liker->name ?? 'Unknown User' }}</h4>
				</a>
			</span>

			@if($liker->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif <span class="notify-name"><a href="{{ route('user.post.single', optional($notification->post)->id ?? 0) }}"><i class="fas fa-thumbs-up" aria-hidden="true"></i> liked your post.</a></span>

			@endif

			@elseif($notification->type == 'group_invite')

			@php
			$inviter = App\User::find($notification->by_id);
			@endphp

			@if(isset($inviter) && isset($notification->group))

			<a href="/profile/{{ $inviter->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $inviter->avatar) }}" data-src="{{ asset('assets/front/img/' . $inviter->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="{{ route('user.groups', optional($notification->group)->slug ?? '') }}">
					<h4 class="name">{{ $inviter->name ?? 'Unknown User' }}</h4>
				</a>
			</span>

			@if($inviter->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fas fa-users" aria-hidden="true"></i> <a href="/groups/{{ optional($notification->group)->slug ?? '' }}">invited you to join {{ optional($notification->group)->name ?? 'a group' }}</a>.</span>

			@endif

			@elseif($notification->type == 'share')

			@php
			$sharer = App\User::find($notification->by_id);
			@endphp

			@if(isset($sharer))

			<a href="/profile/{{ $sharer->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $sharer->avatar) }}" data-src="{{ asset('assets/front/img/' . $sharer->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="{{ route('profile', $sharer->username ?? '') }}">
					<h4 class="name">{{ $sharer->name ?? 'Unknown User' }} @if($sharer->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif</h4>
				</a>
			</span>

			<span class="notify-name">
            <a href="{{ route('user.post.single', $notification->post_id ?? 0) }}"><i class="fas fa-share-square" aria-hidden="true"></i> shared your post.</a>
            </span>

			@endif

			@elseif($notification->type == 'birthday')

			@php
			$birthdayOf = App\User::find($notification->by_id);
			@endphp

			@if(isset($birthdayOf))

			<a href="/profile/{{ $birthdayOf->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $birthdayOf->avatar) }}" data-src="{{ asset('assets/front/img/' . $birthdayOf->avatar) }}"> </a>
            <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
			<span>
				<a href="{{ route('profile', $birthdayOf->username ?? '') }}">
					<h4 class="name">{{ $birthdayOf->name ?? 'Unknown User' }} @if($birthdayOf->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif </h4>
				</a>
			</span>

			<span class="notify-name"><i class="fas fa-birthday-cake" aria-hidden="true"></i> has a birthday today.</span>

			@endif

			@elseif($notification->type == 'comment')

				@php
				$commenter = App\User::find($notification->by_id);
				@endphp

                @if(isset($commenter))
				<a href="/profile/{{ $commenter->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . $commenter->avatar) }}" data-src="{{ asset('assets/front/img/' . $commenter->avatar) }}"> </a>
                <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
				<span>
					<a href="/profile/{{ $commenter->username ?? '#' }}">
						<h4 class="name">{{ $commenter->name ?? 'Unknown User' }}</h4>
					</a>
				</span>

				@if($commenter->verified == 1)<span class="verified"><i class="fas fa-check-circle"></i></span>@endif <span class="notify-name">
					<a href="{{ route('user.post.single', $notification->post_id ?? 0) }}"><i class="fas fa-comment" aria-hidden="true"></i> commented on a post that you are following.</a>
				</span>
                @endif

			@elseif($notification->type == 'userTag' && isset($notification->post) && isset($notification->post->user))

				<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}" data-src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}"> </a>
                <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
				<span>
					<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}">
						<h4 class="name">{{ optional($notification->post->user)->name ?? 'Unknown User' }} </h4>
					</a>
				</span>
				<span class="notify-name">
					<a href="{{ route('user.post.single', $notification->post_id ?? 0) }}"><i class="fas fa-comment" aria-hidden="true"></i> Mentioned you in this {{ optional($notification->post)->type ?? 'post' }}</a>
				</span>

			@elseif($notification->type == 'userTagComment')

				<a href="/profile/{{ optional($notification->user)->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . optional($notification->user)->avatar) }}" data-src="{{ asset('assets/front/img/' . optional(optional($notification->post)->user)->avatar) }}"> </a>
                <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
				<span>
					<a href="/profile/{{ optional($notification->user)->username ?? '#' }}">
						<h4 class="name">{{ optional($notification->user)->name ?? 'Unknown User' }} </h4>
					</a>
				</span>
				<span class="notify-name">
					<a href="{{ route('user.post.single', $notification->post_id ?? 0) }}"><i class="fas fa-comment" aria-hidden="true"></i> Mentioned you in this {{ optional(optional($notification->post))->type ?? 'post' }}</a>
				</span>

			@elseif(isset($notification->post) && isset($notification->post->user))

				<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}"><img class="profile-image" src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}" data-src="{{ asset('assets/front/img/' . optional($notification->post->user)->avatar) }}"> </a>
                <span class="messageDate">{{ \Carbon\Carbon::parse($notification->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
				<span>
					<a href="/profile/{{ optional($notification->post->user)->username ?? '#' }}">
						<h4 class="name">{{ optional($notification->post->user)->name ?? 'Unknown User' }} </h4>
					</a>
				</span>
				<span class="notify-name">
					<a href="{{ route('user.post.single', $notification->post_id ?? 0) }}"><i class="fas fa-comment" aria-hidden="true"></i> {{ $notification->type ?? '' }}d this {{ optional($notification->post)->type ?? 'post' }}</a>
				</span>

			@endif

		</div>
		@endif
		@endforeach

		@else

	<div class="single-notification-items">
		<h4 class="not-found">No Notifications Found</h4>
	</div>

	@endif

</div>

</div>

<div id="menu-messages" class="menu menu-box-bottom" data-menu-height="70%" data-menu-effect="menu-over">

	<div class="messages">

		@if($messages && count($messages)>0)

		@foreach($messages as $message)

		<div class="{{ (($message->status == 0)?"active":"read") }} ">

		<div class="single-notification-items ">
			<a href="/profile/{{ optional($message->fromUser)->username ?? '#' }}/">
			<img class="profile-image" class="profile-image" src="{{ asset('assets/front/img/' . optional($message->fromUser)->avatar) }}">
			</a>
			<div class="message-from">

				<a href="{{ route('message', optional($message->fromUser)->username ?? '') }}/#messagePost" class="name">

					 <span> {{ optional($message->fromUser)->name ?? 'Unknown User' }}</span><br>
					 <span class="messageDate">{{ \Carbon\Carbon::parse($message->created_at,'America/Chicago')->format('m/d/Y h:ia' )}}</span><br>
 					<span class="notify-name"><i class="fas fa-envelope" aria-hidden="true"></i> {{ str_limit(optional($message)->content ?? '', 20, '...') }}</span>

					</p>

				</a>

			</div>

		</div>

	</div>

	@endforeach

	@else
    	<div class="single-notification-items">
		<h4 class="not-found">No New Messages Found</h4>
	</div>
	@endif

</div>

</div>

<div id="menu-warning" class="menu menu-box-bottom" data-menu-height="70%" data-menu-effect="menu-over">

	<h1 class="center-text top-30"><i class="fas fa-3x fa-briefcase-medical color-red2-dark"></i></h1>

	<h1 class="center-text uppercase ultrabold top-30">New Features</h1>

	<p class="boxed-text-large">

		We've added some cool new features. Wanna see them? <br>

		<a href="#">CLICK HERE</a>

	</p>

	<a href="https://go.agwiki.com/support" class="button button-center-medium button-s shadow-large button-round-small bg-red1-light">I Need Support</a>

</div>

@php $interest=App\Interest::allTopics(); @endphp

<div id="menu-add-topic" class="menu menu-box-bottom" data-menu-effect="menu-parallax">
            <div class="content">

                <h1 class="uppercase ultrabold top-20">Add Topic</h1>

                <p class="font-11 under-heading bottom-20">
                    Start typing the topics you want to assign to this post.
                </p>
				<p> Selected Topics: <span class="topicList"></span><p>

                <div class="search-box search-color shadow-tiny round-large bottom-20">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for topics... " data-search="">
                </div>

                <div class="search-results disabled-search-list">
                    <div class="link-list link-list-2 link-list-long-border">
                        @foreach($interest as $int)
                        <a href="#" onClick="passchecked({{$int->id}})" id="searchint{{$int->id}}" data-post="{{$int->id}}" data-filter-item="{{$int->id}}" data-filter-name="{{strtolower($int->name)}} " class="intClk">
                            <span>{{$int->name}}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="clear">
                </div>

                <a href="#" class="close-menu button button-full button-s shadow-large button-round-small bg-blue2-dark top-10">Finished</a>
            </div>
        </div>

<!-- else, just show the dashboard button for non-logged in user -->
@else 
    <div id="footer-menu" class="bg-green1-light">
        <div style = "display: flex; justify-content: center; align-items: center; height: 100%;">
            <a href="/home"><i class="fas fa-th"></i><span>Dashboard</span></a>
        </div>
    </div>
@endif

<script>
/* if ('serviceWorker' in navigator) {
    console.log("Will the service worker register?");
    navigator.serviceWorker.register('service-worker.js')
      .then(function(reg){
        console.log("Yes, it did.");
     }).catch(function(err) {
        console.log("No it didn't. This happened:", err)
    });
 }*/
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-100705616-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-100705616-1');
</script>