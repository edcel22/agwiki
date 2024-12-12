
<div class="single-profile-left-sidebar">
    <div class="author-header">
        <div class="header-area">
            <div class="cover-pic cover-pic-bg" style='background-image: url("{{asset('assets/front/img/'.auth()->user()->cover)}}");'>
                <!-- <img src="http://via.placeholder.com/100x150" alt=""> -->
            </div>
        </div>
        <div class="header-bottom">
            <div class="profile-pic"> 
                <img src="{{asset('assets/front/img/'.auth()->user()->avatar)}}" alt="{{ Auth::user()->name }}">
            </div>
            <div class="content">
                <h4 class="name">{{ Auth::user()->name }} @if(Auth::user()->verified == 1) <span class="varified"><i class="fa fa-check-circle"></i> </span>@endif</h4>
                <span class="post">{{ Auth::user()->position }}</span>
            </div>
            <div class="description">
                <p class="quote">{{ Auth::user()->quote }}</p>
            </div>
        </div>
    </div>
    <div class="author-details">
        <ul>
            <li><i class="fa fa-map-marker"></i> {{ Auth::user()->zip }} {{ Auth::user()->city }}, {{ Auth::user()->state }}, {{ Auth::user()->country }}</li>
            <li><i class="fa fa-user"></i> {{ ucfirst(strtolower(Auth::user()->gender)) }}</li>
            <li><i class="fa fa-calendar"></i> {{ optional(Auth::user()->birthday)->format('d M, Y') }}</li>
            <li><i class="fa fa-briefcase"></i> {{ Auth::user()->work }} at <span>{{ ucfirst(strtolower(Auth::user()->workplace)) }}</span></li>
        </ul>   
    </div>
    <!-- latest div area start -->
    <div class="latest-items">
        <h2 class="title">Latest </h2>
        <ul>
        @foreach($latest as $post)
            <!--@ if($user->isFollowedMe() && $post->user->isBlockedByMe(Auth::user()->id))-->
                <li><!--$post->user->isFollowedMe() -->
                    <div class="single-item">
                        <div class="top-content">
                            <a href="{{ route('user.post.single', $post->id) }}"><h4 class="excerpt"></h4>{{ optional($post->user)->name }} @if(optional($post->user)->verified == 1)<span class="varifed"><i class="fa fa-check-circle"></i></span>@endif Posted a {{ $post->type }} </a>
                        </div>
                        <div class="bottom-content">
                            <ul> 
                                <li>
                                    <span class="item"><i class="fa fa-thumbs-up" aria-hidden="true"></i> {{ number_format_short($post->likeCount()) }}</span>
                                    <span class="item"><i class="fa fa-comments" aria-hidden="true"></i> {{ number_format_short($post->commentCount()) }}</span>
                                    <span class="item"><i class="fa fa-share-alt" aria-hidden="true"></i> {{ number_format_short($post->shareCount()) }}</span>
                                    <span class="item"><i class="fa fa-eye" aria-hidden="true"></i> {{ number_format_short($post->viewCount()) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            <!--@ endif-->
        @endforeach
        </ul>
    </div>
</div>
<script>
    (function($){})
</script>