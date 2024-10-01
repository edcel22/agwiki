@extends('layouts.user')

@section('content')
        <div class="col-md-12 single infinite-scroll">
            <h2 class="text-center">{{ $page_title }}</h2>
            @if($actions && count($actions))
                @php
                    $dup = [];
                @endphp
                @foreach($actions as $action)
                    @if($action->user && ! in_array($action->user->id, $dup))
                        @php
                            $dup[] = optional($action->user)->id;
                        @endphp
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ asset('assets/front/img/' . optional($action->user)->avatar) }}" alt="{{ optional($action->user)->name }}" class="media-object" style="width:60px">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="{{ route('profile', optional($action->user)->username) }}">{{ optional($action->user)->name }} <small>{{ optional($action->user)->position }}</small></a></h4>
                            </div>
                        </div>
                    @endif
                @endforeach
                {{ $actions->links() }}
            @endif
        </div>
@endsection

@section('js')
    <script src="{{ asset('assets/front/js/jquery.jscroll.min.js') }}"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<li style="text-align: center;">Loading...</li>',
                padding: 0,
                nextSelector: 'ul.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
@endsection