@extends('admin.layout.master')

@section('body')
    <link rel="stylesheet" href="https://cdn.plyr.io/3.3.9/plyr.css">

    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title uppercase bold"> Posts </h3>
            <hr>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <h4 class="text-center">Post of {{ $post->user->name }}</h4>

                    <article>
                        @if($post->type == 'article')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                            </p>
                        @elseif($post->type == 'image')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                            </p>
                            <img src="{{ asset('assets/front/content/' . $post->link) }}" class="img-responsive">
                        @elseif($post->type == 'video')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                            </p>
                            <video class="player" playsinline controls id="{{ str_random(20) }}" style="width: 100%;">
                                <source src="{{ asset('assets/front/content/' . $post->link) }}" type="video/mp4">
                            </video>
                        @elseif($post->type == 'audio')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                            </p>
                            <audio class="player" controls id="{{ str_random(20) }}" style="width: 100%;">
                                <source src="{{ asset('assets/front/content/' . $post->link) }}" type="audio/mp3">
                            </audio>
                        @elseif($post->type == 'youtube')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                            </p>
                            <div class="plyr__video-embed player">
                                <iframe id="{{ str_random(20) }}" src="https://www.youtube.com/embed/{{ $post->link }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                            </div>
                        @elseif($post->type == 'vimeo')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                            </p>
                            <div class="plyr__video-embed player">
                                <iframe id="{{ str_random(20) }}" src="https://player.vimeo.com/video/{{ $post->link }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                            </div>
                        @elseif($post->type == 'doc')
                            <p>
                                {!! preg_replace('/(?:^|\s)#(\w+)/', ' <a href="' . url('tag') . '/$1" style="font-weight: bold;">#$1</a>', $post->content) !!}
                                <div class="doc" style="border: 1px solid aliceblue;padding: 15px;"><div style="max-width: 75%;overflow: hidden;">{{ $post->link }}</div> <a href="{{ asset('assets/front/content/' . $post->link) }}" class="pull-right btn btn-default btn-xs" download style="color: #0c0c0c !important;">Download</a></div>
                            </p>
                            @endif
                    </article>
	
    
    
    			{{$post->scrabingcontent}}
                </div>
                <br><br>
                @if(is_array($reports))
                <div class="col-md-8 col-md-offset-2">
                    <h4>Reports</h4>
                    @foreach($reports as $report)
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ asset('assets/front/img/' . optional($report->user)->avatar) }}" class="media-object" style="width:60px">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{ optional($report->user)->name }}</h4>
                                <p>
                                    {{ $report->content }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    {{ $reports->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.plyr.io/3.2.4/plyr.js"></script>
    <script>
        const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));
    </script>
@endsection