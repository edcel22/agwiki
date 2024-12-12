@extends('layouts.profile')

@section('css')
<style>
.videopopupcls:hover{cursor: pointer;}
</style>
@endsection
@section('content')
    <div class="post-loop-wrapper">
        @if($albumdata && count($albumdata))
            <div class="post-loop-inner">
                <div class="top-author-list">
                    
                    <div class="row">
                        <div class="col-md-10"><h4 class="title">Album Name :{{ $page_title }}</h4></div>
                        <div class="col-md-2">
                            <a href="{{ route('user.profile.videos', $user->username) }}" class="btn btn-primary">Back</a> 
                        </div>
                    </div>
                   
                        <div class="row popupgallery">
                            @foreach($albumdata as $video)
                                <div class="col-md-3">
                                    @if (strpos($video->value, '.mp4') !== false) 
                                        <video width="125" height="125" class="videopopupcls" type="mp4" link="{{ asset('assets/front/content/'.$video->value) }}">
                                            <source src="{{ asset('assets/front/content/'.$video->value) }}" type="video/mp4">  
                                        </video>
                                    @elseif (strpos($video->value, 'www.youtube.com') !== false) 
                                        @php
                                            $youtubevideo=explode('?v=',$video->value);
                                        @endphp
                                        <img width="125" height="125" src="https://img.youtube.com/vi/{{$youtubevideo[1]}}/0.jpg" class="videopopupcls" type="youtube" link="{{ $youtubevideo[1] }}">
                                    @else
                                        @php
                                            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video->value.php"));
                                        @endphp
                                        <img width="125" height="125" src="{{$hash[0]['thumbnail_medium']}}" class="videopopupcls" type="vimeo" link="{{ $video->value }}">

                                    @endif <p></p>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
        @else
            <div class="col-md-12 single text-center">No Album Photos Found.</div>
        @endif
    </div>

<!-- video modal start -->
<div class="modal fade" id="videoModal" role="dialog">
    <div  class="modal-dialog modal-lg" style="width:600px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="videohtmldiv" >
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div> 
<!-- video modal end -->

@endsection

@section('js')
<script type="text/javascript">

$(document).ready(function(){
    $(document).on('click','.videopopupcls',function(){
        var type=$(this).attr('type');
        var link=$(this).attr('link');
        if(type=='mp4' || type=='webm'){
            var html='<video controls width="567" height="400"><source src='+link+' type="video/'+type+'"></video>';
        }
        else if(type=='youtube'){
            var html='<iframe width="567" height="400" src="https://www.youtube.com/embed/'+link+'" frameborder="0" allowfullscreen allowtransparency allow="autoplay"></iframe>';
        }
        else{
            var html='<iframe width="567" height="400" src="https://player.vimeo.com/video/'+link+'?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>';
        }
        $('#videohtmldiv').html(html);
        $('#videoModal').modal('show');
    });
});
</script>
@endsection