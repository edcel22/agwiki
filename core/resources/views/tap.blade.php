@extends('layouts.auth')

@section('title', 'Terms of Services')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="background: #1A2735 !important;">
            <h1 class="text-center">Terms of Services</h1>
            {!! $gnl->tap !!}
        </div>
    </div>
@endsection