@extends('layouts.auth')
@section('content')



<div class="page-content ">
	
		
	<div class="row">
		
		
		<div class="col-md-6">
			
			<div class="divider divider-margins"></div>
			<div class="author-header">
				<div class="header-bottom bottom-20">

						<h2>{{ $group->name }}</h2>
						<span class="bottom-10">Admin: <a href="{{ route('profile', $group->creator()->username) }}">{{ $group->creator()->name }}</a></span>

				</div>
			</div>
	
			
		</div>
		<div class="col-md-6">
			@if($group->cover)<img src="{{ asset('assets/front/img/' . $group->cover) }}" id="cover-cont" class="img-responsive">@endif

		</div>
		
	</div>
			
			<ul class="profile-nav">
				@if($group->isCreator())
				<li>
					<a href="#" onclick="event.preventDefault();document.getElementById('follow-form').submit();">
						<div class="single-profile-nav-element">
							<i class="fas fa-trash"></i>
							<span> Delete Group</span>
						</div>
					</a>
				</li>
				@elseif($group->isAdmin() || $group->isModerator() || $group->isMember())
				<li>
					<a href="#" onclick="event.preventDefault();document.getElementById('follow-form').submit();">
						<div class="single-profile-nav-element">
							<i class="fas fa-ban"></i>
							<span> Leave Group</span>
						</div>
					</a>
				</li>
				@elseif($group->isPending())
				<li>
					<a href="#" onclick="event.preventDefault();document.getElementById('follow-form').submit();">
						<div class="single-profile-nav-element">
							<i class="fas fa-user-times"></i>
							<span> Cancel Join</span>
						</div>
					</a>
				</li>
				@else
				<li>
					<a href="#" onclick="event.preventDefault();document.getElementById('follow-form').submit();">
						<div class="single-profile-nav-element">
							<button class="button button-m bg-green1-dark"><i class="fas fa-user-plus"></i><span> Join Group</span></button>
						</div>
					</a>
				</li>
				@endif
				<form action="{{ route('user.group.follow', $group->slug) }}" id="follow-form" method="post" style="display: none;">
					@csrf
				</form>

				@if($group->isCreator() || $group->isAdmin() || $group->isModerator())
				<li>
					<a href="{{ route('user.group.members', [$group->slug, 'pending']) }}">
					<i class="fas fa-spinner "></i><span> {{ number_format_short($group->requestCount()) }} Join Request</span>
					</a>
				</li>
				@endif
				@if($group->isCreator() || $group->isAdmin() || $group->isModerator() || $group->isMember())
				<li>
					<a href="{{ route('user.group.members', [$group->slug, 'active']) }}">
					<i class="fas fa-users"></i><span> {{ number_format_short($group->memberCount()) }} Members</span>
					</a>
				</li>
				@if($group->isCreator() || $group->isAdmin() || $group->isModerator() )
				<li>
					<a target="_blank" href="{{ route('user.group.invite', $group->slug) }}" class='ls-modal' id="invite" >
					<i class="fas fa-user-plus"></i><span> Invite People</span>
					</a>
				</li>
				@endif
				@endif
				@if($group->isCreator())
				<li>
					<a href="{{ route('user.group.edit', $group->slug) }}">
					<i class="fas fa-edit"></i><span> Edit Group</span>
					</a>
				</li>
				@endif
			</ul>
			
			
		
		
		
	

	
	<div class="clear"></div>

	<div class="divider divider-margins"></div>
	
	
	<div class="top-10 bottom-10">{{ $group->description }}</div>
	<span>Topic(s): @foreach($group->topics as $myinterest)<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>, @endforeach</span>
		<div class="divider divider-margins"></div>
						

	<!-- <div class="author-details">
		<ul style="display: grid">
			<li><i class="fas fa-user-check"></i> {{ number_format_short($group->memberCount()) }} Members</li>
			<li><i class="far fa-file-alt"></i> {{ number_format_short($group->posts()->count()) }} posted</li>
			<li><i class="fas fa-calendar"></i> Started At {{ $group->created_at->format('d M, Y') }}</li>
		</ul>
	</div>
	<div class="divider divider-margins"></div>-->

    <!--main content-->

            @if($group->isCreator() || $group->isAdmin() || $group->isModerator() || $group->isMember())
						<a href="#" data-menu="menu-add-topic" alt="Add Topics" class="button button-s outline">+/- Topics</a> <span class="topicList"></span>

            <div class="clear"></div>

            <div class="create-new-post-wrapper">
                <div class="preloader" id="post-ajax-loader" style="display: none;">
                    <div class="progress">
                        <div id="prog" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                        </div>
                    </div>
                </div>






                <div class="post-input">

                        <form onsubmit="myButton.disabled = true; return true;" method="post" action="{{ route('user.post.store') }}">

                            @csrf
                            <input type="hidden" name="urldataval" id="urldataval" value="">
                            <input type="hidden" name="hrefurl" id="hrefurl" value="">
							
							
							<div class="input-style-2">
		                            <input type="hidden" name="group_id" value="{{ $group->id }}">
		                            <textarea class="post-input-field textarea nice-scroll" placeholder="Paste a URL, video link, or enter your post..." name="article"></textarea>
														</div>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="urldatadiv" style="display:none;"></div>

														<div class="post-addons">
															<ul class="right">
																<li>
																	<div class="single-input-wrapper" id="fileInput">
																		<label for="image" class="upload">
																		<img src="/assets/front/css/img_upload.png" alt="Upload an Image">
																		</label>
																		<input type="file" name="image" id="image" style="display:none">
																	</div>
																</li>
																<!--<li>
																	<div class="single-input-wrapper">

																	    <label for="video">

																	        <img src="/assets/front/css/mov_upload.png" alt="Upload an Video">

																	    </label>

																	    <input type="file" name="video" id="video" style="display:none">

																	</div>

																	</li>-->
																<li class="hidden-mobile">
																	<div class="single-input-wrapper">
																		<label for="doc">
																		<img src="/assets/front/css/doc_upload.png" alt="Upload an Document">
																		</label>
																		<input type="file" name="doc" id="doc" style="display:none">
																		<input type="hidden" name="type" id="type">
																		<input type="hidden" name="link" id="link">
																	</div>
																</li>
																<!--<li>
																	<div class="single-input-wrapper">

																	    <label for="group">

																	        <img src="/assets/front/css/group_upload.png" class="hidden-mobile" alt="Add to a Group"><span class="show-mobile">Add to Group</span>

																	    </label>

																	</div>

																	</li>-->
																<li style="margin-bottom:5px">
																	<div>
																		<button name="mybutton" style="background-color:#A0D468; padding:6px 12px;margin-top:2px;" type="submit" class="button">
																		<span class="posting-submit-icon">
																		<i class="fa fa-paper-plane"></i>
																		</span>
																		<span class="posting-submit-btn"> Post</span>
																		</button>
																	</div>
																</li>
															</ul>
														</div>
																<div class="divider divider-margins"></div>

                						<div id="cont" style="display:none" class="instrant-upload-show">
                							<span class="cross"><i class="fa fa-times" aria-hidden="true"></i></span>
                                            <div class="contai">
                                            </div>
                                    </div>
                                    <!-- image modal start change by dinesh -->
                                    <div class="modal fade" id="imageModal" role="dialog" style="display:none">
                                        <div id="imgmodalwidth" class="modal-dialog modal-lg" style="width:400px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <img id="imagesrc" class="showimage img-responsive" src="" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- image modal end change by dinesh -->
                </form>
                <img style="display:none;width:50px;" id="loaderimg" src="{{ url('assets/front/img/loader.gif') }}">
                </div>


             </div>



            @endif

                @if($group->isCreator() || $group->isAdmin() || $group->isModerator() || $group->isMember() || $group->type == 0)

                    @if(count($shares))
                            <div class="post-loop-wrapper">
                            <div class="post-loop-inner infinite-scroll">
                            @foreach($shares as $post)

                            @php

                            $theSharer = '';

                            if(isset($post->shares))
                            {

                                foreach($post->shares as $aShare) {
                                   //if($aShare->user_id == Auth::user()->id)
                                   if($aShare->user_id != $post->user_id && $aShare->user_id!=1)
                                        $theSharer = $aShare;
                                  }
                            }
                            @endphp

                                    <div class="single-post-item post">
																			@if($post->user_id == Auth::user()->id )
																			<ul class="postedit">
																					<li>
																					<a href="/posts/edit/{{$post->id}}"><i class="fas fa-edit" ></i></a>
																				</li>
																				<li>
																					<span href="#" class="delete-post" data-post="{{$post->id}}" ><i class="fa fa-trash" ></i></span>
																				</li>
																			</ul>
																		 	@elseif(!empty($theSharer))
                                                                                @if($theSharer->user_id == Auth::user()->id )
                                                                                <ul class="postedit">

                                                                                    <li>
                                                                                        <span href="#" class="delete-share" data-post="{{$post->id}}" ><i class="fa fa-trash" ></i></span>
                                                                                    </li>
                                                                                </ul>
                                                                                @endif
																		 	@endif

						@php $postTopics=App\Post::postTopics($post->id); @endphp
                                         @php //print_r($post->shares); @endphp
						@if(isset($theSharer) && !empty($theSharer) )
                        @php @$sharerID = $theSharer->user->id; //print_r($post->shares[0]->user->name); @endphp
                        <img src="{{ asset('assets/front/img/' . optional($theSharer->user)->avatar) }}" class="profile-image" alt="{{ optional($theSharer->user)->name }}">
                        <a href="{{ route('profile', optional($theSharer->user)->username) }}" class="user">{{ optional($theSharer->user)->name }}</a>
												<br>
                        <date>shared this {{ $post->type }} {{ (($theSharer->created_at)?$theSharer->created_at->diffForHumans():$post->created_at->diffForHumans())  }}</date>
                        	<div class="post-meta">

                                @if($postTopics[0]->interests->count() > 0)
                                <span>TOPIC(S):
							@foreach($postTopics as $theinterest)
							@foreach($theinterest->interests as $myinterest)
							<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>,
							@endforeach
							@endforeach
							</span> @endif


                            @php
                                    if(isset($post->link))
                              			{
                                      $baseURL = explode('/',$post->link);
										if(isset($baseURL[2]))
                                      		echo "<Br>SOURCE: <a style='display:inline' class='urlSource' href='/feed?rss=".$baseURL[2]."'>".$baseURL[2]."</a><Br>";
                                    }
                                  @endphp

                            </div>




                            @if($sharerID != $post->user->id)

                            <div style="clear:both"></div>
                            <img style="width:35px;height: auto;" src="{{ asset('assets/front/img/' . optional($post->user)->avatar) }}" class="profile-image" alt="{{ optional($post->user)->name }}">
                            <a href="{{ route('profile', optional($post->user)->username) }}" class="user">{{ optional($post->user)->name }}</a>
                            <date>shared this {{ $post->type }} {{ $post->created_at->diffForHumans() }}</date>

                            @endif
                        @else
                        <img src="{{ asset('assets/front/img/' . optional($post->user)->avatar) }}" class="profile-image" alt="{{ optional($post->user)->name }}">
                        <a href="{{ route('profile', optional($post->user)->username) }}" class="user">{{ optional($post->user)->name }}</a>
                        <br>
                        <date>shared this {{ $post->type }} {{ $post->created_at->diffForHumans() }}</date>
                        <div class="post-meta">

                                @if($postTopics[0]->interests->count() > 0)
                                <span>TOPIC(S):
							@foreach($postTopics as $theinterest)
							@foreach($theinterest->interests as $myinterest)
							<a href="/feed?topic={{$myinterest->id}}">{{$myinterest->name}}</a>,
							@endforeach
							@endforeach
							</span> @endif

                             @php
                                    if(isset($post->link))
                              			{
                                      $baseURL = explode('/',$post->link);
										if(isset($baseURL[2]))
                                     		 echo "<Br>SOURCE: <a style='display:inline' class='urlSource' href='/feed?rss=".$baseURL[2]."'>".$baseURL[2]."</a><Br>";
                                    }
                                  @endphp


                            </div>
                        @endif
                            <!--<span>With: <a href="#">User Name</a>, <a href="#">Tagged User</a>, <a href="#"> <i class="fas fa-user-plus">
</i> </a>
</span>-->

                                            <article>
                                                @if($post->type == 'article' )
                                                    @if($post->scrabingcontent!='')
                                                        <p>{!! $post->scrabingcontent !!}</p>
                                                    @else
                                                        <p>{!! excerpt($post) !!}</p>
                                                    @endif


                                                @elseif($post->type == 'image')
                                                    <p>{!! excerpt($post) !!}</p><br>
                                                    <img src="{{ asset('assets/front/content/' . $post->link) }}" class="img-responsive">
                                                @elseif($post->type == 'video')
                                                    <p>{!! excerpt($post) !!}</p><br>
                                                    <video class="player" playsinline controls id="{{ str_random(20) }}" style="width: 100%;">
                                                        <source src="{{ asset('assets/front/content/' . $post->link) }}" type="video/mp4">
                                                    </video>
                                                @elseif($post->type == 'audio')
                                                    <p>{!! excerpt($post) !!}</p><br>
                                                    <audio class="player" controls id="{{ str_random(20) }}" style="width: 100%;">
                                                        <source src="{{ asset('assets/front/content/' . $post->link) }}" type="audio/mp3">
                                                    </audio>
                                                @elseif($post->type == 'youtube')
                                                    <p>{!! excerpt($post) !!}</p><br>
                                                    <div class="plyr__video-embed player">
                                                        <iframe id="{{ str_random(20) }}" src="https://www.youtube.com/embed/{{ $post->link }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                                    </div>
                                                @elseif($post->type == 'vimeo')
                                                    <p>{!! excerpt($post) !!}</p><br>
                                                    <div class="plyr__video-embed player">
                                                        <iframe id="{{ str_random(20) }}" src="https://player.vimeo.com/video/{{ $post->link }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                                                    </div>
                                                @elseif($post->type == 'doc')
                                                    <p>{!! excerpt($post) !!}</p><br>
																										<div class="doc">
										                                   <div style="overflow: hidden;">
										                                        {{ $post->link }}
										                                        <a target="_blank" href="{{ asset('assets/front/content/' . $post->link) }}" class="top-10 pull-right button button-xs button-round-small shadow-small button-primary" download >Download</a>
										                                   </div>
										                               </div>



                                                @elseif($post->type == 'feed')
                                                <div>
                                                    <p>{!! $post->content !!}</p>
                                                    <p>
                                                    	<a rel="modal:open" href="/ajaxpage?url={{ $post->link }}" class="pull-right readmore" >Read More</a>
													</p>
													<div class="clear"></div>
                                                </div>
                                                @endif

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
												                                      <i onClick="$(this).addClass('active');" class="fas fa-star post-action favorite {{ $post->isFavorited()?' active':'' }}" data-post="{{$post->id}}"><span class="i-span"> Bookmark</span></i>
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



                                            </article>
                                        </div>


                            @endforeach
                            <div style="display:none">{{ $shares->links() }}</div>

                        </div>
                        </div>
                    @else
                        <div class="col-md-12 single text-center">No Post Found.</div>
                    @endif
                @else
                    <div class="col-md-12 single text-center">Private group. Please Join First</div>
                @endif




    <!-- /main content -->


</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@auth
<script src="{{ asset('assets/front/twitter/emojionearea.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.plyr.io/3.2.4/plyr.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/zenorocha/clipboard.js/v2.0.0/dist/clipboard.min.js"></script>
@endauth
@endsection
