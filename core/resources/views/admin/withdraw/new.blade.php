@extends('admin.layout.master')

@section('content')

@endsection



@extends('admin.layout.master')

@section('body')

    <div class="page-content-wrapper">
        <div class="page-content">

            <h3 class="page-title uppercase bold"> {{ $data['page_title'] }}</h3>
            <hr>


            <div class="row">
                <div class="col-md-12">

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <strong><i class="fa fa-plus"></i> Add New Withdraw Method</strong>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body" style="overflow: hidden">
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-body">

                                    {{ csrf_field() }}
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Method Name</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="name" value="" required type="text" placeholder="Method Name">
                                                        <span class="input-group-addon"><i class="fa fa-cloud-upload"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Method Photo</strong></label>
                                                <div class="col-sm-12">
                                        <span class="btn green fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                <span> Upload New Photo </span>
                                                <input type="file" name="image" class="form-control input-lg" value="" required>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Minimum </strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="withdraw_min" value="" required type="text" placeholder="Minimum">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="withdraw_max" value="" required type="text" placeholder="Maximum">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Processing Time </strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="duration" value="" required type="text" placeholder="Processing Time">
                                                        <span class="input-group-addon"><strong>Days</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Fix Charge </strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="fix" value="" required type="text" placeholder="Fix Charge">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Percentage </strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="percent" value="" required type="text" placeholder="Percentage">
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Status </strong></label>
                                                <div class="col-sm-12">
                                                    <input data-toggle="toggle" checked data-onstyle="success" data-offstyle="danger" data-width="100%" data-size="large" type="checkbox" name="status">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-block uppercase btn-lg"><i class="fa fa-send"></i> Add Withdraw Method</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
