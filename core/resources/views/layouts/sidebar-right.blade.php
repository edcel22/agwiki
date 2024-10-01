@if(count($topAuthors))
<div class="right-sidebar-area">
    <div class="top-author-list">
        <h4 class="title">Who to follow</h4>
        <ul>
            @foreach($topAuthors as $user)
                @if($user->id != Auth::user()->id && ! $user->isFollowedMe() && ! $user->isBlockedByMe(Auth::user()->id))
                    <li>
                        <div class="single-top-author">
                            <div class="thumb">
                                <img src="{{ asset('assets/front/img/' . $user->avatar) }}" alt="{{ $user->name }}">
                            </div>
                            <div class="content">
                                <a href="{{ route('profile', $user->username) }}" class="nam">{{ $user->name }} @if($user->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif</a>
                                <a onclick="event.preventDefault();
              document.getElementById('follow-form-{{ $user->id }}').submit();" style="cursor: pointer;" class="follow-btn" title="Follow" data-toggle="tooltip"><i class="fa fa-user-plus"></i></a>
                                <form action="{{ route('user.follow', $user->username) }}" id="follow-form-{{ $user->id }}" method="post" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div> 
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
@endif