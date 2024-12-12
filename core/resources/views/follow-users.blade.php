@extends('layouts.profile')

@section('css')
<style>
    .pagi ul.pagination {
        display: block !important;
        text-align: center;
    }
</style>
@endsection

@section('content')
    <div class="post-loop-wrapper">
        @if($users && count($users))
            <div class="post-loop-inner">
                <div class="top-author-list">
                    <h4 class="title">{{ $page_title }}</h4>

                        <ul>
                            @foreach($users as $usero)
                                <li>
                                    <div class="single-top-author">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/front/img/' . $usero->avatar) }}" alt="{{ $usero->name }}">
                                        </div>
                                        @auth
                                        <div class="content">
                                            <a @if(! $usero->isBlockedByMe(Auth::user()->id)) href="{{ route('profile', $usero->username) }}" @endif class="nam">{{ $usero->name }} @if($usero->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif</a>
                                            @if(! $usero->isFollowedMe())
                                            <a onclick="event.preventDefault();
                                                    document.getElementById('follow-form-{{ $usero->id }}').submit();" style="cursor: pointer;" class="follow-btn" title="Follow" data-toggle="tooltip"><i class="fa fa-user-plus"></i></a>
                                            <form action="{{ route('user.follow', $usero->username) }}" id="follow-form-{{ $usero->id }}" method="post" style="display: none;">
                                                @csrf
                                            </form>
                                            @endif
                                            @if(! $usero->isBlockedByMe(Auth::user()->id) && $usero->isFriend()) <a href="{{ route('message', $usero->username) }}" class="follow-btn" title="Message" data-toggle="tooltip"><i class="fa fa-comments"></i></a>@endif
                                            <a style="cursor: pointer;" onclick="event.preventDefault();
                                                    document.getElementById('block-form-{{ $usero->id }}').submit();" class="follow-btn" title="@if(Auth::user()->isBlockedByMe($usero->id))Unclock @else Block @endif" data-toggle="tooltip">@if(Auth::user()->isBlockedByMe($usero->id))<i class="fa fa-check-circle-o"></i> @else <i class="fa fa-ban"></i> @endif </a>
                                            <form action="{{ route('user.block', $usero->username) }}" id="block-form-{{ $usero->id }}" method="post" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                        @endauth
                                        @guest
                                        <div class="content">
                                            <a href="{{ route('profile', $usero->username) }}" class="nam">{{ $usero->name }} @if($usero->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif</a>
                                        </div>
                                        @endguest
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="pagi">
                            {{ $records->links() }}
                        </div>
                </div>
            </div>
        @else
            <div class="col-md-12 single text-center">No User Found.</div>
        @endif
    </div>
@endsection