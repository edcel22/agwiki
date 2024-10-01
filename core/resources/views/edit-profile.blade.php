@extends('layouts.auth') @section('css')

<link rel="stylesheet" href="{{ asset('assets/front/twitter/chosen.css') }}"> @endsection @section('content')

<div class="single page-content">

    <div class="content">

        <h4 class="text-center">Edit Profile</h4>

        <form method="post" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-12">

                    <img src="{{ asset('assets/front/img/' . $user->avatar) }}" alt="{{ $user->name }}" class="profile-picture" id="avatar-cont">

                    <div class="form-group crossposting-input" style="text-align: center;">

                        <label for="avatar" class="button button-s shadow-large button-round-small bg-green1-dark top-10">Change Avatar</label>
                        <Br>
                        <button class="button button-s shadow-large button-round-small bg-blue1-dark top-10" type="submit">Update Avatar</button>

                        <input type="file" id="avatar" name="avatar" class="form-control" style="display: none;">



                    </div>


                </div>

            </div>

            <!--<div class="row">

				<div class="col-md-12">

					<img src="{{ asset('assets/front/img/' . $user->cover) }}" id="cover-cont" class="img-responsive">

					<div class="form-group crossposting-input" style="text-align: center;">

						<label for="cover" class="btn btn-sm btn-success btn-block">Change Cover</label>

						<input type="file" id="cover" name="cover" class="form-control" style="display: none;">

					</div>

				</div>

				</div>-->

            <div class="row">

                <div class="form-group crossposting-input input-style-1">

                    <label for="workplace" class="control-label">Profession*</label>

                    <select name="workplace" id="workplace" class="form-control input-style-1">

                        @foreach(App\User::jobs()->sortBy('name') as $jobID => $jobName) @if($user->workplace == $jobName->id)

                        <option value="{{ $jobName->id }}" selected>{{ $jobName->name }}</option>

                        @else

                        <option value="{{ $jobName->id }}">{{ $jobName->name }}</option>

                        @endif @endforeach

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="form-group crossposting-input input-style-1">

                    <label for="name" class="control-label">First Name*</label>

                    <input type="text" id="fname" name="fname" class="form-control input-style-1" value="{{ $user->fname }}" required>

                </div>

                <div class="form-group crossposting-input input-style-1">

                    <label for="name" class="control-label">Last Name*</label>

                    <input type="text" id="lname" name="lname" class="form-control input-style-1" value="{{ $user->lname }}" required>


                </div>

                <div class="form-group crossposting-input input-style-1">

                    <label for="name" class="control-label">Email*</label>

                    <input type="email" id="email" name="email" class="form-control input-style-1" value="{{ $user->email }}" required>

                </div>


            </div>

            <div class="row">

                <div class="form-group crossposting-input input-style-1">

                    <label for="bio" class="control-label">Brief Bio</label>

                    <textarea id="bio" name="bio" class="form-control input-style-1"  placeholder="Tell us a little about you and your interests." required>{{ $user->bio }}</textarea>

                </div>

            </div>

            <div class="row">

                <div class="form-group crossposting-input input-style-1">
                    <br>
                    <label for="country" class="control-label">Country*</label>

                    <select name="country" id="country" class="form-control input-style-1" required>

                        @foreach(countries() as $code => $name) @if($user->country == $code)

                        <option value="{{ $code }}" selected>{{ $name }}</option>

                        @else

                        <option value="{{ $code }}">{{ $name }}</option>

                        @endif @endforeach

                    </select>

                </div>

                <div class="form-group crossposting-input input-style-1">

                    <label for="city" class="control-label">City*</label>

                    <input type="text" id="city" name="city" class="form-control input-style-1" value="{{ $user->city }}" required>

                </div>

            </div>

            <div class="row">

                <div class="form-group crossposting-input input-style-1">

                    <label for="state" class="control-label">State*</label>

                    <input type="text" id="state" name="state" class="form-control input-style-1" value="{{ $user->state }}" required>

                </div>

                <div class="form-group crossposting-input input-style-1">

                    <label for="zip" class="control-label">Zip*</label>

                    <input type="text" id="zip" name="zip" class="form-control input-style-1" value="{{ $user->zip }}" required>

                </div>

            </div>

            <div class="row">

                <div class="form-group crossposting-input input-style-1">

                    <label for="facebook" class="control-label"><i class="fab fa-facebook"></i> https://facebook.com/______</label>

                    <input type="text" id="facebook" name="facebook" class="form-control input-style-1" value="{{ $user->facebook }}" placeholder="What is your Facebook username">

                </div>

                <div class="form-group crossposting-input input-style-1">

                    <label for="twitter" class="control-label"><i class="fab fa-twitter"></i> https://twitter.com/______</label>

                    <input type="text" id="twitter" name="twitter" class="form-control input-style-1" value="{{ $user->twitter }}" placeholder="What is your Twitter handle?">

                </div>

                <div class="form-group crossposting-input input-style-1">

                    <label for="linkedin" class="control-label"><i class="fab fa-linkedin"></i> https://linkedin.com/in/______</label>

                    <input type="text" id="linkedin" name="linkedin" class="form-control input-style-1" value="{{ $user->linkedin }}" placeholder="What is your Linkedin username">

                </div>

            </div>

            <!--<div class="row">

				<div class="col-md-6">

					<div class="form-group crossposting-input">

						<label for="state" class="control-label">Which type of you want notification </label>

						@php

							$notifystatus=explode(',',$user->notifystatus);

						@endphp

						<select name="notificationtype[]" id="notificationtype" multiple="true" class="form-control">

							<option value="">Please select notification type</option>

							<option value="1" {{ in_array('1',$notifystatus)?"selected='selected'":"" }}>Follow</option>

							<option value="2" {{ in_array('2',$notifystatus)?"selected='selected'":"" }}>Message</option>

							<option value="3" {{ in_array('3',$notifystatus)?"selected='selected'":"" }}>Birthday</option>

							<option value="4" {{ in_array('4',$notifystatus)?"selected='selected'":"" }}>Comments on their post</option>

							<option value="5" {{ in_array('5',$notifystatus)?"selected='selected'":"" }}>New post</option>

						</select>

					</div>

				</div

				<div class="col-md-6">

				</div>>-->

            <div class="row">

                <div class="col-md-12">

                    @if($user->verified == 0) Profile isn't verified? <a class="btn btn-sm btn-success" href="{{ route('user.verify.request') }}">Request</a> @elseif ($user->verified == -1) @endif

                </div>

            </div>

            <div class="row">

                <button class="button button-s shadow-large button-round-small bg-blue1-dark top-10" type="submit">Update Profile</button>

            </div>

        </form>

        <div class="row">

            <button onclick="document.location='/change-password'" class="button button-s shadow-large button-round-small top-10" style="background:#333">Change Password</button>

        </div>

    </div>

</div>

@endsection @section('js')

<script src="{{ asset('assets/front/js/chosen.jquery.js') }}"></script>

<script>
    (function($) {

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

        $(document).on('change', '#cover', function(e) {

            if (this.files.length) {

                var file = this.files[0];

                var reader = new FileReader();

                reader.onload = function(e) {

                    var data = e.target.result;

                    $('#cover-cont').attr('src', data);

                };

                reader.readAsDataURL(file);

            }

        });

        $('#notificationtype').chosen();

    })(jQuery);
</script>

@endsection
