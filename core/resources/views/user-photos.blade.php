@extends('layouts.profile')

@section('css')
<style>
.pagi ul.pagination { display: block !important; text-align: center; }

.albumanchor{ font-size: 18px !important; color: #eaeaea !important; margin-top: -8px !important;}
.popupgallery{margin-top: 15px;}
</style>
@endsection
@section('content')
    <div class="post-loop-wrapper">
        @if($userimgs && count($userimgs))
            <div class="post-loop-inner">
                <div class="top-author-list">
                    
                    <div class="row">
                        <div class="col-md-6"><h4 class="title">{{ $page_title }}</h4></div>
                        <div class="col-md-6">
                            <a data-toggle="modal" data-target="#imagealbum" class="albumanchor btn btn-primary">Create Album</a>
                            <a href="{{ route('user.photo.album', $user->username) }}" class="albumanchor btn btn-primary">Albums</a> 
                        </div>
                    </div>
                    
 
                        <div class="row popupgallery">
                            @foreach($userimgs as $img)
                                <div class="col-md-3">
                                    @if($img->link!='' && file_exists('./assets/front/content/'.$img->link))
                                    <a href="{{ asset('assets/front/content/'.$img->link) }}"><img src="{{ asset('assets/front/content/'.$img->link) }}" width="125" height="125"></a>
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

<!-- imagealbum modal start -->
<div class="modal fade" id="imagealbum" role="dialog">
    <div  class="modal-dialog modal-lg" style="width:600px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
    <form method="post" action="{{ route('user.create.album') }}" enctype="multipart/form-data">
        <div class="modal-body">
            
            @csrf
            <input type="hidden" name="albumtype" id="albumtype" value="image">
            <div class="form-group">
            <label for="exampleInputEmail1">Album name</label>
            <input type="text" name="albumname" id="albumname" required="true" class="form-control" value="">
          </div>
            <div class="row">
                @foreach($userimgs as $img)
                    <div class="col-md-3">
                        @if($img->link!='' && file_exists('./assets/front/content/'.$img->link))
                        <img src="{{ asset('assets/front/content/'.$img->link) }}" width="125" height="125">
                        <input type="checkbox" name="images[]" value="{{ $img->link }}">
                        @endif
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
<!-- imagealbum modal end -->

@endsection

@section('js')
<script type="text/javascript">
 $(document).ready(function(){
    $('.popupgallery a').simpleLightbox();

    $(document).on('click','#submitalbumbtn',function(){
        var albumname=$('#albumname').val();
        var checkedcnt=$('input[name="images[]"]:checked').length;
        if(albumname==''){
            alert('Please enter album name');
            $('#albumname').focus();
            return false;
        }
        else if(checkedcnt==0){
            alert('Please check checkbox you want show image in album');
            return false;
        }
        else{}
    });
});
</script>
@endsection