@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="background: #1A2735 !important;">
            <div class="col-md-5 col-md-offset-2">
                <br>
                <h3>Reset Password</h3>
                <br>
                <form method="POST" action="{{ route('forgot.pass') }}">
                    @csrf
                    <div class="form-group crossposting-input">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg">Send Password Reset Link</button>
                </form>
                <br>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2" style="background: #1A2735 !important;padding: 20px 10px;">
            <div class="col-md-5 col-md-offset-2">
                <a href="{{ route('login') }}">Login »</a>
            </div>
        </div>
    </div>
@endsection
