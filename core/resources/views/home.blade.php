@extends('layouts.dash')
@section('content')
@php


$theUser = ''; 



if (Auth::check()) {
    $theUser = Auth::user();
} else {
    $theUser = $user;  
}
                           if(isset($theUser->id))
                           {
                            $count=App\User::StaticunreadMessageCount($theUser->id);
                            //$messages=App\User::StaticunreadMessages($theUser->id);
                            //$notifications = App\User::StaticgetLatestNotifications($theUser->id);
                            $countN = App\User::StaticunreadNotificationsCount($theUser->id);
                            //die(print_r($notifications));
                           // $messages=array_merge($messages, $notifications);
                           }
                        @endphp

<div class="home">

	<div >

        <div data-height="cover" class="caption bottom-0" style="min-height:730px;">

            <div class="caption-center">

                <div class="landing-page">

                    <div class="landing-header">
                        <a href="/"><img src="/assets/front/img/logo_md.png" alt="img"></a>
                    </div>

                    <div class="landing-icons color-theme">

                      <a href="/feed">
                        <i class="bg-blue2-light shadow-icon-large far fa-newspaper"></i>
                        <em class="color-theme">Feed</em>
                      </a>

                      @if (Auth::check())
                        <a href="/interests">
                        @else
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-green1-dark shadow-icon-large far fa-file-alt"></i>
                        <em class="color-theme">Topics</em>
                      </a>

                      @if (Auth::check())
                        <a href="/groups">
                        @else    
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-yellow2-dark shadow-icon-large fas fa-users"></i>
                        <em class="color-theme">Groups</em>
                      </a>

                      @if( Auth::check())
                        <a href="/profile/{{ Auth::user()->username }}">
                        
                        @else <a onclick= "return registerPopup()">@endif
                        <i class="bg-dark2-dark shadow-icon-large fas fa-user-alt"></i>
                        <em class="color-theme">Profile</em>
                      </a>

                      @if (Auth::check())
                            <a href="/feed?fav=1" >
                        @else
                            <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-yellow1-light shadow-icon-large fas fa-star"></i>
                        <em class="color-theme">Bookmarks</em>
                      </a>

                      @if (Auth::check())
                        <a href="/peoples">
                        @else 
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-orange-light shadow-icon-large fas fa-user-check"></i>
                        <em class="color-theme">People</em>
                      </a>

                      @if (Auth::check())
                        <a href="/commodities" >
                        @else
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-mint-light shadow-icon-large far fa-chart-bar"></i>
                        <!--n class="badge">new!</span>-->
                        <em class="color-theme">Commodities</em>
                      </a>
<!--
                      <a href="#" data-menu="menu-warning">
            						<i class="bg-white shadow-icon-large fas fa-briefcase-medical" style="color:red"></i>
            						<em class="color-theme">Support</em>
            					</a>

                      <a href="/marketplace" class="inactive">
                        <i class="bg-orange-dark shadow-icon-large fas fa-store"></i>
                        <em class="color-theme">Marketplace</em>
                      </a>-->

                      @if (Auth::check())
                        <a href="/weather">
                        @else
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-blue1-light shadow-icon-large fas fa-sun"></i>
                        
                        <em class="color-theme">Weather</em>
                      </a>

                      @if (Auth::check())
                        <a href="#" data-menu="menu-alerts">
                            <i class="bg-gradient-red1 shadow-icon-large fas fa-bell"></i>
                            @if($countN>0)<span class="badge">{{$countN}}</span>@endif
                            <em class="color-theme">Alerts</em>
                        </a>
                        @else
                        <a onclick= "return registerPopup()">
                            <i class="bg-gradient-red1 shadow-icon-large fas fa-bell"></i>
                            <em class="color-theme">Alerts</em>
                        </a>
                        @endif

                        @if (Auth::check())
                        <a href="#" data-menu="menu-messages">
                                <i class="bg-gradient-blue2 shadow-icon-large fas fa-envelope"></i>
                                @if (isset($count))
                                @if($count>0)<span class="badge">{{$count}}</span>@endif
                                @endif
                                <em class="color-theme">Messages</em>
                        </a>
                        @else 
                        <a onclick= "return registerPopup()">
                            <i class="bg-gradient-blue2 shadow-icon-large fas fa-envelope"></i>
                            <em class="color-theme">Messages</em>
                        </a>
                        @endif

						<a href="https://go.agwiki.com/#features" target="_blank">
							<i class="bg-purple shadow-icon-large fas fa-info-circle"></i>
							 <em class="color-theme">About</em>
						</a>
						
						<a href="https://education.agwiki.com/" target="_blank">
						<i class="bg-green1-dark shadow-icon-large fas fa-laptop-code"></i>
						 <em class="color-theme">Education</em>
						</a>
                      
                      
                    
                        <div class="padding-10 clear" >
                
                            <a style="width:100%; text-align:center" class="btn btn-success button button-m button-round-small bg-blue1-dark shadow-small" href="mailto:?subject=<?php echo rawurlencode(htmlspecialchars_decode("I'd like to share this site with you"));?>&body=<?php echo rawurlencode(htmlspecialchars_decode("Please join AgWiki.com.  Together we can solve the world's food problems."));?>">Invite Friends</a>
                        
                        </div>
                    
                    



                      <div class="clear"></div>
                      
                      

                    </div>

                    <div class="landing-footer">
                        <span class="center-text color-theme font-10 opacity-40">Copyright <span class="copyright-year"></span> AgWiki. All rights Reserved</span>
                    </div>

                </div>

            </div>



        </div>



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



<div class="menu-hider"></div>











@endsection
