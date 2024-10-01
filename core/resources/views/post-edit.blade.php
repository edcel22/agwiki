@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css">
@endsection

@section('content')
    <div class=" single page-content" style="padding-top:0px">
        <div class="post-inner">
            <header class="post-header">
                <div class="post-data">
                    <div class="post-title-wrap">
                        <h1 class="post-title">Edit Post</h1>
                    </div>
                </div>
            </header>

            <div class="post-editor clearfix">
                <form action="/posts/edit/{{ $post->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <!--<label for="post_title" class="control-label">Post Title</label>
                        <input type="text" name="post_title" id="post_title" class="form-control" value="{{ $post->title }}" required>-->
                    </div>
                    <!--<div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="post_image" class="control-label" style="cursor: pointer;">
                                    <img id="image_container" style="width: 100%;max-height: 300px;" src="{{ asset('assets/front/content/' . $post->link) }}" alt="Select">
                                </label>
                                <input type="file" name="post_image" id="post_image" class="form-control" style="display: none;">
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group input-style-1">
                        <label for="post_content" class="control-label">Post Content</label>

                        <div class="post-meta">
                            <a href="#" data-menu="menu-add-topic" alt="Add Topics" class="button outline">+/- Topics</a>
                            <span class="topicList" style="opacity: 1 !important; color: #333 !important; font-size: 100% !important;"></span>

                            <div class="clear"></div>  
                            
                            @if(isset($_GET['topic']))
                            @php $oneinterest=App\Interest::getTopic($_GET['topic']); @endphp
                            <a alt="{{$oneinterest[0]->name}}" class="topic active" href="/feed"><i class="fas fa-minus-circle"></i> {{$oneinterest[0]->name}}</a>
                            @endif

                            @if(isset($_GET['fav']))
                            <a alt="Favorites" class="topic active" href="/feed"><i class="fas fa-minus-circle"></i> Favorites</a>
                            @endif

                            @if(isset($_GET['rss']))
                            <a alt="RSS" class="topic active" href="/feed"><i class="fas fa-minus-circle"></i> RSS - {{$_GET['rss']}}</a>
                            @endif
                            @php $interest=App\Interest::all(); @endphp
                            <div class="col-md-12" style="visibility:hidden; height:1px; overflow:hidden">
                                <label>Interests - this is just temporary </label>
                                <div class="form-group form-check crossposting-input input-style-1">
                                    @foreach($interest as $int)
                                    <div class="col-md-6">
                                        <label style="width:50%; float:left" for="interest{{$int->id}}">{{$int->name}}</label>
                                        <input style="width:50%; float:left" type="checkbox" class="form-control input-style-1" name="interest[]" id="interest{{$int->id}}" value="{{$int->id}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <textarea name="post_content" rows="10" class="input-style-1" id="post_content" required>{!! $post->content !!}</textarea>
                    </div>
                    <textarea id="topic_ids" name="topic_ids" style="display: none;"></textarea>
                    <div class="form-group">
                        <input type="submit" value="Update" class="button button-s shadow-large button-round-small bg-green1-dark top-10 pull-right">
                    </div>
                </form>
            </div>
        </div><!-- .post-inner -->
    </div><!-- .post-content -->
@endsection

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    


    <script> 



$(document).on('click', '.intClk', function (e) {

    e.preventDefault();



    var post = $(this).data('post');



    console.log(post);


    if ($(this).prop("checked")) {

            // checked

        $('#interest'+post).prop('checked', false);	

        $(this).addClass('inactive');				}

    else{

        $('#interest'+post).prop('checked', true);

        $(this).removeClass('active');

    }

});



$(document).on('click', '.dislike', function (e) {

        e.preventDefault();



        var post = $(this).data('post');



        $(this).addClass('actv');



        $.ajax({

            type:"POST",

            url:"https://beta2.agwiki.com/dislike",

            data: {post_id: post, _token: '5nSikQmKzLvqLGcZcLrQuTqu1DqcfeZyhGZm4f0e'},

            success:function(data){

                if (data.success && data.success == 1) {

                    if (data.message) {

                    //  toastr.success(data.message);

                    }

                }

            }

        });



});



$(document).on('click', '.topiclist', function (e) {

    e.preventDefault();



    var post = $(this).data('post');



    console.log(post);

    $(this).removeClass('inactive');

    $(this).addClass('active');

    $(this).hide('slow');

    $(this).find('i').remove();



    $('#activeTopicList').append(this);

    $(this).show('slow');

    $(this).removeClass('topiclist');

    // $(this).prependTo('<i class="fas fa-minus-circle"></i>');

    // $('<i class="fas fa-minus-circle"></i>').insertBefore(this).find('span');

    $(this).find('span').prepend('<i class="fas fa-minus-circle"></i>');

    $(this).addClass('remtopic');

    $(this).addClass('topic');





    $.ajax({

        type:"POST",

        url:"https://beta2.agwiki.com/topic",

        data: {topic_id: post, _token: '5nSikQmKzLvqLGcZcLrQuTqu1DqcfeZyhGZm4f0e'},

        success:function(data){

            if (data.success && data.success == 1) {
                
                swal("Topic Added", {
                            icon: "success",
                        });


                if (data.message) {

                //  toastr.success(data.message);

                }

            }

        }

    });



});



$(document).on('click', '.remtopic', function (e) {

    e.preventDefault();



    var post = $(this).data('post');



    console.log(post);

    $(this).addClass('inactive');

    $(this).removeClass('active');

    $(this).hide('slow');



    $.ajax({

        type:"POST",

        url:"https://beta2.agwiki.com/remtopic",

        data: {topic_id: post, _token: '5nSikQmKzLvqLGcZcLrQuTqu1DqcfeZyhGZm4f0e'},

        success:function(data){

            if (data.success && data.success == 1) {

                if (data.message) {

                //  toastr.success(data.message);

                }

            }

        }

    });



});






function passchecked(id){

    

        if ($('#interest'+id).prop("checked")) {
            
                // checked
                

            $('#interest'+id).prop('checked', false);	

            $('#searchint'+id).addClass('inactive');	

            $('#searchint'+id).css("background-color", "white");	

            //$('.topicList').html().remove( $('#searchint'+id+' span').html()+', ');
            var currentvalIds = $('#topic_ids').html();

            currentvalIds = currentvalIds.replace(id+',','');

            $('#topic_ids').html(currentvalIds);



            var currentval = $('.topicList').html();

            currentval = currentval.replace($('#searchint'+id+' span').html()+', ','');

            //console.log(currentval);

            $('.topicList').html(currentval);

            

        }else{    
                    

            $('#interest'+id).prop('checked', true);
            
            $('#searchint'+id).removeClass('active');

            $('#searchint'+id).css("background-color", "#A0D468");

            $('.topicList').append( $('#searchint'+id+' span').html()+', ');

            $('#topic_ids').append(id+',');

        }
    

}

function hide(element){

  // element.style.display = 'none';

  //$(element).hide();

  $(element).removeClass('menu-active');

  

}





$(document).on('click', '.intClk', function (e) {

    e.preventDefault();



    var post = $(this).data('post');



    console.log(post);

    





    if ($(this).prop("checked")) {

            // checked

        $('#interest'+post).prop('checked', false);	

        $(this).addClass('inactive');				}

    else{

        $('#interest'+post).prop('checked', true);

        $(this).removeClass('active');

    }

});












</script>





    <script>
        (function($) {
            $(document).ready(function() {

                

                <?php 

                foreach($currentInterestIDs as $value){                            
                    echo "passchecked(" . $value->interest_id . ");"; 
                                          
                }

                ?>








                $('.select2').select2({
                    width: null,
                    theme: 'bootstrap'
                });

                $(document).on('click', '#addCat', function (e) {
                    e.preventDefault();

                    var name = $('#new_cat').val();

                    $.ajax({
                        type:"POST",
                        url:"{{ route('user.cat.store') }}",
                        data: {name: name, _token: '{{ csrf_token() }}'},
                        success:function(data){
                            if (data.success && data.success == 2) {
                                toastr.warning('Category Already Exists. Just Select');
                            } else if (data.success && data.success == 1) {

                                var html = '<option value="' + data.id + '">' + data.text + '</option>';
                                $('#category').append(html).select2('destroy').val(null);

                                $('#category').select2({
                                    width: null,
                                    theme: 'bootstrap'
                                });

                                toastr.success('Category Added');

                            } else {
                                toastr.error('Unexpected Error. please try Again.');
                            }
                        }
                    });
                });

                $(document).on('change', '#post_image', function(e) {

                    if (this.files.length) {

                        var file = this.files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;

                            $('#image_container').attr('src', data);
                        };

                        reader.readAsDataURL(file);

                    }

                });

            });
        })(jQuery);
    </script>
@endsection
