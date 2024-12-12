@extends('layouts.auth')

@section('content')
  @if (Auth::user()->status != 1)
      <div class="row">
        <div class="col-md-6 col-md-offset-5" style="background: #FFF !important; padding: 30px">

            <h2>Welcome!</h2>
            <h4>We're reviewing your account. We'll email you as soon is your account is activated. Thanks for registering for AgWiki. <br><br>Together we can make a difference.</h4>

        </div>
      </div>

  @elseif (Auth::user()->emailv != 1)

      <div class="row">
          <div class="col-md-6 col-md-offset-5" style="background: #FFF !important; padding: 30px">

                  <form method="POST" action="{{ route('emailverify') }}">
                      @csrf
                      <br>
                      <h3>Please verify your Email</h3>
                      <br>
                      <a class="btn-lg btn-lg-block btn-lg-default" href="{{ route('sendemailver') }}">
                          Send Verification Code
                      </a>
                      <br>
                      <div class="form-group crossposting-input">
                          <input class="form-control" type="text" name="code" placeholder="Enter Verification Code" required>
                      </div>
                      <div class="form-group crossposting-input">
                          <button class="btn-lg btn-lg-block btn-lg-success">
                              Verify
                          </button>
                      </div>

                  </form>

          </div>
      </div>
  @elseif(Auth::user()->smsv != 1)

      <div class="row">
          <div class="col-md-6 col-md-offset-5" style="background: #FFF !important; padding: 30px">

                  <form method="POST" action="{{ route('smsverify') }}">
                      @csrf
                      <br>
                      <h3>Please verify your Mobile</h3>
                      <br>
                      <a class="btn-lg btn-lg-block btn-lg-default" href="{{ route('sendsmsver') }}">
                          Send Verification Code
                      </a>
                      <br>
                      <div class="form-group crossposting-input">
                          <input class="form-control" type="text" name="code" placeholder="Enter Verification Code" required>
                      </div>
                      <div class="form-group crossposting-input">
                          <button class="btn-lg btn-lg-block btn-lg-success">
                              Verify
                          </button>
                      </div>

                  </form>

          </div>
      </div>
  @endif
@endsection
