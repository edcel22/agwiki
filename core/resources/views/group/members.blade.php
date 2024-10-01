@extends('layouts.auth')
@section('content')
<div class="page-content">
	<div class="top-20">
		<a href="../"><i class="fas fa-angle-double-left"></i> Back to Group</a>
	</div>
	<div class="post-loop-wrapper top-20">
		<div class="post-loop-inner">
			<div class="top-author-list">
				@if($status == 'active')
				<h4 class="title">Admin & Moderators</h4>
				<ul>
					@foreach($adminAndModerators as $item)
					@php
					$usero = $item->user;
					@endphp
					<li>
						<div class="single-top-author top-20">
							<div class="one-half center-text" >

                                <a href="/profile/{{ $usero->username }}" class="user">

                                    <img src="{{ asset('assets/front/img/' . $usero->avatar) }}" alt="{{ $usero->name }}" style="border-radius: 50%;margin: 0 auto 6px;height: 100px;width: 100px;">

                                </a>
                                <a href="/profile/{{ $usero->username }}">
									<div class="username">
										<a @if(! $usero->isBlockedByMe(Auth::user()->id)) href="{{ route('profile', $usero->username) }}" @endif class="nam">{{ $usero->name }} @if($usero->verified == 1)<span class="verified"><i class="fa fa-check-circle"></i></span>@endif</a>
									</div>
									<div class="role">
										<strong>
											@if($item->role == 1) Super Admin @elseif($item->role == 2) Admin @else Moderator @endif
											@if($item->role == 2)
											@if($group->isCreator() || $group->isAdmin())
											<a onclick="event.preventDefault();
												document.getElementById('ban-form-{{ $usero->id }}').submit();" style="cursor: pointer;" class="follow-btn" title="Ban" data-toggle="tooltip"><i class="fa fa-ban"></i></a>
											<form action="{{ route('user.group.action', [$group->slug, $usero->username, 'ban']) }}" id="ban-form-{{ $usero->id }}" method="post" style="display: none;">
												@csrf
											</form>
											<a onclick="event.preventDefault();
												document.getElementById('remove-form-{{ $item->id }}').submit();" class="follow-btn" title="Remove" data-toggle="tooltip"><i class="fa fa-times"></i>
											</a>

											<form action="{{ route('user.group.role', [$item->id, 'remove']) }}" id="remove-form-{{ $item->id }}" method="post" style="display: none;">
												@csrf
											</form>
											@endif
											@endif
											@if($item->role == 3)
											@if($group->isCreator() || $group->isAdmin())
											<a onclick="event.preventDefault();
												document.getElementById('admin-form-{{ $item->id }}').submit();" class="follow-btn" title="Make Admin" data-toggle="tooltip"><i class="fa fa-check-circle-o"></i> </a>
											<form action="{{ route('user.group.role', [$item->id, 'admin']) }}" id="admin-form-{{ $item->id }}" method="post" style="display: none;">
												@csrf
											</form>
											<a onclick="event.preventDefault();
												document.getElementById('ban-form-{{ $usero->id }}').submit();" style="cursor: pointer;" class="follow-btn" title="Ban" data-toggle="tooltip"><i class="fa fa-ban"></i></a>
											<form action="{{ route('user.group.action', [$group->slug, $usero->username, 'ban']) }}" id="ban-form-{{ $usero->id }}" method="post" style="display: none;">
												@csrf
											</form>
											<a onclick="event.preventDefault();
												document.getElementById('remove-form-{{ $item->id }}').submit();" class="follow-btn" title="Remove" data-toggle="tooltip"><i class="fa fa-times"></i> </a>
											<form action="{{ route('user.group.role', [$item->id, 'remove']) }}" id="remove-form-{{ $item->id }}" method="post" style="display: none;">
												@csrf
											</form>
											@endif
											@endif
										</strong>
									</div>
									<div class="location">@if($usero->city){{ $usero->city }}, {{ $usero->state }}@endif</div>
								</a>
							</div>
						</div>
					</li>
					@endforeach
				</ul>
				@endif
				<br><br><br class="divider divider-margins top-20">
				@if($status == 'active')
				<div class="divider divider-margins"></div>
				<h4 class="title">Members</h4>
				@elseif($status == 'pending')
				<h4 class="title">Pending Request</h4>
				@endif
				<ul>
					@foreach($members as $item)
					@php
					$usero = $item->user;
					@endphp
					<li>
						<div class="single-top-author top-20">
							<div class="one-half left-text">
								<img src="{{ asset('assets/front/img/' . $usero->avatar) }}" alt="{{ $usero->name }}" style="border-radius: 50%;height: 100px;width: 100px;">
								<div style="clear: both"></div>
								<a style="margin: 10px;" @if(! $usero->isBlockedByMe(Auth::user()->id)) href="{{ route('profile', $usero->username) }}" @endif class="nam">{{ $usero->name }} @if($usero->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif</a>
								@if($status == 'pending')
								<a style="margin: 10px;" onclick="event.preventDefault();
									document.getElementById('approve-form-{{ $usero->id }}').submit();" style="cursor: pointer;" class="follow-btn float-left" title="Approve" ><i class="fa fa-check"></i></a>
								<form action="{{ route('user.group.action', [$group->slug, $usero->username, 'approve']) }}" id="approve-form-{{ $usero->id }}" method="post" style="display: none;">
									@csrf
								</form>
								<a style="margin: 10px;" onclick="event.preventDefault();
									document.getElementById('reject-form-{{ $usero->id }}').submit();" style="cursor: pointer;" class="follow-btn float-left" title="Reject" ><i class="fa fa-times"></i></a>
								<form action="{{ route('user.group.action', [$group->slug, $usero->username, 'reject']) }}" id="reject-form-{{ $usero->id }}" method="post" style="display: none;">
									@csrf
								</form>
								@endif
								@if($group->isCreator() || $group->isAdmin() || $group->isModerator())
								<a style="margin: 10px;" onclick="event.preventDefault();
									document.getElementById('ban-form-{{ $usero->id }}').submit();" style="cursor: pointer;" class="follow-btn float-left" title="Ban" ><i class="fa fa-ban"></i></a>
								<form action="{{ route('user.group.action', [$group->slug, $usero->username, 'ban']) }}" id="ban-form-{{ $usero->id }}" method="post" style="display: none;">
									@csrf
								</form>
								<a style="margin: 10px;" style="cursor: pointer;" onclick="event.preventDefault();
									document.getElementById('remove-form-{{ $item->id }}').submit();" class="follow-btn float-left" title="Remove" >Remove</i> </a>
								<form action="{{ route('user.group.role', [$item->id, 'remove']) }}" id="remove-form-{{ $item->id }}" method="post" style="display: none;">
									@csrf
								</form>
								@endif
								<div style="clear: both"></div>
								@if(($group->isCreator() || $group->isAdmin()) && $item->status == 1)
								<a style="margin: 10px;" style="cursor: pointer;" onclick="event.preventDefault();
									document.getElementById('admin-form-{{ $item->id }}').submit();" class="follow-btn float-left" title="Make Admin" data-toggle="tooltip"><i class="fa fa-check-circle-o"></i> </a>
								<form action="{{ route('user.group.role', [$item->id, 'admin']) }}" id="admin-form-{{ $item->id }}" method="post" style="display: none;">
									@csrf
								</form>
								<a style="margin: 10px;" style="cursor: pointer;" onclick="event.preventDefault();
									document.getElementById('moderator-form-{{ $item->id }}').submit();" class="follow-btn float-left" title="Make Moderator" data-toggle="tooltip"><i class="fa fa-check-circle-o"></i> </a>
								<form action="{{ route('user.group.role', [$item->id, 'moderator']) }}" id="moderator-form-{{ $item->id }}" method="post" style="display: none;">
									@csrf
								</form>
								@endif
								<div class="role">@if(isset($usero->workplace)){{ $usero->job($usero->id)['name']}}@endif</div>
								<div class="location">@if($usero->city){{ $usero->city }}, {{ $usero->state }}@endif</div>
							</div>
						</div>
					</li>
					@endforeach
				</ul>
				<div class="pagi">
					{{ $members->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
