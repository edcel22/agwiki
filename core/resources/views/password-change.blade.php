@extends('layouts.auth')

@section('content')

    <div class=" single page-content">
        <h4 class="text-center">{{ $page_title }}</h4><Br>

        <form method="post">

            @csrf
            {{ method_field('PUT') }}

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="current_password" class="control-label">Current Password*</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="password" class="control-label">New Password*</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="password_confirmation" class="control-label">Confirm New Password*</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
            </div>

            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <button class="bbtn btn-lg btn-success btn-block button button-full button-s shadow-large button-round-small bg-green1-dark top-10" type="submit">Update Password</button>
                </div>
            </div>
            <br><br>

        </form>
    </div>

@endsection