@extends('layouts.profile')

@section('css')
<style>
.pagi ul.pagination {display: block !important; text-align: center;}
.albumanchor{ font-size: 18px !important; color: #eaeaea !important; margin-top: -8px !important;}
.videopopupcls:hover{cursor: pointer;}
</style>
@endsection
@section('content')
    <div class="post-loop-wrapper">
        @if($uservideos && count($uservideos))
            <div class="post-loop-inner">
                <div class="top-author-list">
                    <div class="row">
                        <div class="col-md-6"><h4 class="title">{{ $page_title }}</h4></div>
                        <div class="col-md-6">
                            <a data-toggle="modal" data-target="#videoalbum" class="albumanchor btn btn-primary">Create Album</a>
                            <a href="{{ route('user.video.album', $user->username) }}" class="albumanchor btn btn-primary">Albums</a> 
                        </div>
                    </div>
                        <div class="row">
                            @foreach($uservideos as $video)
                                <div class="col-md-3">

                                    @if($video->type=='video')

                                        @if($video->link!='' && file_exists('./assets/front/content/'.$video->link))
                                            @php 
                                                $res=explode('.',$video->link);
                                            @endphp
                                            <video width="125" height="125" class="videopopupcls" type="{{ $res[1]=='mp4'?'mp4':'webm' }}" link="{{ asset('assets/front/content/'.$video->link) }}">
                                                @if($res[1]=='mp4')
                                                   <source src="{{ asset('assets/front/content/'.$video->link) }}" type="video/mp4">  
                                                @else
                                                     <source src="{{ asset('assets/front/content/'.$video->link) }}" type="video/webm">
                                                @endif
                                             </video>
                                        @endif
                                    @elseif($video->type == 'vimeo')
                                        @php
                                            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video->link.php"));
                                        @endphp
                                        <img width="125" height="125" src="{{$hash[0]['thumbnail_medium']}}" class="videopopupcls" type="vimeo" link="{{ $video->link }}">
                                    @else
                                        @php
                                            $youtubevideo=explode('?v=',$video->link);
                                        @endphp
                                        <img width="125" height="125" src="https://img.youtube.com/vi/{{ isset($youtubevideo[1])?$youtubevideo[1]:$youtubevideo[0] }}/0.jpg" class="videopopupcls" type="youtube" link="{{ isset($youtubevideo[1])?$youtubevideo[1]:$youtubevideo[0] }}">
                                        
                                    @endif
                                    <p></p>
                                </div>
                            @endforeach
                        </div>
                        <div class="pagi">
                            {{ $records->links() }}
                        </div>
                </div>
            </div>
        @else
            <div class="col-md-12 single text-center">No Photos Found.</div>
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


<!-- videoalbum modal start -->
<div class="modal fade" id="videoalbum" role="dialog">
    <div  class="modal-dialog modal-lg" style="width:600px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    <form method="post" action="{{ route('user.create.album') }}" enctype="multipart/form-data">
        <div class="modal-body">
            
            @csrf
            <input type="hidden" name="albumtype" id="albumtype" value="video">
            <div class="form-group">
            <label for="exampleInputEmail1">Album name</label>
            <input type="text" name="albumname" id="albumname" required="true" class="form-control" value="">
          </div>
            <div class="row">
                @foreach($uservideos as $video)
                    <div class="col-md-3">

                        @if($video->type=='video')

                            @if($video->link!='' && file_exists('./assets/front/content/'.$video->link))
                                @php 
                                    $res=explode('.',$video->link);
                                @endphp
                                <video width="125" height="125" type="{{ $res[1]=='mp4'?'mp4':'webm' }}" link="{{ asset('assets/front/content/'.$video->link) }}">
                                    @if($res[1]=='mp4')
                                       <source src="{{ asset('assets/front/content/'.$video->link) }}" type="video/mp4">  
                                    @else
                                         <source src="{{ asset('assets/front/content/'.$video->link) }}" type="video/webm">
                                    @endif
                                 </video>
                            @endif
                        @elseif($video->type == 'vimeo')
                            @php
                                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video->link.php"));
                            @endphp
                            <img width="125" height="125" src="{{$hash[0]['thumbnail_medium']}}" type="vimeo" link="{{ $video->link }}">
                        @else
                            @php
                                $youtubevideo=explode('?v=',$video->link);
                            @endphp
                            <img width="125" height="125" src="https://img.youtube.com/vi/{{ isset($youtubevideo[1])?$youtubevideo[1]:$youtubevideo[0] }}/0.jpg" type="youtube" link="{{ isset($youtubevideo[1])?$youtubevideo[1]:$youtubevideo[0] }}">
                        @endif
                         <input type="checkbox" name="images[]" value="{{ $video->link }}">
                    </div>
                @endforeach
            </div>
           
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn-success" id="submitalbumbtn">Submit</button>
          <button type="button" class="btn-primary" data-dismiss="modal">Cancel</button>
        </div>
    </form>
      </div>
    </div>
</div> 
<!-- videoalbum modal end -->
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


    $(document).on('click','#submitalbumbtn',function(){
        var albumname=$('#albumname').val();
        var checkedcnt=$('input[name="images[]"]:checked').length;
        if(albumname==''){
            alert('Please enter album name');
            $('#albumname').focus();
            return false;
        }
        else if(checkedcnt==0){
            alert('Please check checkbox you want show video in album');
            return false;
        }
        else{}
    });

  });
</script>
@endsection
