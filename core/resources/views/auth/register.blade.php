@extends('layouts.auth')
@section('title', 'Register')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row content register">
	<form method="POST" action="{{ route('registeruser') }}" enctype="multipart/form-data">
	<div class="col-md-12 ">
		<div id="logo">
			<img src="/assets/front/img/logo_med.png">
		</div>
		<div class="col-md-12">
			<h3>Complete your profile...</h3>
		</div>
		<div class="col-md-12">
			<img src="/assets/front/img/male.png" alt="" class="img-responsive" id="avatar-cont">
			<div class="form-group crossposting-input">
				<label for="avatar" class="button button-s shadow-large bg-green2-dark top-10">Upload Profile Picture</label>
				<span class="help">Must be JPG image, no larger than 1.5MB or 1600x1600.</span>
				<input type="file" id="avatar" name="avatar" class="form-control" style="display: none;">
			</div>
		</div>
		<div class="divider divider-margins"></div>

			@csrf
			@if(isset($user))
			<input type="hidden" name="code" value="{{ $user->vercode }}">
            
			@endif
            <div class="col-md-12">
				<div class="form-group crossposting-input input-style-1">
					<label>Verify Email <span class="fieldRequired">*</span></label>
					<input type="text" value="{{ old('email') }}" class="form-control input-style-1" name="email" id="email" placeholder="Email" required autofocus>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group crossposting-input input-style-1">
					<label>First <span class="fieldRequired">*</span></label>
					<input type="text" class="form-control input-style-1" name="fname" id="fname" placeholder="First Name" value="{{ old('fname') }}" required autofocus>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group crossposting-input input-style-1">
					<label>Last <span class="fieldRequired">*</span></label>
					<input type="text" class="form-control input-style-1" name="lname" id="lname" placeholder="Last Name" value="{{ old('lname') }}" required autofocus>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group crossposting-input input-style-1">
					<label for="workplace">Industry / Profession <span class="fieldRequired">*</span></label>
					<select required aria-required="true" name="workplace" id="workplace">
						
						@foreach(App\User::jobs()->sortBy('name') as $jobID => $jobName)
						<option value="{{ $jobName->id }}">{{ $jobName->name }}</option>
						@endforeach
					</select>
                    <input type="hidden"  value="Male">
				</div>
			</div>
			<!--<div class="col-md-6">
				<div class="form-group crossposting-input input-style-1">
					<label>Gender</label>
					<select name="gender" id="gender" class="form-control input-style-1" required>
						<option value="Male"{{ (old('gender') == 'MALE')?' selected':''  }}>Male</option>
						<option value="Female"{{ (old('gender') == 'FEMALE')?' selected':''  }}>Female</option>
					</select>
				</div>
			</div>-->
			<div class="col-md-6">
				<div class="form-group crossposting-input input-style-1">
					<!-- https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete -->
					<label>Location <span class="fieldRequired">*</span></label>
					<input type="text" class="form-control input-style-1" name="location" id="pac-input" placeholder="Postal Code works best."  required autofocus />
					<style>
						#description {
						font-family: Roboto;
						font-size: 15px;
						font-weight: 300;
						}
						#infowindow-content .title {
						font-weight: bold;
						}
						#infowindow-content {
						display: none;
						}
						#map #infowindow-content {
						display: inline;
						}
						.pac-card {

						box-sizing: border-box;
						-moz-box-sizing: border-box;
						outline: none;
						box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
						background-color: #fff;
						font-family: Roboto;
						}
						#pac-container {
						padding-bottom: 12px;
						margin-right: 12px;
						}
						.pac-controls {
						display: inline-block;
						padding: 5px 11px;
						}
						.pac-controls label {
						font-family: Roboto;
						font-size: 13px;
						font-weight: 300;
						}
						#pac-input {
						background-color: #fff;
						font-family: Roboto;
						font-size: 15px;
						font-weight: 300;
						text-overflow: ellipsis;
						}
						#pac-input:focus {
						border-color: #4d90fe;
						}
						#title {
						color: #fff;
						background-color: #4d90fe;
						font-size: 25px;
						font-weight: 500;
						padding: 6px 12px;
						}
					</style>
					<div id="map"></div>
					<div id="infowindow-content">
						<img src="" width="16" height="16" id="place-icon">
						<span id="place-name"  class="title"></span><br>
						<span id="place-address"></span>
					</div>
					<script>
						// This example requires the Places library. Include the libraries=places

						// parameter when you first load the API. For example:

						// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">



						function initMap() {

						var map = new google.maps.Map(document.getElementById('map'), {

						 center: {lat: -33.8688, lng: 151.2195},

						 zoom: 13

						});

						var card = document.getElementById('pac-card');

						var input = document.getElementById('pac-input');

						var types = document.getElementById('type-selector');

						var strictBounds = document.getElementById('strict-bounds-selector');



						map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);



						var autocomplete = new google.maps.places.Autocomplete(input);



						// Bind the map's bounds (viewport) property to the autocomplete object,

						// so that the autocomplete requests use the current map bounds for the

						// bounds option in the request.

						autocomplete.bindTo('bounds', map);



						// Set the data fields to return when the user selects a place.

						autocomplete.setFields(

						['formatted_address','address_components', 'geometry', 'icon', 'name']);



						var infowindow = new google.maps.InfoWindow();

						var infowindowContent = document.getElementById('infowindow-content');

						infowindow.setContent(infowindowContent);

						var marker = new google.maps.Marker({

						 map: map,

						 anchorPoint: new google.maps.Point(0, -29)

						});



						autocomplete.addListener('place_changed', function() {

						// infowindow.close();

						 //marker.setVisible(false);

						 var place = autocomplete.getPlace();

						 if (!place.geometry) {

						// User entered the name of a Place that was not suggested and

						// pressed the Enter key, or the Place Details request failed.

						window.alert("No details available for input: '" + place.name + "'");

						return;

						 }



						 // If the place has a geometry, then present it on a map.

						 if (place.geometry.viewport) {

						map.fitBounds(place.geometry.viewport);

						 } else {

						map.setCenter(place.geometry.location);

						map.setZoom(17);  // Why 17? Because it looks good.

						 }

						 marker.setPosition(place.geometry.location);

						 marker.setVisible(true);



						 var address = '';

						 if (place.address_components) {

						address = [

						  (place.address_components[0] && place.address_components[0].short_name || ''),

						  (place.address_components[1] && place.address_components[1].short_name || ''),

						  (place.address_components[2] && place.address_components[2].short_name || '')

						].join(' ');







									//https://stackoverflow.com/questions/8082405/parsing-address-components-in-google-maps-upon-autocomplete-select

						var address_components = place.address_components;

						var components={};

						$.each(address_components, function(k,v1) {jQuery.each(v1.types, function(k2, v2){components[v2]=v1.short_name});});



						$('#zip').val(components.postal_code);

						$('#city').val(components.locality);

						$('#state').val(components.administrative_area_level_1);

						$('#country').val(components.country);





						$('#lat').val(place.geometry.location.lat);

						$('#lng').val(place.geometry.location.lng);



						console.log(place);
						//alert("selected - thank you!");
						
						
						

						 }



						 infowindowContent.children['place-icon'].src = place.icon;

						 infowindowContent.children['place-name'].textContent = place.name;

						 infowindowContent.children['place-address'].textContent = address;

						 infowindow.open(map, marker);

						});



						// Sets a listener on a radio button to change the filter type on Places

						// Autocomplete.

						function setupClickListener(id, types) {

						 /*var radioButton = document.getElementById(id);

						 radioButton.addEventListener('click', function() {

						autocomplete.setTypes(types);

						 });*/

						}



						setupClickListener('changetype-all', []);

						setupClickListener('changetype-address', ['address']);

						setupClickListener('changetype-establishment', ['establishment']);

						setupClickListener('changetype-geocode', ['geocode']);



						document.getElementById('use-strict-bounds')

						/*.addEventListener('click', function() {

						  console.log('Checkbox clicked! New state=' + this.checked);

						  autocomplete.setOptions({strictBounds: this.checked});

						});*/

						}

					</script>
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnpLwQWEjPKannY5dzSTknl8BPcZFa2Y0&libraries=places&callback=initMap" async defer></script>
				</div>
			</div>
			<div class="col-md-6" style="display: none" >
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="city" id="city" placeholder="city" value="{{ old('city') }}"  autofocus>
				</div>
			</div>
			<div class="col-md-6" style="display: none" >
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="state" id="state" placeholder="state" value="{{ old('state') }}"  autofocus>
				</div>
			</div>
			<div class="col-md-6" style="display: none" >
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="zip" id="zip" placeholder="zip" value="{{ old('zip')}}"  autofocus>
				</div>
			</div>
			<div class="col-md-6" style="display: none" >
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="country" id="country" placeholder="country" value="{{ old('country')}}"  autofocus>
				</div>
			</div>
			<div class="col-md-6" style="display: none" >
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="lat" id="lat" placeholder="lat" value="{{ old('lat')}}"  autofocus>
				</div>
			</div>
			<div class="col-md-6" style="display: none" >
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="lng" id="lng" placeholder="lng" value="{{ old('lng')}}"  autofocus><!--oninvalid="alert('You must choose an address from the Location dropdown');" required-->
				</div>
			</div>
			<div class="col-md-6">
				<label>Brief Bio</label>
				<div class="form-group crossposting-input input-style-1">
					<textarea type="text" class="form-control input-style-1" name="bio" id="bio" placeholder="Tell us a little about yourself..." value="{{ old('bio') }}"   ></textarea>
				</div>
			</div>
			<div class="divider divider-margins"></div>

			<div class="col-md-4">
				<label>Facebook Handle </label>
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="facebook" id="facebook" placeholder="(https://facebook.com/___?)" value="{{ old('facebook')}}"  autofocus>
				</div>
			</div>
			<div class="col-md-4">
				<label>Twitter Handle </label>
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="twitter" id="twitter" placeholder="(https://twitter.com/___?)" value="{{ old('twitter')}}"  autofocus>
				</div>
			</div>
			<div class="col-md-4">
				<label>LinkedIn Handle </label>
				<div class="form-group crossposting-input input-style-1">
					<input type="text" class="form-control input-style-1" name="linkedin" id="linkedin" placeholder="(https://linkedin.com/in/___?)" value="{{ old('linkedin')}}"  autofocus>
				</div>
			</div>
			<div class="divider divider-margins"></div>
			<div class="col-md-6">
				<label>Password <span class="fieldRequired">*</span> </label>
				<div class="form-group crossposting-input input-style-1">
					<input type="password" class="form-control input-style-1" name="password" id="password" placeholder="Password" required>
				</div>
			</div>
			<div class="col-md-6">
				<label>Confirm Password <span class="fieldRequired">*</span> </label>
				<div class="form-group crossposting-input input-style-1">
					<input type="password" class="form-control input-style-1" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
				</div>
			</div>
			<center><input type="checkbox" onclick="showPassword()"> Show Password</center>
			<div class="divider divider-margins"></div>
			<div class="col-md-12">
				<h2>Interests</h2>
				<div class="form-group form-check crossposting-input">
					@foreach($interest as $int)
					<div class="col-md-6 padding-5">
						<input type="checkbox" name="interest[]" id="interest{{$int->id}}" value="{{$int->id}}"> {{$int->name}}
					</div>
					@endforeach
				</div>
			</div>
			<div class="divider divider-margins"></div>
			<div class="col-md-12">
				<div class="form-group ">
					<div class="col-md-6">
						<label for="tap" class="control-label"><input type="checkbox" name="tap" id="tap" value="1" required> Agree With <a
						href="{{ route('tap') }}">Terms And Policy</a></label>
						<button type="submit" class="button button-full button-l shadow-large button-round-small bg-green1-dark top-10">Register</button>
					</div>
					<div class="col-md-6">
						<p>Already have an account? <a href="{{ route('login') }}" alt="Login">Login »</a></p>
					</div>
				</div>
			</div>
			<br>
		</form>
		<br>
	</div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets/front/js/chosen.jquery.js') }}"></script>
<script>
	$(function () {

	    $("#datepicker").datepicker({

	        autoclose: true,

	        todayHighlight: true,

	        format: 'mm-dd-yyyy'

	    }).datepicker('update', new Date());

	});





	$(document).on('change', '#avatar', function(e) {



	 if (this.files.length) {



	     var file = this.files[0];

	     var reader = new FileReader();



	     reader.onload = function(e) {

	         var data = e.target.result;



	         $('#avatar-cont').attr('src', data);

	     };



	     reader.readAsDataURL(file);



	 }



	});

</script>
<script>
	//const player = new Plyr('#player');
	function showPassword() {
	  var x = document.getElementById("password");
	  if (x.type === "password") {
		x.type = "text";
	  } else {
		x.type = "password";
	  }


		var x = document.getElementById("password_confirmation");
		  if (x.type === "password") {
			x.type = "text";
		  } else {
			x.type = "password";
		  }

	}
</script>
@endsection
