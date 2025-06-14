@extends('layouts.dash')
@section('css')
@endsection
@section('content')

<style>
	.vcontainer {
  position: relative;
  overflow: hidden;
  width: 100%;
  padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
}

/* Then style the iframe to fit in the container div with full height and width */
.vresponsive-iframe {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
}
</style>
<div>
	<div class="header header-fixed header-logo-app header-transparent">
		<a href="#" class="header-icon header-icon-1 color-white" data-menu="menu-agwiki"><i class="fas fa-bars"></i></a>
		<span class="header-title color-white"></span>
	</div>
	<div class="page-content-black"></div>
	<div>
		<div class="bg-black">
			<div data-height="cover" class="caption" style="margin-bottom: -30px">
				<div class="caption-center">
					<h1 class="brand"><img class="home" src="/assets/front/img//logo_white.png" alt="AgWiki Home Page"/></h1>
					<p class="boxed-text-large color-white opacity-80">
						We are a global community of farmers, ranchers, researchers, and nutritionists working together to solve world food problems socially.
					</p>
					<p class="boxed-text-large color-white opacity-80">
						
					</p>
					<p class="center-text color-white bottom-20">
						<a href="#" class="button button-primary button-l shadow-large right-20" data-menu="menu-signup-login">Sign Up</a>
						<a href="#" class="button button-next button-l shadow-large" data-menu="menu-signin">Login</a>
					</p>
				</div>
				
				<div class="caption-overlay bg-black opacity-70"></div>
				<div class="caption-bg" style="background-image:url(/assets/front/img//pictures/07t.jpg)"></div>
			</div>
			
			<p class="boxed-text-large color-white opacity-80" >
					<div class="container-fluid" style="background-color: #ffffff">
						
							<div class="row">
								<div class="col-md-2"></div>
									<div class="col-md-10">
														<div class="container-fluid" >
				
														<div class="row" style="color:#000000; background-color:#ffffff; padding:75px 5px">

															<div class="col-md-5" style="max-height: 300px">
																<p align="center">
																	<div class="vcontainer" >
																		<iframe class="vresponsive-iframe" width="560" height="315" src="https://www.youtube.com/embed/oeTRadyP3zc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
																	</div>
																</p>
															</div>

															<style>
															
																.flex-center-vertically {
																	  display: flex;
																	  justify-content: center;
																	  flex-direction: column;
																	  height: 300px;
																	}
															</style>

															<div class="col-md-5" >
																<div class="flex-center-vertically">
																<h1 style="font-size: 1.9em;">A Messsage From Our CEO</h1>
																<p>AgWiki is a startup the is currently working to gain investors. If you wish to learn more, contact us at <a href="mailto:investor@agwiki.com">investor@agwiki.com</a> </p>
																<p><a target="_blank" href="https://go.agwiki.com">Learn more about AgWiki >></a></p>
																</div>
															</div>


														</div>


														
														</div>
										</div>
										<div class="col-md-2"></div>
								</div>
						
			
									<div class="row" style="background-color: #eeeeee; ">
									<div class="col-md-1"></div>
									<div class="col-md-10">
			
						
			
														<div class="row" style="background-color: #eeeeee; padding:43px 5px 0px">
															<div class="col-md-1">
															</div>
															
															<div class="col-md-10">
																<center><h2 style="color: black; font-size: 32px ">What Others Are Saying About AgWiki</h2></center>
															</div>
															<div class="col-md-1">
															</div>
														</div>

														<div class="row" style="background-color: #eeeeee; padding:50px 5px 0px ">
															<div class="col-md-2">
															</div>
															<div class="col-md-4">
																<p align="center">
																	<div class="vcontainer">
																		<iframe class="vresponsive-iframe" stlye="display:block" width="560" height="315" src="https://www.youtube.com/embed/VwCdThYAScU" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
																		
																	</div>
																</p>
															</div>
															
															

															<div class="col-md-4">

																<p align="center">
																	<div class="vcontainer">
																		<iframe class="vresponsive-iframe" width="560" height="315" src="https://www.youtube.com/embed/THcLzDfRZU0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
																		
																	</div>
																</p>
															</div>
															<div class="col-md-2">
															</div>
															
														</div>
										</div>
										<div class="col-md-1"></div>
										</div>
			
			
							</div>
						
					</p>
			
		</div>
	</div>
	<div class="menu-hider"></div>
</div>

<!-- Forgot Password Form -->
<div id="menu-forgot" class="menu menu-box-bottom" data-menu-height="230" data-menu-effect="menu-over">
	<div class="content">
    	<form method="POST" action="{{ route('forgot.pass') }}">
                    @csrf
		<h2 class="uppercase ultrabold top-20">Forgot Password?</h2>
		<p class="font-11 under-heading bottom-20">
			Let's get you back into your account. Enter your email to reset.
		</p>
		<div class="input-style has-icon input-style-1 input-required bottom-30">
			<span>Email</span>
			<em>(required)</em>
			<input type="email" name="email" placeholder="Email">
		</div>

		<input type="submit" class="button button-full button-m shadow-large button-round-small bg-blue1-dark top-20" value="SEND RECOVERY EMAIL">
        </form>
	</div>
</div>

<!-- Sign In Form -->
<div id="menu-signin" class="menu menu-box-bottom" data-menu-height="500" data-menu-effect="menu-over">
	<div class="content">
		<h1 class="uppercase ultrabold top-20">LOGIN</h1>
		<p class="font-11 under-heading bottom-20">
			Hello, stranger! Please enter your credentials below.
		</p>

		<form method="POST" action="{{ route('login') }}">
			@csrf
			<!-- Email Input -->
			<div class="input-style has-icon input-style-1 input-required">
				<i class="input-icon fa fa-at"></i>
				<span>Email</span>
				<em>(required)</em>
				<input type="email" id="loginEmail" name="username" placeholder="Email" value="{{ old('username') }}" required>
			</div>

			<!-- Password Input -->
			<div class="input-style has-icon input-style-1 input-required">
				<i class="input-icon fa fa-lock font-11"></i>
				<span>Password</span>
				<em>(required)</em>
				<input type="password" id="loginPassword" name="password" placeholder="Password" required>
			</div>

			<!-- Show Password Checkbox -->
			<div class="top-10">
				<input type="checkbox" id="showLoginPasswordCheckbox" onclick="showLoginPassword()"> Show Password
			</div>

			<div class="top-30">
				<div class="one-half">
					<a href="#" data-menu="menu-forgot" class="left-text font-10">Forgot Password?</a>
				</div>
				<div class="one-half last-column">
					<a data-menu="menu-signup-login" href="#" class="right-text font-10">Create Account</a>
				</div>
			</div>

			<div class="clear"></div>

			<!-- Login Button -->
			<button type="submit" class="button button-full button-s shadow-large button-round-small bg-green1-dark top-10">LOGIN</button>

			<div class="divider"></div>
		</form>

		<!-- Social Login Buttons -->
		<a href="{{ url('/login/linkedin') }}" class="button bg-linkedin button-l shadow-large button-icon-left">
			<i class="fab fa-linkedin-in"></i> Log In With LinkedIn
		</a>
		<br>
		<a href="{{ url('/login/facebook') }}" class="button bg-facebook button-l shadow-large button-icon-left">
			<i class="fab fa-facebook-f"></i> Log In With Facebook
		</a>
		<br>
	</div>
</div>

<!-- Registration Form for Login Page (with unique IDs to avoid conflicts with sidebar) -->
<div id="menu-signup-login" class="menu menu-box-bottom register-login-blade-php" data-menu-height="92%" data-menu-effect="menu-parallax">
	<div class="content">
		<h1 class="uppercase ultrabold top-20">Register</h1>
		<p class="font-11 under-heading bottom-20">
			Don't have an account? Register below.
		</p>
		<form method="POST" id="regFormLogin" action="{{ route('register') }}">
			@csrf
			<input style="display: none" name="field_name" type="text">
			@if(isset($user))
			<input type="hidden" name="referral" value="{{ $user->id }}">
			@endif
			<div class="input-style input-style-1 input-required login">
				<span>Email</span>
				<em>(required)</em>
				<input class="form-control" type="email" name="email" id="regEmailLogin" placeholder="Email" value="{{ old('email') }}" required>
			</div>
			
			<div class="input-style input-style-1 input-required login">
				<span>Password</span>
				<em>(required)</em>
				<input class="form-control" type="password" name="password" id="regPasswordLogin" placeholder="Password" value="{{ old('password') }}" required>
			</div>
			
			<label for="tapLogin" class="control-label">
				<input type="checkbox" name="tap" id="tapLogin" value="1" required=""> Agree With <a href="/tap">Terms And Policy</a>
			</label>
			
			<div class="top-20 bottom-20">
				<a href="#" data-menu="menu-signin" class="center-text font-11 color-gray2-dark">Already Registered? Sign In Here.</a>
			</div>
			<div class="clear"></div>
			
			<button type="submit" class="button button-full button-s shadow-large button-round-small bg-blue2-dark top-10" style="width:100%">Register</button>
			<div class="clear"></div>
		</form>
		<div class="divider"></div>
		<a href="{{ url('/login/linkedin') }}" class="button bg-linkedin button-l shadow-large button-icon-left"><i class="fab fa-linkedin-in"></i> Log In With LinkedIn</a><br>
		<a href="{{ url('/login/facebook') }}" class="button bg-facebook button-l shadow-large button-icon-left"><i class="fab fa-facebook-f"></i> Log In With Facebook</a><br>
	</div>
</div>

<!-- Welcome Screen -->
<div id="welcome-screen" class="menu menu-box-bottom" data-menu-height="70%" data-menu-effect="menu-parallax">
	<div class="content">
		<h1 class="uppercase ultrabold top-20">Welcome!</h1>
		<p class="under-heading top-20">
			We have forwarded a link to your email that will take you to your <strong>new profile page</strong>.
		</p>
		<p>
			Once your profile is complete, we will be able to approve your new account.
		</p>
		<p>
			See you soon,<br>
			Team AgWiki
		</p>
		<div class="clear"></div>
	</div>
</div>

<!-- Menu -->
<div id="menu-agwiki" class="menu menu-box-left" data-menu-width="300" data-menu-effect="menu-parallax">
	<div class="nav nav-medium">
	    <a id="page-home" href="https://go.agwiki.com/#features" >
	        <i class="fas fa-globe-africa color-green1-dark"></i><span>About AgWiki</span><i class="fa fa-angle-right"></i>
	    </a>
	    <a id="page-components" href="https://go.agwiki.com/#leaders">
	        <i class="fas fa-users color-blue2-dark"></i><span>Thought Leaders</span><i class="fa fa-angle-right"></i>
	    </a>
	    <br>
		<div class="divider"></div>
	    <a id="page-menus" href="https://go.agwiki.com/contact" >
	        <i class="fab fa-youtube color-red1-dark"></i><span>Media</span><i class="fa fa-angle-right"></i>
	    </a>
	    <a id="page-site-pages" href="https://go.agwiki.com/contact#sponsor" >
	        <i class="fas fa-file-invoice-dollar color-mint-dark"></i><span>Advertise</span><i class="fa fa-angle-right"></i>
	    </a>
	    <a id="page-pageapps" href="https://go.agwiki.com/contact#sponsor" >
	        <i class="far fa-handshake color-dark1-dark"></i><span>Partners</span><i class="fa fa-angle-right"></i>
	    </a>
	    <a id="page-contact" href="https://go.agwiki.com/contact" >
	        <i class="fa fa-envelope color-blue2-dark"></i><span>Contact</span><i class="fa fa-angle-right"></i>
	    </a>

	    <div class="divider top-15"></div>
	    <p>Copyright <span class="copyright-year"></span> - AgWiki <?php echo date('Y'); ?>. All rights Reserved.</p>
	</div>
</div>
@endsection

@section('js')
<script src="https://cdn.plyr.io/3.3.10/plyr.js"></script>
<script>
	const player = new Plyr('#player');
	
	function showLoginPassword() {
		var passwordField = document.getElementById("loginPassword");
		var checkbox = document.getElementById("showLoginPasswordCheckbox");

		// Toggle password visibility
		if (checkbox.checked) {
			passwordField.type = "text";
		} else {
			passwordField.type = "password";
		}
	}
	
	$(document).ready(function(){
		// Form validation for login registration form
		$('#regFormLogin').on('submit', function(e) {
			var email = $('#regEmailLogin').val();
			var password = $('#regPasswordLogin').val();
			var terms = $('#tapLogin').is(':checked');
			
			if (!email || !password || !terms) {
				e.preventDefault();
				alert('Please fill in all required fields and agree to terms.');
				return false;
			}
		});
	});
</script>
@endsection