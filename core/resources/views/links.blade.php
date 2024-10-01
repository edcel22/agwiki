@extends('layouts.user')

@section('content')
    <div class="clearfix"></div>
     <div class="sidebar-area">
                        <ul>
                            <li><a href="{{ route('profile', Auth::user()->username) }}">
                                
                                <div class="single-mobile-menu-lists">
                                    <div class="thumb"><img src="{{ asset('assets/front/img/' . Auth::user()->avatar) }}"/></div>
                                    <div class="content">
                                        <h4 class="title">Profile</h4>
                                    </div>
                                <div>
                                
                                </a></li>
                            <li><a href="{{ route('user.invite') }}">
                                <div class="single-mobile-menu-lists">
                                    <div class="thumb"><i class="material-icons">
insert_invitation
</i></div>
                                    <div class="content">
                                        <h4 class="title">Invite</h4>
                                    </div>
                                <div>
                                
                                
                                </a></li>
                            <li><a href="{{ route('user.groups') }}">
                                <div class="single-mobile-menu-lists">
                                    <div class="thumb"><i class="material-icons">
group
</i></div>
                                    <div class="content">
                                        <h4 class="title">Groups</h4>
                                    </div>
                                </div>
                                    
                                    
                                    
                                    </a></li>
                            <li><a href="{{ route('user.password.change') }}">
                                    <div class="single-mobile-menu-lists">
                                        <div class="thumb"><i class="material-icons">
                                                key
                                            </i></div>
                                        <div class="content">
                                            <h4 class="title">Password Change</h4>
                                        </div>
                                    </div>



                                </a></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <div class="single-mobile-menu-lists">
                                    <div class="thumb"><i class="fa fa-sign-out" aria-hidden="true"></i></div>
                                    <div class="content">
                                        <h4 class="title">Logout</h4>
                                    </div>
                                <div>

                                
                                
                                </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
@endsection