@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper"> 
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{ $data['page_title'] }}</h3>
            <hr>


            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-envelope font-blue-sharp"></i>
                                <span class="caption-subject font-blue-sharp bold uppercase">Broadcast Newsletter (For testing only)</span>
								<p>This will send a newsletter, in the approved email template, with the header and footer messsages - with 4 posts from their feed</p>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form" method="POST" action="{{route('broadcast.newsletter')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-body">
									<div class="form-group">
                                        <label>Test Email (must be in the system)</label>
                                        <input type="text" class="form-control" name="email" >
                                    </div>
                                   
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="submit-btn btn btn-primary btn-lg btn-block login-button">Broadcast Newsletter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection