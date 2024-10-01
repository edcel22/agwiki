@extends('layouts.user')

@section('css')
    <style>
        .notification-area-start ul.pagination {
            display: block !important;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="notification-area-start">
            <h2 class="title">{{ $page_title }}</h2>
            <div class="notification-area-wrapper">
                <ul>
                @if($notifications && count($notifications))
                @foreach($notifications as $notification)
                    @php
                        $notification->status = 1;
                        $notification->save();
                    @endphp
                    <li>
                        <div class="single-notification-items">
                            <div class="content">
                                 @if($notification->type == 'post')
                                    @if($notification->post)
                                        <a href="{{ route('user.post.single', $notification->post->id) }}"<h4 class="name">{{ optional($notification->post->user)->name }} @if(optional($notification->post->user)->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Posted a new {{ $notification->post->type }}.</span></h4></a>
                                    @endif
                                 @elseif($notification->type == 'follow')
                                    @php
                                        $follower = App\User::find($notification->by_id);
                                    @endphp
                                    @if($follower)
                                        <a href="{{ route('profile', $follower->username) }}"<h4 class="name">{{ $follower->name }} @if($follower->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-users" aria-hidden="true"></i> following you.</span></h4></a>
                                    @endif
                                @elseif($notification->type == 'group')
                                    @if($notification->post && $notification->post->group)
                                        <a href="{{ route('user.post.single', $notification->post->id) }}"<h4 class="name">{{ optional($notification->post->user)->name }} @if(optional($notification->post->user)->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Posted a new {{ $notification->post->type }} in {{ $notification->post->group->name }}.</span></h4></a>
                                    @endif
                                @elseif($notification->type == 'like')
                                    @php
                                        $liker = App\User::find($notification->by_id);
                                    @endphp
                                    @if($liker && $notification->post)
                                        <a href="{{ route('user.post.single', $notification->post->id) }}"><h4 class="name">{{ $liker->name }} @if($liker->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-thumbs-up" aria-hidden="true"></i> liked your post.</span></h4></a>
                                    @endif
                                @elseif($notification->type == 'group_invite')
                                    @php
                                        $inviter = App\User::find($notification->by_id);
                                    @endphp
                                    @if($inviter && $notification->group)
                                        <a href="{{ route('user.groups', $notification->group->slug) }}"<h4 class="name">{{ $inviter->name }} @if($inviter->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-users" aria-hidden="true"></i> invited you to join {{ $notification->group->name }}.</span></h4></a>
                                    @endif
                                @elseif($notification->type == 'share')
                                    @php
                                        $sharer = App\User::find($notification->by_id);
                                    @endphp
                                    @if($sharer)
                                        <a href="{{ route('profile', $sharer->username) }}"<h4 class="name">{{ $sharer->name }} @if($sharer->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-share-alt" aria-hidden="true"></i> shared your post.</span></h4></a>
                                    @endif
                                @elseif($notification->type == 'birthday')
                                    @php
                                        $birthdayOf = App\User::find($notification->by_id);
                                    @endphp
                                    @if($birthdayOf)
                                        <a href="{{ route('profile', $birthdayOf->username) }}"<h4 class="name">{{ $birthdayOf->name }} @if($birthdayOf->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-birthday-cake" aria-hidden="true"></i> have birthday today.</span></h4></a>
                                    @endif
                                @elseif($notification->type == 'comment')
                                    @php
                                        $commenter = App\User::find($notification->by_id);
                                    @endphp
                                    @if(Auth::user()->id == $notification->post->user_id)
                                        <a href="{{ route('user.post.single', $notification->post->id) }}"<h4 class="name">{{ $commenter->name }} @if($commenter->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-comments-o" aria-hidden="true"></i> commented on your post.</span></h4></a>
                                    @elseif(Auth::user()->id != $notification->by_id)
                                        <a href="{{ route('user.post.single', $notification->post->id) }}"<h4 class="name">{{ $commenter->name }} @if($commenter->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-comments-o" aria-hidden="true"></i> commented on a post that you are following.</span></h4></a>
                                    @endif
                                 @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @else
                        <li>
                            <div class="single-notification-items">
                                <h4 class="not-found">No Notifications Found</h4>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
            {{ $notifications->links() }}
        </div>
    </div>
@endsection