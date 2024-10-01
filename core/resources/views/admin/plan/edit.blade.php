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
                                <strong><i class="fa fa-info-circle"></i> Edit Plan</strong>
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body" style="overflow: hidden">
                            <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-body">


                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Plan Name</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="name" value="{{ $plan->name }}" required type="text" placeholder="Plan Name">
                                                        <span class="input-group-addon"><i class="fa fa-cloud-upload"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Plan Price</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="price" value="{{ $plan->price }}" required type="text" placeholder="Plan Price">
                                                        <span class="input-group-addon">{{ $gnl->currency }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Write Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="write_payment" value="{{ $plan->write_payment }}" required type="text" placeholder="Write Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Write Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="write_max" value="{{ $plan->write_max }}" required type="text" placeholder="Write Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Write Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="write_compound" id="write_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->write_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->write_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Read Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="read_payment" value="{{ $plan->read_payment }}" required type="text" placeholder="Read Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Read Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="read_max" value="{{ $plan->read_max }}" required type="text" placeholder="Read Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Read Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="read_compound" id="read_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->read_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->read_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">View Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="view_payment" value="{{ $plan->view_payment }}" required type="text" placeholder="View Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">View Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="view_max" value="{{ $plan->view_max }}" required type="text" placeholder="View Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">View Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="view_compound" id="view_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->view_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->view_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Like Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="like_payment" value="{{ $plan->like_payment }}" required type="text" placeholder="Like Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Like Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="like_max" value="{{ $plan->like_max }}" required type="text" placeholder="Like Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Like Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="like_compound" id="like_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->like_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->like_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Comment Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="comment_payment" value="{{ $plan->comment_payment }}" required type="text" placeholder="Comment Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Comment Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="comment_max" value="{{ $plan->comment_max }}" required type="text" placeholder="Comment Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Comment Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="comment_compound" id="comment_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->comment_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->comment_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Timeline Share Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="timeline_share_payment" value="{{ $plan->timeline_share_payment }}" required type="text" placeholder="Timeline Share Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Timeline Share Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="timeline_share_max" value="{{ $plan->timeline_share_max }}" required type="text" placeholder="Timeline Share Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">timeline Share Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="timeline_share_compound" id="timeline_share_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->timeline_share_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->timeline_share_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Social Share Payment</strong></label>
                                                <div class="col-sm-12">
                                                    <div class="input-group mb15">
                                                        <input class="form-control input-lg bold" name="social_share_payment" value="{{ $plan->social_share_payment }}" required type="text" placeholder="Social Share Payment">
                                                        <span class="input-group-addon"><strong>{{ $gnl->currency }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Social Share Maximum </strong></label>
                                                <div class="col-sm-12">
                                                    <input class="form-control input-lg bold" name="social_share_max" value="{{ $plan->social_share_max }}" required type="text" placeholder="Social Share Maximum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12"><strong style="text-transform: uppercase;">Social Share Compound </strong></label>
                                                <div class="col-sm-12">
                                                    <select name="social_share_compound" id="social_share_compound" class="form-control input-lg bold" required>
                                                        <option value="daily" @if($plan->social_share_compound == 'daily') selected @endif>DAILY</option>
                                                        <option value="monthly" @if($plan->social_share_compound == 'monthly') selected @endif>MONTHLY</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-block uppercase btn-lg"><i class="fa fa-send"></i> Update Plan</button>
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