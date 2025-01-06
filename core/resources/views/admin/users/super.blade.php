@extends('admin.layout.master')

@section('body')



    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{$data['page_title']}} </h3>
            <hr>
            <div class="row">

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-edit font-blue-sharp"></i>
                                    <span class="caption-subject font-blue-sharp bold uppercase">Edit Superuser</span>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <form method="post" enctype="multipart/form-data">

                                    @csrf
                                    {{ method_field('PUT') }}

                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="{{ asset('assets/front/img/' . $user->avatar) }}" alt="{{ $user->name }}" class="img-responsive" id="avatar-cont">
                                            <div class="form-group crossposting-input" style="text-align: center;">
                                                <label for="avatar" class="btn btn-sm btn-success btn-block">Change Avatar</label>
                                                <input type="file" id="avatar" name="avatar" class="form-control" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="name" class="control-label">Name*</label>
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <br>
                                            <div class="form-group crossposting-input">
                                                <label for="position" class="control-label">Position*</label>
                                                <input type="text" id="position" name="position" class="form-control" value="{{ $user->position }}" required>
                                            </div>
                                            <br>
                                            <div class="form-group crossposting-input">
                                                <label for="gender" class="control-label">Gender*</label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="MALE"{{ ($user->gender == 'MALE')?' selected':'' }}>MALE</option>
                                                    <option value="FEMALE"{{ ($user->gender == 'FEMALE')?' selected':'' }}>FEMALE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="{{ asset('assets/front/img/' . $user->cover) }}" id="cover-cont" class="img-responsive">
                                            <div class="form-group crossposting-input" style="text-align: center;">
                                                <label for="cover" class="btn btn-sm btn-success btn-block">Change Cover</label>
                                                <input type="file" id="cover" name="cover" class="form-control" style="display: none;">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="work" class="control-label">Job Title*</label>
                                                <input type="text" id="work" name="work" class="form-control" value="{{ $user->work }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="workplace" class="control-label">Workplace*</label>
                                                <input type="text" id="workplace" name="workplace" class="form-control" value="{{ $user->workplace }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="mobile" class="control-label">Mobile*</label>
                                                <input type="text" id="mobile" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="quote" class="control-label">Quote*</label>
                                                <textarea id="quote" name="quote" class="form-control" required>{{ $user->quote }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="country" class="control-label">Country*</label>
                                                <select name="country" id="country" class="form-control">
                                                    @foreach(countries() as $code => $name)
                                                        @if($user->country == $code)
                                                            <option value="{{ $code }}" selected>{{ $name }}</option>
                                                        @else
                                                            <option value="{{ $code }}">{{ $name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="city" class="control-label">City*</label>
                                                <input type="text" id="city" name="city" class="form-control" value="{{ $user->city }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="state" class="control-label">State*</label>
                                                <input type="text" id="state" name="state" class="form-control" value="{{ $user->state }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group crossposting-input">
                                                <label for="zip" class="control-label">Zip*</label>
                                                <input type="text" id="zip" name="zip" class="form-control" value="{{ $user->zip }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="portlet light bordered">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-key font-blue-sharp"></i>
                                                <span class="caption-subject font-blue-sharp bold uppercase">Change Account Access. If password (Leave Blank For No Change)</span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username" class="control-label">Username*</label>
                                                        <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label">Email*</label>
                                                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password" class="control-label">New Password</label>
                                                        <input type="password" id="password" name="password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password_confirmation" class="control-label">Confirm New Password</label>
                                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br><br><br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-lg btn-success btn-block" type="submit">Update Profile</button>
                                        </div>
                                    </div>
                                    <br><br>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            </div>
        </div>

@endsection

@section('script')
    <script>
        (function($) {
            $(document).ready(function () {
                $(document).on('change', '#avatar', function(e) {

                    if (this.files.length) {

                        var file = this.files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;

                            $('#avatar-cont').attr('src', data);
                        };

                        reader.readAsDataURL(file);

                    }

                });

                $(document).on('change', '#cover', function(e) {

                    if (this.files.length) {

                        var file = this.files[0];
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var data = e.target.result;

                            $('#cover-cont').attr('src', data);
                        };

                        reader.readAsDataURL(file);

                    }

                });
            })
        })(jQuery);
    </script>
@endsection