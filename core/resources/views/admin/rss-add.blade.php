@extends('admin.layout.master')

@section('body')

    <div class="single page-content page-content-wrapper">
    <div class="page-content">
        <h4 class="text-center">New Feed</h4>

        <form method="post" action="{{ route('admin.rss.store') }}" enctype="multipart/form-data">

            @csrf

            <!--<div class="row">
                <div class="col-md-12">
                    <img src="http://via.placeholder.com/1170x500?text=Change+Cover" id="cover-cont" class="img-responsive">
                    <div class="form-group crossposting-input input-style-1" style="text-align: center;">
                        <label for="cover" class="btn btn-sm btn-success btn-block">Change Cover</label>
                        <input type="file" id="cover" name="cover" class="form-control input-style-1" style="display: none;">
                    </div>
                </div>
            </div>

            <br>-->
            
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Title*</label>
                        <input type="text" id="title" name="title" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">URL*</label>
                        <input type="text" id="url" name="url" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
                <div class="col-md-4">
                    <div class="form-group crossposting-input input-style-1">
                        <label for="name" class="control-label">Description*</label>
                        <input type="text" id="description" name="description" class="form-control input-style-1" required>
                    </div>
                    
           		</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span>Topics: </span>
                    
                    <div class="col-md-12" >
                        
                        <div class="form-group form-check crossposting-input input-style-1">
                            @foreach($interest as $int)
                                <div class="col-md-6">
                                <label style="width:50%; float:left" for="interest{{$int->id}}">{{$int->name}}</label>
                                <input style="width:50%; float:left"  type="checkbox" class="form-control input-style-1" name="interest[]" id="interest{{$int->id}}" value="{{$int->id}}" > 
                                </div>
                            @endforeach
                        </div>
                        </div>
                    
                </div>

            <br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-success btn-block button button-full button-s shadow-large button-round-small bg-green1-dark top-10" type="submit">Save Feed</button>
                </div>
            </div>
            <br><br>

        </form>
    
    
    
</div>
</div>
@endsection

@section('js')

    <script>
        (function($) {

            {{--$(document).on('change', '#avatar', function(e) {

                if (this.files.length) {

                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var data = e.target.result;

                        $('#avatar-cont').attr('src', data);
                    };

                    reader.readAsDataURL(file);

                }

            });--}}

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

        })(jQuery);
    </script>

@endsection