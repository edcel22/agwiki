@extends('layouts.profile')

@section('css')
@endsection

@section('content')
    <div class="post-loop-wrapper">
        @if($albumdata && count($albumdata))
            <div class="post-loop-inner">
                <div class="top-author-list">
                    
                    <div class="row">
                        <div class="col-md-10"><h4 class="title">Album Name :{{ $page_title }}</h4></div>
                        <div class="col-md-2">
                            <a href="{{ route('user.profile.photos', $user->username) }}" class="btn btn-primary">Back</a> 
                        </div>
                    </div>
                   
                        <div class="row popupgallery">
                            @foreach($albumdata as $img)
                                <div class="col-md-3">
                                    @if($img->value!='' && file_exists('./assets/front/content/'.$img->value))
                                    <a href="{{ asset('assets/front/content/'.$img->value) }}"><img src="{{ asset('assets/front/content/'.$img->value) }}" width="125" height="125"></a>
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



@endsection

@section('js')
<script type="text/javascript">

 $(window).load(function(){
    $('.popupgallery a').simpleLightbox();
});
</script>
@endsection