@extends('layouts.auth')

@section('content')
<div class="page-content">
    <div class="col-md-12 single">
        <h4 class="text-center">{{ $page_title }}</h4>

        <form method="post" action="{{ route('user.group.update', $group->slug) }}" enctype="multipart/form-data">

            @csrf
			
			<div class="row">
                <div class="col-md-12">
                    @if($group->cover)<img src="{{ asset('assets/front/img/' . $group->cover) }}" id="cover-cont" class="img-responsive">@endif
                    <div class="form-group crossposting-input" style="text-align: center;">
                        <label for="cover" class="button button-s shadow-large button-round-small bg-black">Change Cover</label>
                        <input type="file" id="cover" name="cover" class="form-control" style="display: none;">
                    </div>
                </div>
            </div>
			<br>
			
			
            <div class="row">
                <div class="col-md-12">
                    <span>Topics: <a href="#" data-menu="menu-add-topic" alt="Add Topics"> <i class="fas fa-plus"></i> </a><span class="topicList"></span></span>
					<span>@foreach($group->topics as $myinterest)<a class="remtopic" data-post="{{$myinterest->id}}" ><i class="fas fa-minus-circle"></i> {{$myinterest->name}}</a>, @endforeach</span>
                    
                    <div class="col-md-12" style="visibility:hidden; height:1px; overflow:hidden">
                        <label>Interests - this is just temporary </label>
                        <div class="form-group form-check crossposting-input input-style-1">
                            @foreach($interest as $int)
                                <div class="col-md-6">
                                <label style="width:50%; float:left" for="interest{{$int->id}}">{{$int->name}}</label>
                                <input style="width:50%; float:left"  type="checkbox" class="form-control input-style-1" name="interest[]" id="interest{{$int->id}}" value="{{$int->id}}" > 
                                </div>
                            @endforeach
                        </div>
                        </div>
                    
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Name*</label>
                        <input type="text" id="name" name="name" class="form-control input-style-1" required value="{{ $group->name }}">
                    </div>
                    <div class="form-group crossposting-input input-style-1">
                        <label for="description" class="control-label">Description*</label>
                        <textarea type="text" id="description" name="description" class="form-control input-style-1" style="min-height: 200px;" required >{{ $group->description }}</textarea>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="type" class="control-label">Post Access</label>
                        <select name="type" id="type" class="form-control input-style-1">
                            <option value="0" @if($group->type == 0)selected @endif>Public</option>
                            <option value="1" @if($group->type == 1)selected @endif>Member Only</option>
                        </select>
                    </div>
					<div class="form-group crossposting-input input-style-1">
                        <label for="acceptance" class="control-label">Acceptance</label>
                        <select name="acceptance" id="acceptance" class="form-control input-style-1">
                            <option value="0" @if($group->acceptance == 0)selected @endif>Approval Not Required</option>
                            <option value="1" @if($group->acceptance == 1)selected @endif>Approval Required</option>
                        </select>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-block btn-success button bg-highlight button-primary button-s  shadow-large top-30 bottom-30" type="submit">Update Group</button>
                </div>
            </div>
            <br><br>

        </form>
    </div>
</div>

	<div id="menu-add-topic" class="menu menu-box-bottom" data-menu-effect="menu-parallax">
	<div class="content">
		<h1 class="uppercase ultrabold top-20">Add Topic</h1>
		<p class="font-11 under-heading bottom-20">
			Start typing the topics you want to assign to this group.
		</p>
		<div class="search-box search-color shadow-tiny round-large bottom-20">
			<i class="fa fa-search"></i>
			<input type="text" placeholder="Search for topics... " data-search="">
		</div>
		<div class="search-results disabled-search-list">
			<div class="link-list link-list-2 link-list-long-border">
            
            	 @foreach($interest as $int)
            
                    <a href="#" onClick="passchecked({{$int->id}})" id="searchint{{$int->id}}" data-post="{{$int->id}}" data-filter-item="{{$int->id}}" data-filter-name="{{strtolower($int->name)}} " class="intClk">
                        <span>{{$int->name}}</span>
                    </a>
                @endforeach
                
				
			</div>
		</div>      
		<div class="clear"></div>
		<a onClick="hide('#menu-add-topic')" href="#" class="button button-full button-s shadow-large button-round-small bg-blue2-dark top-10">Finished</a>
	</div>
	</div>  
@endsection

@section('js')

    <script>
        (function($) {

            {{--$(document).on('change', '#avatar', function(e) {

                if (this.files.length) {

                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var data = e.target.result;

                        $('#avatar-cont').attr('src', data);
                    };

                    reader.readAsDataURL(file);

                }

            });--}}

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
			 
			 
			 
			 
			 ////////////
			 
			 $(document).on('click', '.remtopic', function (e) {

                    e.preventDefault();



                    var post = $(this).data('post');

					

					console.log(post);

					// $(this).addClass('inactive');

                   // $(this).removeClass('active');

					$(this).hide('slow');



                    $.ajax({

                        type:"POST",

                        url:"{{ route('group.remtopic') }}",

                        data: {group_id:{{$group->id}},topic_id: post, _token: '{{ csrf_token() }}'},

                        success:function(data){

                            if (data.success && data.success == 1) {

                                if (data.message) {

                                  //  toastr.success(data.message);

                                }

                            }

                        }

                    });



                });

			 
			 ////////////

        })(jQuery);
    </script>

@endsection