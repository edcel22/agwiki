@extends('layouts.dash')

@section('title', 'Reset Password')

@section('content')
       <div class="row">
        <div class="col-md-8 col-md-offset-2" >
            <div class="col-md-5 col-md-offset-2">
            	<img src="https://agwiki.com/assets/front/img/logo.png">
                <br>
                <h3>Reset Password</h3>
                <br>
                <form method="POST" action="{{ route('reset.passw') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $reset->token }}">
                    <div class="form-group input-style has-icon input-style-1 input-required bottom-30">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ $reset->email }}" required readonly>
                    </div>
                    <div class="form-group input-style has-icon input-style-1 input-required bottom-30">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required autofocus>
                    </div>
                    <div class="form-group input-style has-icon input-style-1 input-required bottom-30">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <input class="button button-full button-m shadow-large button-round-small bg-blue1-dark top-20" type="submit" value="Submit" >
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
