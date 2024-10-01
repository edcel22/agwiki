<div class="profile-page-left-sidebar">
    <div class="author-header">
        <div class="header-bottom">
            <div class="content">
                <h4 class="name">{{ $user->name }} @if($user->verified == 1) <span class="varified"><i class="fa fa-check-circle"></i> </span>@endif</h4>
                <span class="post">{{ $user->position }}</span>
            </div>
            <div class="description">
                <p class="quote">{{ $user->quote }}</p>
            </div>
        </div>
    </div>
    <div class="author-details">
        <ul>
            <li><i class="fa fa-map-marker"></i> {{ $user->zip }} {{ $user->city }}, {{ $user->state }}, {{ $user->country }}</li>
            <li><i class="fa fa-user"></i> {{ ucfirst(strtolower($user->gender)) }}</li>
            @if(Auth::check() && Auth::user()->id == $user->id)<li><i class="fa fa-calendar"></i> {{ optional($user->birthday)->format('d M, Y') }}</li>@endif
            <li><i class="fa fa-briefcase"></i> {{ $user->work }} at <span>{{ ucfirst(strtolower($user->workplace)) }}</span></li>
        </ul>   
    </div>
</div>
<script>
    (function($){})
</script>