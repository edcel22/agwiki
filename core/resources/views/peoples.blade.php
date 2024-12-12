@extends('layouts.auth')











@section('content')









    <div class="page-content">

        <div class="users">

          @if(isset($_GET['user']))

            <h2 class="people-user">{{$currentUser->name}}</h2>

            @endif


			<div class="tab-controls tab-animated tabs-medium" data-tab-items="3" data-tab-active="bg-blue1-dark">




				<a href="#" data-tab-active data-tab="tab-1"> Following</a>

				<a href="#" data-tab="tab-2"> Followers</a>


                @if(!isset($_GET['user']))

				<a href="#" data-tab="tab-3"><i class="fas fa-plus-circle"></i> Find People</a>
                @endif


			</div>

<div class="clear"></div>

			<div class="tab-content" id="tab-1">



            	@if($isFollowedMe && count($isFollowedMe))

                @foreach($isFollowedMe as $following)

				@if($following->user)

				<div class="one-half center-text profile">

					<a href="/profile/{{ $following->user->username }}">

						<img class="profile-picture small" alt="{{ $following->user->name }}" src="{{ asset('assets/front/img/'. $following->user->avatar ) }}">

						<div class="username">{{ $following->user->name }}</div>

						<div class="role">@if(isset($following->user->workplace)){{ $following->user->job($following->user->id)['name']}}@endif</div>

						<div class="location">@if($following->user->city){{ $following->user->city }}, {{ $following->user->state }}@endif</div>

					</a>


					@if(!isset($_GET['user']))
                    <a class="top-10 button button-xs button-round-small bg-blue1-dark shadow-small" href="/message/{{$following->user->username}}"><i class="fa fa-comments post-action comment"></i> Message</a>

                    <br>
					@endif
				</div>


				@endif
                @endforeach



                @endif


        <div class="clear"></div>

				<div class="divider divider-margins"></div>



				<div class="center-horizontal center-text">

					<!--<button type="submit" class="button button-m button-round-small bg-green2-dark shadow-small">

						Load 10 More <i class="fas fa-chevron-down"></i>

					</button>-->

				</div>

			</div>

			<div class="tab-content" id="tab-2">

				@if($StaticisFollowingMe && count($StaticisFollowingMe))

                @foreach($StaticisFollowingMe as $isfollowing)
				
				@if($isfollowing->user2)

				<div class="one-half center-text profile">

					<a href="/profile/{{ $isfollowing->user2->username }}">

						<img class="profile-picture small" alt="{{ $isfollowing->user2->name }}" src="{{ asset('assets/front/img/' . $isfollowing->user2->avatar) }}">

						<div class="username">{{ $isfollowing->user2->name }}</div>

						<div class="role">@if(isset($isfollowing->user2->workplace)){{ $isfollowing->user2->job($isfollowing->user2->id)['name']}}@endif</div>

						<div class="location">@if($isfollowing->user2->city){{ $isfollowing->user2->city }}, {{ $isfollowing->user2->state }}@endif</div>

					</a>
          @if(!isset($_GET['user2']))
                    <a class="top-10 button button-xs button-round-small bg-blue1-dark shadow-small" href="/message/{{$isfollowing->user2->username}}"><i class="fa fa-comments post-action comment"></i> Message</a>

                    <br>
          @endif

				</div>
				@endif
                @endforeach



                @endif



				<div class="divider divider-margins"></div>



				<div class="center-horizontal center-text">

					<!--<button type="submit" class="button button-m button-round-small bg-green2-dark shadow-small">

						Load 10 More <i class="fas fa-chevron-down"></i>

					</button>-->

				</div>

			</div>

			<div class="tab-content" id="tab-3">

				<!--<div class="one-half fac fac-checkbox fac-green"><span></span>

					<input id="box1-fac-checkbox" type="checkbox" value="1" checked="">

					<label for="box1-fac-checkbox">Consultant</label>

				</div>

				<div class="one-half fac fac-checkbox fac-green"><span></span>

					<input id="box2-fac-checkbox" type="checkbox" value="1" checked="">

					<label for="box2-fac-checkbox">Farmer/Grower</label>

				</div>

				<div class="one-half fac fac-checkbox fac-green"><span></span>

					<input id="box3-fac-checkbox" type="checkbox" value="1" checked="">

					<label for="box3-fac-checkbox">Industry</label>

				</div>

				<div class="one-half fac fac-checkbox fac-green"><span></span>

					<input id="box4-fac-checkbox" type="checkbox" value="1" checked="">

					<label for="box4-fac-checkbox">Nutritionist</label>

				</div>

				<div class="one-half fac fac-checkbox fac-green"><span></span>

					<input id="box5-fac-checkbox" type="checkbox" value="1" checked="">

					<label for="box5-fac-checkbox">Researcher/Scientist</label>

				</div>-->







				<div class="search-box search-color shadow-tiny round-large bottom-20">

					<i class="fa fa-search"></i>

					<input type="text" placeholder="Search for People... " data-search="">

				</div>
				
				<div >
					Please search by name, city, or occupation
				</div>



				<div class="search-results disabled-search-list">

                @foreach($Users as $user)



					<div class="one-half center-text">

						<a href="/profile/{{ $user->username }}" data-filter-item="{{ $user->id }}" data-filter-name="{{ strtolower($user->name) }} @if(isset($user->workplace)){{ strtolower($user->job($user->workplace)['name'])}}@endif {{ strtolower($user->city) }} {{ strtolower($user->state) }}">

							<img class="profile-picture small" alt="{{ $user->name }}" src="{{ asset('assets/front/img/' . $user->avatar) }}">

							<div class="username"><?php echo (($user->name!='')?$user->name:$user->username); ?> </div>

							<div class="role">@if(isset($user->workplace)){{ $user->job($user->workplace)['name']}}@endif</div>

							<div class="location"><?php if ($user->city!='') echo $user->city .','.  $user->state   ; ?></div>

						</a>

					</div>



				@endforeach


        <div class="clear"></div>



        <div class="divider divider-margins"></div>



				</div>

			</div>

		</div>

    </div>



@endsection
