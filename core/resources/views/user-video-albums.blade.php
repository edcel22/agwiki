@extends('layouts.profile')

@section('css')
@endsection
@php
use \App\Http\Controllers\FrontController
@endphp
@section('content')
<img id="loaderimg" src="{{ url('assets/front/img/loader.gif') }}">
    <div class="post-loop-wrapper">
        @if($albums && count($albums))
            <div class="post-loop-inner">
                <div class="top-author-list">
                    
                    <div class="row">
                        <div class="col-md-10"><h4 class="title">{{ $page_title }}</h4></div>
                        <div class="col-md-2">
                            <a href="{{ route('user.profile.videos', $user->username) }}" class="btn btn-primary">Back</a> 
                        </div>
                    </div>
                    <div class="row">
                            @foreach($albums as $album)
                                
                                    @php
                                    FrontController::getalbumimg($album->id,'video')
                                    @endphp
                               
                            @endforeach
                        </div>
                        
 
                        
                </div>
            </div>
        @else
            <div class="col-md-12 single text-center">Video Album Not Found.</div>
        @endif
    </div>



@endsection

@section('js')
<script type="text/javascript">
    

    $(document).ready(function(){
        $('.popupgallery a').simpleLightbox();
        $(document).on('click', '.delalbum', function(e) {

                    e.preventDefault();

                    var albumid = $(this).attr('data');
                    var type = $(this).attr('type');

                    swal({
                      title: "Are you sure? You Want To Delete This Album.",
                      text: "Once deleted, you will not be able to recover this album.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            $("#loaderimg").show();
                            $.ajax({
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    albumid: albumid,
                                    type:type
                                },
                                url: '{{ route('user.album.delete') }}', 
                                type: 'POST',
                                success: function(response) {
                                    window.location.href=response;
                                }
                            });
                      }
                    });

                });

    });
</script>
@endsection