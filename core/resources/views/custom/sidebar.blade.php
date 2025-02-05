

@php 
    $theUser = ''; 
		$loggedIn = false;
@endphp

@php
    if (Auth::check()) {
        $theUser = Auth::user();
				$loggedIn = true;
    } else {
        $theUser = $user;  
    }
@endphp



@php

                           if(isset(Auth::user()->id))

                           {

                            $count=App\User::StaticunreadMessageCount(Auth::user()->id);

                            //$messages=App\User::StaticunreadMessages(Auth::user()->id);



                            //$notifications = App\User::StaticgetLatestNotifications(Auth::user()->id);

                            $countN = App\User::StaticunreadNotificationsCount(Auth::user()->id);

                            //die(print_r($notifications));

                           // $messages=array_merge($messages, $notifications);



                           //$count = $count+$countN;

                           }

@endphp


<?php
	$sidebarClass = "sidebar shadow-medium";
	if (!$loggedIn) {
		$sidebarClass .= ' sidebar-loggedout';
	}
?>


<div class="<?= $sidebarClass; ?>">

        <div data-height="cover" class="caption bottom-0" id="innerSidebar" >

            <div class="top-30">

				<div class="landing-header">
					@if($loggedIn)
						<a href="/"><img src="/assets/front/img/logo_md.png" alt="AgWiki, Solving World Food Problems Socially"></a>
					@endif

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

                    {{-- @if (Auth::check())
					<a href="/commodities" >
                    @else
                    <a onclick= "return registerPopup()">
                    @endif
						<!--<span class="badge">new!</span>-->
						<i class="bg-mint-light shadow-icon-large far fa-chart-bar"></i>
						<em class="color-theme">Commodities</em>
					</a>  --}}

                    {{-- @if (Auth::check())
                    <a href="/weather">
                    @else
                    <a onclick= "return registerPopup()">
                    @endif
						<i class="bg-blue1-light shadow-icon-large fas fa-sun"></i>
                        <em class="color-theme">Weather</em>
					</a> --}}

          <!-- <a href="/marketplace" class="inactive">
            <i class="bg-orange-dark shadow-icon-large fas fa-store"></i>
            <em class="color-theme">Marketplace</em>
          </a> -->
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
					<!-- <a href="#" data-menu="menu-warning">
						<i class="bg-white shadow-icon-large fas fa-briefcase-medical" style="color:red"></i>
						<em class="color-theme">Support</em>
					</a> -->
					<a href="https://education.agwiki.com/" target="_blank">
						<i class="bg-green1-dark shadow-icon-large fas fa-laptop-code"></i>
						 <em class="color-theme">Education</em>
					</a>


				</div>
                <div class="padding-10 clear" >
                
                	<a href="mailto:?subject=<?php echo rawurlencode(htmlspecialchars_decode("I'd like to share this site with you"));?>&body=<?php echo rawurlencode(htmlspecialchars_decode("Please join AgWiki.com.  Together we can solve the world's food problems."));?>" style="width:100%; text-align:center" class="btn btn-success button button-m button-round-small bg-blue1-dark shadow-small" >Invite Friends</a>
                
					
                </div>

				<div class="padding-10 clear" >
				@if(Auth::check())
					<h4>People to Follow</h4>
                    @if($topAuthors && count($topAuthors))
                    	@foreach($topAuthors as $usero)
                            @if($usero->id != $theUser->id && ! $usero->isFollowedMe() && ! $usero->isBlockedByMe($theUser->id))
                            <div class="one-half center-text" >
                                <a href="/profile/{{ $usero->username }}" class="user shadow-small">
                                    <img alt="{{ $usero->name }}" title="{{ $usero->name }}" src="{{ asset('assets/front/img/' . $usero->avatar) }}">
                                </a>
                                <a href="/profile/{{ $usero->username }}">
									<div class="username">{{ $usero->name }}</div>
									<div class="role">@if(isset($usero->workplace)){{ $usero->job($usero->id)['name']}}@endif</div>
									<div class="location">@if($usero->city){{ $usero->city }}, {{ $usero->state }}@endif</div>
								</a>
                   
                            </div>
				            @endif
                        @endforeach
                    @endif
                    @endif

					<div class="clear center-text">
						<button onClick="location.reload(); " type="submit" class=" top-30 button button-m button-round-small bg-blue2-dark shadow-small">
							Refresh <i class="fas fa-spinner"></i>
						</button>
					</div>
				</div>
				<div class="divider divider-margins"></div>
				<div class="landing-footer">
					<div class="site-footer">
                    <p><a href="/privacy/">Privacy</a> | <a href="/terms/">Terms</a></p>
                    <p>Copyright © <?php echo date('Y');?> AgWiki Inc.</p>
                    </div>
				</div>
				<br><br><br>
			</div>
		</div>
</div>






<div id="menu-signup" class="menu menu-box-bottom menu-chr" data-menu-height="92%" data-menu-effect="menu-parallax">
	<div class="content">
		<h1 class="uppercase ultrabold top-20">Register</h1>
		<p class="font-11 under-heading bottom-20">
			Don't have an account? Register below.
		</p>
		<form method="POST" id="regForm" action="{{ route('register') }}">
			@csrf
			<input style="display: none" name="field_name" type="text">
			@if(isset($user))
			<input type="hidden" name="referral" value="{{ $user->id }}">
			@endif
			<div class="input-style input-style-1 input-required login">
				<span>Email</span>
				<em>(required)</em>
				<input class="form-control" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
			</div>
			
			<div class="input-style input-style-1 input-required login">
				<span>Password</span>
				<em>(required)</em>
				<input class="form-control" type="password" name="password" id="password" placeholder="Password" value="{{ old('password') }}" required>
			</div>
			
			
				<label for="tap" class="control-label">
					<input type="checkbox" name="tap" id="tap" value="1" required=""> Agree With <a href="/tap">Terms And Policy</a></label>
			
			<div class="top-20 bottom-20">
				<a href="#" data-menu="menu-signin" class="center-text font-11 color-gray2-dark">Already Registered? Sign In Here.</a>
			</div>
			<div class="clear"></div>
			<!--id="ajaxSubmit" -->
            <!--data-menu="welcome-screen"-->
            <button  type="submit" data-sitekey="6Le_qGcqAAAAAKIVN2YKP-gtlPlw0I2J81IlruLx" data-callback='onSubmit' data-action='submit'   class="g-recaptcha button button-full button-s shadow-large button-round-small bg-blue2-dark top-10" style="width:100%">Register</button>
			<div class="clear"></div>
		</form>
		<div class="divider"></div>
		<div class="soc-login">
			<a href="{{ url('/login/linkedin') }}" class="button bg-linkedin button-l shadow-large button-icon-left"><i class="fab fa-linkedin-in"></i> Log In With LinkedIn</a>
			<a href="{{ url('/login/facebook') }}" class="button bg-facebook button-l shadow-large button-icon-left"><i class="fab fa-facebook-f"></i> Log In With Facebook</a>
		</div>
	</div>
</div>

<style>
	#menu-signup.menu-chr.menu-active,
	#menu-signin.menu-chr.menu-active {
		display: block;
		width: 100%;
		max-width: 80%;
		height: 100%;
		top: 11%;
		left: 10%;
		max-height: fit-content;
		border-radius: 20px;
		overflow: hidden;
	}

	#menu-signup.menu-chr .soc-login,
	#menu-signin.menu-chr .soc-login {
		display: flex;
		justify-content: center;
	}
	#menu-signup.menu-chr .soc-login .button,
	#menu-signin.menu-chr .soc-login .button {
		margin: 0 10px;
	}

	@media (max-width: 500px) {
		#menu-signup.menu-chr.menu-active,
		#menu-signin.menu-chr.menu-active {
			width: 100%;
			max-width: 90%;
			top: 10%;
			left: 5%;
		}
		#menu-signup.menu-chr .soc-login,
		#menu-signin.menu-chr .soc-login {
			flex-direction: column;
		}
		#menu-signup.menu-chr .soc-login .button,
		#menu-signin.menu-chr .soc-login .button {
			margin: 0 10px;
			margin: 5px;
			font-size: 12px;
		}
	}
</style>
