@extends('layouts.auth')

@section('title', 'Privacy Policy')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="background: #1A2735 !important;">
            <h1 class="text-center">Privacy Policy</h1>
            {!! $gnl->pp !!}
        </div>
    </div>
@endsection 