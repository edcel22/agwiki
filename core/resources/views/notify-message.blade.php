@extends('layouts.user')



@section('content')

    <div class="col-md-12">

        <div class="notification-area-start">

            <h2 class="title">{{ $page_title }}</h2>

            <div class="notification-area-wrapper">

                <ul>

                @if(count($messages))

                @foreach($messages as $message)

                    <li>

                        <div class="single-notification-items">

                            <div class="thumb">

                                <img src="{{ asset('assets/front/img/' . optional($message->fromUser)->avatar) }}">

                            </div>

                            <div>

                                 <a href="{{ route('message', optional($message->fromUser)->username) }}"<h4 class="name">{{ optional($message->fromUser)->name }} @if(optional($message->fromUser)->verified == 1)<span class="varified"><i class="fa fa-check-circle"></i></span>@endif <span class="notify-name"><i class="fa fa-envalope" aria-hidden="true"></i> :{{ str_limit($message->content, 50, '...') }}</span></h4></a>

                            </div>

                        </div>

                    </li>

                    @endforeach

                    {{-- $messages->links() --}}

                    @else

                        <li>

                            <div class="single-notification-items">

                                <h4 class="not-found">No Message Found</h4>

                            </div>

                        </li>

                    @endif

                </ul>

            </div>

        </div>

    </div>

@endsection