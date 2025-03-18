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

                    <div class="landing-icons color-theme" style="
                    display: flex;
                    flex-direction: row;
                    flex-wrap: wrap;
                ">

                      <a href="/feed">
                        <i class="shadow-icon-large far fa-newspaper" style="background: #66C2E0; !important;"></i>
                        <em class="color-theme">Feed</em>
                      </a>

                      @if(Auth::check())
                        <a href="/interests" style="
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                      ">
                        @else
                        <a onclick="return registerPopup()" style="
                          display: flex;
                          justify-content: center;
                          align-items: center;
                          flex-direction: column;
                        ">
                        @endif
                            <div style="
                              padding: 10px;
                              background: #7ED957;
                              border-radius: 10px;
                              box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
                            ">
                              <img src="{{ asset('assets/img/agwiki-topics-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
                            </div>
                            <em class="color-theme">Topics</em>
                        </a>

                      @if (Auth::check())
                        <a href="/groups">
                          @else    
                          <a onclick= "return registerPopup()">
                          @endif
                          <i class="shadow-icon-large fas fa-users" style="background: #D2AC47; !important;"></i>
                          <em class="color-theme">Groups</em>
                        </a>

                      @if( Auth::check())
                        <a href="/profile/{{ Auth::user()->username }}">
                        
                        @else <a onclick= "return registerPopup()">@endif
                        <i class="bg-dark2-dark shadow-icon-large fas fa-user-alt" style="background: #66B4AF; !important;"></i>
                        <em class="color-theme">Profile</em>
                      </a>

                      @if (Auth::check())
                            <a href="/feed?fav=1" style="
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex-direction: column;
                          ">
                        @else
                        <a onclick="return registerPopup()" style="
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                       ">
                       @endif
                        <div style="
                          padding: 10px;
                          background: #FFDB84;
                          border-radius: 10px;
                          box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
                        ">
                          <img src="{{ asset('assets/img/agwiki-bookmarks-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
                        </div>
                        <em class="color-theme">Bookmarks</em>
                      </a>

                      @if (Auth::check())
                        <a href="/peoples" style="
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                      ">
                        @else 
                        <a onclick="return registerPopup()" style="
                          display: flex;
                          justify-content: center;
                          align-items: center;
                          flex-direction: column;
                        ">
                        @endif
                          <div style="
                              padding: 10px;
                              background: #FC6E51;
                              border-radius: 10px;
                              box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
                          ">
                              <img src="{{ asset('assets/img/agwiki-people-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
                          </div>
                        <em class="color-theme">People</em>
                      </a>

                      {{-- @if (Auth::check())
                        <a href="/commodities" >
                        @else
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-mint-light shadow-icon-large far fa-chart-bar"></i>
                        <!--n class="badge">new!</span>-->
                        <em class="color-theme">Commodities</em>
                      </a> --}}
<!--
                      <a href="#" data-menu="menu-warning">
            						<i class="bg-white shadow-icon-large fas fa-briefcase-medical" style="color:red"></i>
            						<em class="color-theme">Support</em>
            					</a>

                      <a href="/marketplace" class="inactive">
                        <i class="bg-orange-dark shadow-icon-large fas fa-store"></i>
                        <em class="color-theme">Marketplace</em>
                      </a>-->

                      {{-- @if (Auth::check())
                        <a href="/weather">
                        @else
                        <a onclick= "return registerPopup()">
                        @endif
                        <i class="bg-blue1-light shadow-icon-large fas fa-sun"></i>
                        
                        <em class="color-theme">Weather</em>
                      </a> --}}

                      @if (Auth::check())
                      <a href="#" data-menu="menu-alerts" style="
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      flex-direction: column;
                    ">
                        <div style="
                        padding: 10px;
                        background: #E3514C;
                        border-radius: 10px;
                        box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
                    ">
                        <img src="{{ asset('assets/img/agwiki-alerts-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
                    </div>
                            @if($countN>0)<span class="badge">{{$countN}}</span>@endif
                            <em class="color-theme">Alerts</em>
                        </a>
                        @else
                        <a onclick="return registerPopup()" style="
																	display: flex;
																	justify-content: center;
																	align-items: center;
																	flex-direction: column;
																">
																	<div style="
																			padding: 10px;
																			background: #E3514C;
																			border-radius: 10px;
																			box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
																	">
																			<img src="{{ asset('assets/img/agwiki-alerts-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
																	</div>
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
                        <a onclick="return registerPopup()" style="
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-direction: column;
                      ">
                      @endif
                        <div style="
                            padding: 10px;
                            background: #5CE1E6;
                            border-radius: 10px;
                            box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
                        ">
                            <img src="{{ asset('assets/img/agwiki-messages-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
                        </div>
                            <em class="color-theme">Messages</em>
                        </a>
                        @endif

						<a href="https://go.agwiki.com/#features" target="_blank">
							<i class="bg-purple shadow-icon-large fas fa-info-circle"></i>
							 <em class="color-theme">About</em>
						</a>
						
						<a href="https://go.agwiki.com/agwiki-education/" 
              style="
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
              "
              target="_blank">
              <div style="
                  padding: 10px;
                  background: #66E0A3;
                  border-radius: 10px;
                  box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
              ">
                  <img src="{{ asset('assets/img/agwiki-education-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
              </div>
                <em class="color-theme">Education</em>
              </a>
                      
              <a href="https://go.agwiki.com/advertise/" 
              style="
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
              "
              target="_blank">
              <div style="
                  padding: 10px;
                  background: #C2CF5F;
                  border-radius: 10px;
                  box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
              ">
                  <img src="{{ asset('assets/img/agwiki-ads-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
              </div>
                <em class="color-theme">Advertise</em>
              </a>
              <a href="https://go.agwiki.com/become-a-thought-leader/" 
              style="
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
						  	margin-bottom: 14px;
              "
              target="_blank">
              <div style="
                  padding: 10px;
                  background: #CB6CE6;
                  border-radius: 10px;
                  box-shadow: 0px 0px 5px 2px rgba(0,0,0,0.2);
              ">
                  <img src="{{ asset('assets/img/agwiki-thought-leader-icon.svg') }}" alt="Topics Icon" style="height: 22px; width: 22px;">
              </div>
                <em class="color-theme">BECOME A THOUGHT LEADER</em>
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
