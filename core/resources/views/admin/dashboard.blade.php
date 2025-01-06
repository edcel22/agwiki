@extends('admin.layout.master')

@section('body')

<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> Dashboard <small>Statistics</small></h3>
<hr>


<div class="row">

    <div class="col-md-12">

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption bold uppercase">
                    <strong><i class="fa fa-users"></i> User Statistics</strong>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="overflow: hidden">
                <a href="{{ route('users') }}">
                    <div class="col-md-3">
                        <div class="dashboard-stat yellow">
                            <div class="visual">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_users }}">{{ $total_users }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Users </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('user.ban') }}">
                    <div class="col-md-3">
                        <div class="dashboard-stat red">
                            <div class="visual">
                                <i class="fa fa-user-times"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_banned }}">{{ $total_banned }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Banned </div>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="col-md-3">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-user-md"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $total_activate }}">{{ $total_activate }}</span>
                            </div>
                            <div class="desc bold uppercase"> Total Active  </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-user-circle-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $total_verified }}">{{ $total_verified }}</span>
                            </div>
                            <div class="desc bold uppercase"> Total Verified  </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-12">

        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption bold uppercase">
                    <strong><i class="fa fa-edit"></i> Statistics</strong>
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="overflow: hidden">
                <div class="col-md-3">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-edit"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $total_posts }}">{{ $total_posts }}</span>
                            </div>
                            <div class="desc bold uppercase"> Total Posts </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat yellow">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $total_comments }}">{{ $total_comments }}</span>
                            </div>
                            <div class="desc bold uppercase"> Total Comments </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $total_likes }}">{{ $total_likes }}</span>
                            </div>
                            <div class="desc bold uppercase"> Total Likes  </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-stat red">
                        <div class="visual">
                            <i class="fa fa-share-alt"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $total_shares }}">{{ $total_shares }}</span>
                            </div>
                            <div class="desc bold uppercase"> Total Shares  </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="row">

        <div class="col-md-12">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption bold uppercase">
                        <strong><i class="fa fa-users"></i> Data Statistics</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    <div class="col-md-3">
                        <div class="dashboard-stat yellow">
                            <div class="visual">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_views }}">{{ $total_views }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Reads </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-stat red">
                            <div class="visual">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_groups }}">{{ $total_groups }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Groups </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-stat blue">
                            <div class="visual">
                                <i class="fa fa-picture-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_albums }}">{{ $total_albums }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Albums  </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-stat green">
                            <div class="visual">
                                <i class="fa fa-flag"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_reports }}">{{ $total_reports }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Reports  </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption bold uppercase">
                        <strong><i class="fa fa-picture-o"></i> Asset Statistics</strong>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body" style="overflow: hidden">
                    <div class="col-md-3">
                        <div class="dashboard-stat green">
                            <div class="visual">
                                <i class="fa fa-video-camera "></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_videos }}">{{ $total_videos }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Videos </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-stat yellow">
                            <div class="visual">
                                <i class="fa fa-picture-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_pictures }}">{{ $total_pictures }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Pictures </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-stat blue">
                            <div class="visual">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_audios }}">{{ $total_audios }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Audios  </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="dashboard-stat red">
                            <div class="visual">
                                <i class="fa fa-youtube"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $total_youtubes }}">{{ $total_youtubes }}</span>
                                </div>
                                <div class="desc bold uppercase"> Total Youtubes  </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


</div>
</div>
@endsection
