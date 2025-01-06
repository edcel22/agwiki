@extends('admin.layout.master')

@section('body')
    
        
 
<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> {{$data['page_title']}} </h3>
<hr>
    <div class="row page-bar-btn">
        <div class="col-md-6 col-md-offset-3">
            <!-- BEGIN PORTLET-->
            <div class="portlet light form-fit">
                <div class="portlet-body">
                    <!-- BEGIN FORM-->
                    <form action="{{route('logo.update')}}" class="form-horizontal form-bordered" method="post"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <img src="{{ asset('assets/front/img/logo.png') }}" class="img-responsive">
                                    <label for="logo" class="btn btn-success">Select Logo</label>
                                    <input type="file" name="logo" id="logo" style="display: none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/front/img/icon.png') }}" class="img-responsive" style="min-width: 100px;">
                                <label for="icon" class="btn btn-success">Select Icon</label>
                                <input type="file" name="icon" id="icon" class="form-control" style="display: none;">
                            </div>
                        </div>
                        <div class="col-md-12 text-center" style="margin-bottom: 25px;">
                            <div class="form-group">
                                <button type="submit" class="btn green btn-lg btn-block">
                                    <i class="fa fa-check"></i> Update
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
</div>
</div>
                    
@endsection