<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ ((isset($page_title))?$page_title:'Home') }} | {{ $gnl->title }}</title>
    <meta name="Title" Content="{{ ((isset($page_title))?$page_title:'Home') }} | {{ $gnl->title }}">
    <meta name="robots" content="index,follow" /> 
    <meta name="Googlebot" content="index, follow, all" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/img/icon.png') }}" />
    <meta property="og:title" content="{{ ((isset($page_title))?$page_title:'Home') }} | {{ $gnl->title }}"/>
    <meta property="og:site_name" content="{{ $gnl->title }}"/>
    @yield('meta')
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/front/img/icon.png') }}"/>
		<link rel="stylesheet" href="/assets/front/css/auth.css">
    @include('custom.header')
</head>

@php 
    $theUser = '';
    $loggedIn = false;
@endphp

@php
    if (Auth::check()) {
        $theUser = Auth::user();
        $loggedIn = true;
    } else {
        $theUser = $user;  
    }
@endphp

<body class="theme-light" data-highlight="blue2">

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ZRS2J9"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

@if(!strstr($_SERVER['REQUEST_URI'],'/message/'))
    <style>
        .post p.excerpt a {
            overflow-wrap: break-word;
            word-wrap: break-word;
            -ms-word-break: break-all;
            word-break: break-all;
            word-break: break-word;
            -ms-hyphens: auto;
            -moz-hyphens: auto;
            -webkit-hyphens: auto;
            hyphens: auto;
        }

        .mysticky-welcomebar-fixed-wrap {
            min-height: 60px;
            padding: 20px 50px 0px 50px ;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background-color: #66E0A3;
            z-index: 10000;
            margin-bottom: 0px;
        }
        
        .mysticky-welcomebar-btn a {
            background-color: #000;
            font-family: inherit;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            vertical-align: top;
            line-height: 1.2;
            font-size: 16px;
            font-weight: 400;
            padding: 5px 20px;
            white-space: nowrap;
            margin-bottom: 27px;
            margin-left: 10px;
        }

        .sidebar {
            /* margin-top: 100px; */
        }
    </style>
@endif

@if (session('status'))
    <div class="alert-large status" role="alert">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert-large error" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif

@if (session('alert'))
    <div class="alert-large" role="alert">
        {{ session('alert') }}
    </div>
@endif

@if (session('message'))
    <div class="alert-large message" role="alert">
        {{ session('message') }}
    </div>
@endif

@if(session('success'))
    <div class="alert-large success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div id="page-preloader">
    <div class="loader-main"><div class="preload-spinner border-highlight"></div></div>
</div>

<div id="page">
    @if(!$loggedIn)
        <div class="auth-layout__login-container-wrapper">
            <div class="auth-layout__login-container-content">
                <a href="/">
                    <img src="/assets/front/img/logo_md.png"
                         alt="AgWiki, Solving World Food Problems Socially"
                         class="logo-image">
                </a>
                <a class="login-button button button-m button-round-small bg-blue1-dark shadow-small" href="/login">
                    Login
                </a>
            </div>
        </div>
    @endif

    @include('custom.sidebar')

    @yield('content')
</div>

<div class="menu-hider"></div>

@include('custom.footer')

<script type='text/javascript'>
    function registerPopup() {
        const el = document.createElement('div')
        el.innerHTML = "<a href='/login'>Please use this link to sign up</a>"
        swal({
            title: "Register for full access to all AgWiki features", 
            content: el,
        });
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js" defer></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js defer"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" defer></script>
<script src="/assets/front/js/jquery.jscroll.min.js"></script>
<script type='text/javascript' src="https://jakiestfu.github.io/Mention.js/javascripts/bootstrap-typeahead.js" defer></script>

<script>
    $(document).ready(function () {
        // Your JavaScript code here for various features
    });
</script>

@yield('js')

<script type="text/javascript" src="/assets/front/js/plugins.js" async></script>
<script type="text/javascript" src="/assets/front/js/custom.js" async></script>

@section('js')
    <script src="https://cdn.plyr.io/3.2.4/plyr.js" defer></script>
    <script src="https://cdn.rawgit.com/zenorocha/clipboard.js/v2.0.0/dist/clipboard.min.js" defer></script>
    <script src="/assets/front/twitter/emojionearea.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smoothState.js/0.7.2/jquery.smoothState.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js" defer></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b028cce69cdbe02" defer></script>
    <script>
        const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));
        $(document).on('change', '#audio', function(e) {
            // Audio change handler
        });
    </script>
@endsection

<script src="{{ asset('js/feed/sharepost.js') }}" defer></script>
<script src="{{ asset('js/feed/feed.js') }}" defer></script>
</body>
</html>
