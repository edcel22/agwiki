@extends('layouts.auth')

@section('content')

<div class="page-content header-clear-small ">

	<div class="profile-2">
			<center>
                @if(Auth::check())
                    @if($user->id == Auth::user()->id)
                        <a href="/profile-edit" class="button button-s shadow-large button-round-small bg-black">EDIT PROFILE <i class="fas fa-edit"></i></a>
                        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="button button-s shadow-large button-round-small bg-red1-dark">LOG OUT</a>
                        <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
                    
                        <a href="/interests" class="button button-s shadow-large button-round-small bg-black">EDIT TOPICS <i class="fas fa-edit"></i></a>
                    @endif
                @endif
			</center>
		<img class="profile-image preload-image" src="{{ asset('assets/front/img/' .$user->avatar) }}" data-src="{{ asset('assets/front/img/' . $user->avatar) }}" alt="img">

		<div class="profile-body">

			<h1 class="profile-heading">{{ $user->name }}</h1>

			<h2 class="profile-sub-heading"><a href="#" class="color-highlight">@if(isset($user->workplace)){{ $user->job($user->workplace)['name']}}@endif</a></h2>

			<h2 class="profile-sub-heading"> @if($user->city){{ $user->city }}, {{ $user->state }} {{ $user->zip }} {{ $user->country }} @endif</h2>

			<h2 class="profile-sub-heading">Joined: {{ optional($user->created_at)->format('d M, Y') }}</h2>



            @if(Auth::check())
                @if($user->id == Auth::user()->id)

                <h2 class="profile-sub-heading"><a href="/peoples">Following ({{App\User::Staticfollowing($user->id )}}) / Followers ({{App\User::Staticfollowers($user->id )}})</a></h2>
                @else
                <h2 class="profile-sub-heading"><a href="/peoples?user={{$user->id}}">Following ({{App\User::Staticfollowing($user->id )}}) / Followers ({{App\User::Staticfollowers($user->id )}})</a></h2>
                @endif
            @endif

            @if(Auth::check())
                @if($user->id != Auth::user()->id )

                <a onclick="event.preventDefault();document.getElementById('follow-form-{{ $user->id }}').submit();" class="button bg-highlight button-primary button-s button-center-small shadow-large top-30 bottom-30">

                @if($user->isFollowedMe())Unfollow @else Follow @endif

                </a>

                <a class="message button-center-small" href="/message/{{$user->username}}"><i class="fa fa-comments post-action comment"></i> Message</a>

                <form action="{{ route('user.follow', $user->username) }}" id="follow-form-{{ $user->id }}" method="post" style="display: none;">

                    @csrf

                </form>

                @endif
            @endif

			<div class="divider divider-margins bottom-15"></div>

			<div class="profile-stats">

            @if($user->facebook)

				<a target="_blank" href="https://facebook.com/{{$user->facebook}}"><i style="color:white" class="fab center-text bg-facebook shadow-large fa-facebook-f"></i></a>

            @endif



            @if($user->twitter)

				<a target="_blank" href="https://twitter.com/{{$user->twitter}}"><i style="color:white" class="fab center-text bg-twitter shadow-large fa-twitter"></i></a>

            @endif



             @if($user->linkedin)

				<a target="_blank" href="https://linkedin.com/in/{{$user->linkedin}}"><i style="color:white"s class="fab center-text bg-linkedin shadow-large fa-linkedin"></i></a>

              @endif

				<div class="clear"></div>

			</div>

			<div class="divider divider-margins"></div>

			<h4>BIO</h4>

			<p class="description">{{ $user->bio }}</p>

			<div class="clear"></div>

			<div class="divider divider-margins"></div>

			<div class="accordion-style-2">
				<a href="#" data-accordion="accordion-content-5">
					<i class="accordion-icon-left far fa-file-alt"></i>	Topics	<i class="fa fa-angle-down padding-10"></i>
				</a>
				<p id="accordion-content-5" class="accordion-content bottom-10" style="display: none;">
					@foreach( $user->interests as $interest )
					<a href="/feed?topic={{$interest->id}}" class="topic active">{{$interest->name}}</a>
					@endforeach
				</p>
			</div>

			<div class="clear"></div>

            @if($groups && count($groups))

            <div class="accordion-style-2">
				<a href="#" data-accordion="accordion-content-6">
					<i class="accordion-icon-left fas fa-users"></i>	Groups	<i class="fa fa-angle-down padding-10"></i>
				</a>
				<div id="accordion-content-6" class="accordion-content bottom-10" style="display: none;">


                    @foreach($groups as $group)

										<div class="one-half">

												<div class="content content-box bg-white shadow-large">

                            <a href="{{ route('user.groups', optional($group->group)->slug) }}">

                                <h3 class="top-10">{{ optional($group->group)->name }}</h3>

                                <p class="bottom-10 description block">

                                    {{ optional($group->group)->description }}

                                </p>

                            </a>

                            <p>

                                <a href="{{ route('profile', $group->group->creator()->username) }}"><span><i class="fas fa-user-alt"></i>{{ $group->group->creator()->name }}</span></a>

                                <span><i class="fas fa-user-check"></i>{{ number_format_short(optional($group->group)->memberCount()) }} Members</span>

                                <span><i class="far fa-file-alt"></i>

                                @foreach($group->group->topics as $myinterest)

                                <a href="#">{{$myinterest->name}}</a>,

                                @endforeach

                                </span>

                            </p>

                            <p>
                                <br>
                                <a href="{{ route('user.groups', optional($group->group)->slug) }}" class="button button-xs bg-highlight bg-blue1-light"><i class="fas fa-arrow-alt-circle-right"></i> Visit Group</a>
                            </p>

                        </div>

										</div>
                    @endforeach





				</div>
			</div>

            <div class="clear"></div>

            @endif


			<!--<div class="divider divider-margins"></div>

			<h4>GROUPS</h4>

			<div class="divider-margins"></div>

			@if($groups && count($groups))

			@foreach($groups as $group)

			<div class="content content-box bg-white shadow-large">

				<a href="{{ route('user.groups', optional($group->group)->slug) }}">

					<h3 class="top-10">{{ optional($group->group)->name }}</h3>

					<p class="bottom-10 description">

						{{ optional($group->group)->description }}

					</p>

				</a>

				<p>

					<a href="{{ route('profile', $group->group->creator()->username) }}"><span><i class="fas fa-user-alt"></i>{{ $group->group->creator()->name }}</span></a>

					<span><i class="fas fa-user-check"></i>{{ number_format_short(optional($group->group)->memberCount()) }} Members</span>

					<span><i class="far fa-file-alt"></i>

					@foreach($group->group->topics as $myinterest)

					<a href="#">{{$myinterest->name}}</a>,

					@endforeach

					</span>

				</p>

				<p>
					<br>
					<a href="{{ route('user.groups', optional($group->group)->slug) }}" class="button button-xs bg-highlight bg-blue1-light"><i class="fas fa-arrow-alt-circle-right"></i> Visit Group</a>
				</p>

			</div>
			@endforeach
			@else

			<li>

				<div class="single-notification-items">

					<h4 class="not-found">No Group Found</h4>

				</div>

			</li>

			@endif
-->
			<div class="clear"></div>
			

            @if($shares && count($shares))
            <div class="post-loop-inner infinite-scroll">
                @foreach($shares as $share)
                    @if($share->post)
                        @php
                            $post = $share->post;
                        @endphp




                        @php $postTopics=App\Post::postTopics($post->id); @endphp


                        @if($post->type=='feed')
                    <div class="post">
                        <div>
                            <div class="post-meta">

                                @if($postTopics[0]->interests->count() > 0)
                                <span>TOPIC(S):
							@foreach($postTopics as $theinterest)
							@foreach($theinterest->interests as $myinterest)
							<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>,
							@endforeach
							@endforeach
							</span> @endif
                            </div>
                            <article>
                                <p class="pubDate">
                                  <span>
                                    {{ \Carbon\Carbon::parse($post->pubDate)->format('m/d/Y')}}
                                  </span>
                                  @php
                                    if(isset($post->link))
                              			{
                                      $baseURL = explode('/',$post->link);
                                      echo "SOURCE: <a target='_blank' href='".$post->link."'>".$baseURL[2]."</a>";
                                    }
                                  @endphp

                                </p>



                                <p><!--<span class="url">{{ $post->link }}</span>--><a rel="modal:open" href="/ajaxpage?url={{ $post->link }}">{!! $post->content !!}</a> <a rel="modal:open" href="/ajaxpage?url={{ $post->link }}" class="pull-right readmore">Read More</a>
                                </p>
                            </article>
                        </div>
                        <div class="post-addons likes">
                                <ul>
                                    <li>
                                        <div class="single-input-wrapper">
                                            <i onClick="$(this).addClass('active');" class="fas fa-thumbs-up post-action like {{ $post->isLiked()?' active':'' }}" data-post="{{$post->id}}"><span class="i-span">({{App\Like::countLIke($post->id)}})</span></i>
                                        </div>
                                    </li>
                                    <li style="width:50px;">
                                        <div class="single-input-wrapper share-group home-page-share-btn group">
                                            <a onClick="$( '.dropdown-content-{{$post->id}}' ).toggle();" href="javascript::void(0)" data-toggle="dropdown-content" class="dropdown-toggle">
                                                <i class="fa fa-share-square"></i> <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-content dropdown-content-{{$post->id}} groupShare">
                                                <li style="width:250px;">
                                                    <a data-original-title="Timeline"   href="" target="_blank" >
                                                       <a data-post="{{$post->id}}" onClick="$(this).addClass('active');$( '.dropdown-content-{{$post->id}}' ).toggle();" class="share"> Timeline</a>
                                                    </a>
                                                </li>
                                                @if($groups && count($groups))
                                                @foreach($groups as $group)
                                                <li style="width:250px;">
                                                    <a data-original-title="Group {{$group->name}}"   href="" target="_blank" >
                                                       <a data-post="{{$post->id}}" data-group="{{$group->group->id}}" onClick="$(this).addClass('active');$( '.dropdown-content-{{$post->id}}' ).toggle();" class="share">Group {{$group->group->name}}</a>
                                                    </a>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="single-input-wrapper">
                                            <i onClick="$(this).addClass('active');" class="fas fa-star post-action favorite {{ $post->isFavorited()?' active':'' }}" data-post="{{$post->id}}">
      <span class="i-span"> Bookmark</span></i>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/post/{{$post->id}}#commentbox">Comments ({{ number_format_short($post->commentCount()) }})</a>
                                    </li>
                                </ul>


                                <ul class="socialShare">
                                    <li>
                                        <a data-original-title="Twitter"  href="{{ route('social.share', [$post->id, 'twitter']) }}" target="_blank" class="btn btn-twitter" data-placement="left">
                                            {{-- <i class="fab fa-twitter"></i> --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17">
                                                <rect width="24" height="24" fill="black" />
                                                <g>
                                                  <path fill="white" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                                                </g>
                                              </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-original-title="Facebook"  href="{{ route('social.share', [$post->id, 'facebook']) }}" target="_blank" class="btn btn-facebook" data-placement="left">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-original-title="LinkedIn"  href="{{ route('social.share', [$post->id, 'linkedin']) }}" target="_blank" class="btn btn-linkedin" data-placement="left">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                    @else
                    <!--other posts-->
                     @php $postTopics=App\Post::postTopics($post->id); @endphp
                    <div class="post">

                        <div>

                                @if($post->user_id == Auth::user()->id )
                                    <ul class="postedit">
                                                                       <li>
                                    <a href="/posts/edit/{{$post->id}}"><i class="fas fa-edit" ></i></a>
                                    </li>
                                                                        <li>
                                    <span href="#" class="delete-post" data-post="{{$post->id}}" ><i class="fa fa-trash" ></i></span>
                                    </li>
                                    </ul>
                               @endif

                            <img src="{{ asset('assets/front/img/' . optional($share->user)->avatar) }}" class="profile-image" alt="{{ optional($share->user)->name }}">
                            <a href="{{ route('profile', optional($share->user)->username) }}" class="user">{{ optional($share->user)->name }}</a>
                            <br>
                            <date>shared this {{ $post->type }} {{ $post->created_at->diffForHumans()  }}</date>

                             @if($share->user_id != $post->user->id)

                                <div style="clear:both"></div>
                                <img style="width:35px;height: auto;" src="{{ asset('assets/front/img/' . optional($post->user)->avatar) }}" class="profile-image" alt="{{ optional($post->user)->name }}">
                                <a href="{{ route('profile', optional($post->user)->username) }}" class="user">{{ optional($post->user)->name }}</a>
                                <date>shared this {{ $post->type }} {{ $post->shares[0]->created_at->diffForHumans() }}</date>

                                @endif

                            <br> @if($postTopics[0]->interests->count() > 0)
                            <span>Topics:
						@foreach($postTopics as $theinterest)
						@foreach($theinterest->interests as $myinterest)
						<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>,
						@endforeach
						@endforeach
						</span>
                            <!--<span>With: <a href="#">User Name</a>, <a href="#">Tagged User</a>, <a href="#"> <i class="fas fa-user-plus">
</i> </a>
</span>-->
                            @endif
                            <article>
                                <br> @if($post->type == 'article') @if($post->scrabingcontent!='')
                                <p class="scrabingcontent">{!! $post->scrabingcontent !!}</p>
                                @else
                                <p>{!! excerpt($post) !!}</p>
                                @endif @elseif($post->type == 'image')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <img src="{{ asset('assets/front/content/' . $post->link) }}" class="img-responsive imgclickcls preload-image responsive-image" data-toggle="modal" data-target="#imageModal"> @elseif($post->type == 'video')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <video class="player" playsinline controls id="{{ str_random(20) }}" style="width: 100%;">
                                    <source src="{{ asset('assets/front/content/' . $post->link) }}" type="video/mp4">
                                </video>
                                @elseif($post->type == 'audio')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <audio class="player" controls id="{{ str_random(20) }}" style="width: 100%;">
                                    <source src="{{ asset('assets/front/content/' . $post->link) }}" type="audio/mp3">
                                </audio>
                                @elseif($post->type == 'youtube')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <div class="plyr__video-embed player">
                                    <iframe id="{{ str_random(20) }}" src="https://www.youtube.com/embed/{{ $post->link }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay">
                                    </iframe>
                                </div>
                                @elseif($post->type == 'vimeo')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <div class="plyr__video-embed player">
                                    <iframe id="{{ str_random(20) }}" src="https://player.vimeo.com/video/{{ $post->link }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay">
                                    </iframe>
                                </div>
                                @elseif($post->type == 'doc')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <div class="doc">
                                   <div style="overflow: hidden;">
                                        {{ $post->link }}
                                        <a target="_blank" href="{{ asset('assets/front/content/' . $post->link) }}" class="top-10 pull-right button button-xs button-round-small shadow-small button-primary" download >Download</a>
                                   </div>
                               </div>
                                @elseif($post->type == 'feed')
                                <p>{!! excerpt($post) !!}</p>
                                <br>
                                <a rel="modal:open" href="/ajaxpage?url={{ $post->link }}" class="pull-right readmore" download>Read More</a> @endif
                            </article>
                        </div>
                        <div class="post-addons likes">
                          <ul>
                              <li>
                                  <div class="single-input-wrapper">
                                      <i onClick="$(this).addClass('active');" class="fas fa-thumbs-up post-action like {{ $post->isLiked()?' active':'' }}" data-post="{{$post->id}}"><span class="i-span">({{App\Like::countLIke($post->id)}})</span></i>
                                  </div>
                              </li>
                              <li style="width:50px;">
                                  <div class="single-input-wrapper share-group home-page-share-btn group">
                                      <a onClick="$( '.dropdown-content-{{$post->id}}' ).toggle();" href="javascript::void(0)" data-toggle="dropdown-content" class="dropdown-toggle">
                                          <i class="fa fa-share-square"></i> <span class="caret"></span>
                                      </a>
                                      <ul class="dropdown-content dropdown-content-{{$post->id}} groupShare">
                                          <li style="width:250px;">
                                              <a data-original-title="Timeline"   href="" target="_blank" >
                                                 <a data-post="{{$post->id}}" onClick="$(this).addClass('active');$( '.dropdown-content-{{$post->id}}' ).toggle();" class="share"> Timeline</a>
                                              </a>
                                          </li>
                                          @if($group_share && count($group_share))
                                          @foreach($group_share as $group)
                                          <li style="width:250px;">
                                              <a data-original-title="Group {{$group->name}}"   href="" target="_blank" >
                                                 <a data-post="{{$post->id}}" data-group="{{$group->group->id}}" onClick="$(this).addClass('active');$( '.dropdown-content-{{$post->id}}' ).toggle();" class="share">Group {{$group->group->name}}</a>
                                              </a>
                                          </li>
                                          @endforeach
                                          @endif
                                      </ul>
                                  </div>
                              </li>
                              <li>
                                  <div class="single-input-wrapper">
                                      <i onClick="$(this).addClass('active');" class="fas fa-star post-action favorite {{ $post->isFavorited()?' active':'' }}" data-post="{{$post->id}}">
<span class="i-span"> Bookmark</span></i>
                                  </div>
                              </li>
                              <li>
                                  <a href="/post/{{$post->id}}#commentbox">Comments ({{ number_format_short($post->commentCount()) }})</a>
                              </li>
                          </ul>
                          <ul class="socialShare">

                              <li>
                                  <a data-original-title="Twitter"  href="{{ route('social.share', [$post->id, 'twitter']) }}" target="_blank" class="btn btn-twitter" data-placement="left">
                                      {{-- <i class="fab fa-twitter"></i> --}}
                                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="17" height="17">
                                        <rect width="24" height="24" fill="black" />
                                        <g>
                                          <path fill="white" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                                        </g>
                                      </svg>
                                  </a>
                              </li>
                              <li>
                                  <a data-original-title="Facebook"  href="{{ route('social.share', [$post->id, 'facebook']) }}" target="_blank" class="btn btn-facebook" data-placement="left">
                                      <i class="fab fa-facebook"></i>
                                  </a>
                              </li>
                              <li>
                                  <a data-original-title="LinkedIn"  href="{{ route('social.share', [$post->id, 'linkedin']) }}" target="_blank" class="btn btn-linkedin" data-placement="left">
                                      <i class="fab fa-linkedin"></i>
                                  </a>
                              </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>

                        <div class="divider divider-margins">
                    </div>








                         @endif

                         @endif

                @endforeach
                 @endif
                <div style="display:none">{{ $shares->links() }}</div>
            </div>


			<div class="divider-margins top-15"></div>

		</div>

	</div>

	
</div>

@endsection

