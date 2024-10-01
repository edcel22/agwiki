<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin | {{$data['page_title']}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Chris Feix http://culturespirit.com" name="author" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('assets/admin/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('assets/admin/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}">
    {{--<script src="{{asset('assets/admin/nicEdit.js')}}"></script>
    <script>
        bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('shaons'); });
    </script>--}}
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="{{ url('/') }}">
                    <img src="{{asset('assets/front/img/logo.png')}}" alt="logo" class="logo-default"> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>

                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username"> {{ Auth::guard('admin')->user()->username }}  </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li><a href="{{ route('admin.pass') }}"><i class="fa fa-cog"></i> Change Password </a></li>
                                <li><a href="{{route('admin.logout')}}"><i class="fa fa-sign-out"></i> Log Out </a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

                        <!-- <li class="sidebar-toggler-wrapper hide">
                            <div class="sidebar-toggler"> </div>


</li> -->

<li class="nav-item start @if(request()->path() == 'admin/Dashboard') active open @endif">
    <a href="{{route('admin.dashboard')}}" class="nav-link "><i class="fa fa-home"></i><span class="title">Dashboard</span></a>
</li>
<li class="nav-item @if(request()->path() == 'admin/posts') active open @endif">
    <a href="{{route('post.index')}}" class="nav-link "><i class="fa fa-list"></i><span class="title"> Posts</span></a>
</li>

<li class="nav-item @if(request()->path() == 'admin/rss') active open @endif">
    <a href="{{route('rss')}}" class="nav-link "><i class="fa fa-newspaper-o"></i><span class="title"> RSS</span></a>
</li>
<li class="nav-item @if(request()->path() == 'admin/ads') active open @endif">
    <a href="{{route('ads')}}" class="nav-link "><i class="fa fa-newspaper-o"></i><span class="title"> Ads</span></a>
</li>

<li class="nav-item @if(request()->path() == 'admin/topic') active open @endif">
    <a href="{{route('topic')}}" class="nav-link "><i class="fa fa-file-text-o"></i><span class="title"> Topics</span></a>
</li>

<li class="nav-item @if(request()->path() == 'admin/group') active open @endif">
    <a href="{{route('group')}}" class="nav-link "><i class="fa fa-users"></i><span class="title"> Groups</span></a>
</li>


                        <li class="nav-item
            @if(request()->path() == 'admin/users') active open
                @elseif(request()->path() == 'admin/user/search') active open
                @elseif(request()->path() == 'admin/user-banned') active open
                @elseif(request()->path() == 'admin/broadcast') active open
                @elseif(request()->path() == 'admin/subscribers') active open
                @elseif(request()->path() == 'admin/login-logs') active open
                @elseif(request()->path() == 'admin/user/profile-verify/request') active open
                @elseif(request()->path() == 'admin/user/profile-verify/all') active open
            @endif">
                            <a href="#" class="nav-link nav-toggle">
                                <i class="fa fa-user"></i>
                                <span class="title">User Management</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item @if(request()->path() == 'admin/users') active open
                    @elseif(request()->path() == 'admin/user/search') active open
                    @endif">
                                    <a href="{{route('users')}}" class="nav-link ">
                                        <i class="fa fa-user"></i>
                                        <span class="title">Users</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item @if(request()->path() == 'admin/superuser') active open
                    @endif">
                                    <a href="{{route('users.super')}}" class="nav-link ">
                                        <i class="fa fa-users"></i>
                                        <span class="title">Edit Superuser</span>
                                    </a>
                                </li>-->
                                <li class="nav-item @if(request()->path() == 'admin/broadcast') active open @endif">
                                    <a href="{{route('broadcast')}}" class="nav-link ">
                                        <i class="fa fa-envelope"></i>
                                        <span class="title">Broadcast Email</span>
                                    </a>
                                </li>
								<li class="nav-item @if(request()->path() == 'admin/newsletter') active open @endif">
                                    <a href="{{route('newsletter')}}" class="nav-link ">
                                        <i class="fa fa-envelope"></i>
                                        <span class="title">Test Newsletter</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item @if(request()->path() == 'admin/user/profile-verify/all') active open @endif">
                                    <a href="{{route('verify.all')}}" class="nav-link ">
                                        <i class="fa fa-check"></i>
                                        <span class="title">Verified Users</span>
                                    </a>
                                </li>
                                <li class="nav-item @if(request()->path() == 'admin/user/profile-verify/request') active open @endif">
                                    <a href="{{route('verify.request')}}" class="nav-link ">
                                        <i class="fa fa-hand-lizard-o"></i>
                                        <span class="title">Verify Request</span>
                                    </a>
                                </li>-->
                                <li class="nav-item @if(request()->path() == 'admin/user-banned') active open @endif">
                                    <a href="{{route('user.ban')}}" class="nav-link ">
                                        <i class="fa fa-check"></i>
                                        <span class="title">Inactive Users</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item @if(request()->path() == 'admin/login-logs') active open @endif">
                                    <a href="{{route('user.login-logs')}}" class="nav-link ">
                                        <i class="fa fa-list"></i>
                                        <span class="title">Login Logs</span>
                                    </a>
                                </li>-->
                            </ul>
                        </li>

                        <!--<li class="nav-item
                                @if(request()->path() == 'admin/GeneralSetting') active open
                                @elseif(request()->path() == 'admin/document') active open
                                @elseif(request()->path() == 'admin/template') active open
                                @elseif(request()->path() == 'admin/sms-api') active open
                                @elseif(request()->route()->getName() == 'gnl.tp') active open
                                @elseif(request()->route()->getName() == 'gnl.pp') active open
                            @endif">
                            <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-bars"></i>
                                <span class="title">Website Control</span><span class="arrow"></span></a>

                                <ul class="sub-menu">

                                    <li class="nav-item">
                                        <a href="{{route('admin.GenSetting')}}" class="nav-link"><i class="fa fa-cogs"></i> General Setting </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('template') }}" class="nav-link @if(request()->path() == 'admin/template') active @endif"><i class="fa fa-envelope"></i> Email Setting </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('sms.api') }}" class="nav-link @if(request()->path() == 'admin/sms-api') active @endif"><i class="fa fa-mobile"></i> SMS Setting </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('gnl.tp') }}" class="nav-link @if(request()->route()->getName() == 'gnl.tp') active @endif"><i class="fa fa-edit"></i> Terms And Policy </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('gnl.pp') }}" class="nav-link @if(request()->route()->getName() == 'gnl.pp') active @endif"><i class="fa fa-edit"></i> Privacy Policy </a>
                                    </li>


                                </ul>
                            </li>-->

<!--<li class="nav-item start @if(request()->route()->getName() == 'logo.index') active open @endif">
    <a href="{{route('logo.index')}}" class="nav-link "><i class="fa fa-desktop"></i><span class="title">Logo And Icon</span></a>
</li>-->


                        </ul>
                    </div>
                </div>


                @yield('body')



            </div>
            <div class="page-footer">
                <div class="page-footer-inner"> {{ date("Y")}} &copy; {{$data['sitename']}}</div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>


            <!-- JavaScripts -->
            <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/js.cookie.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/bootstrap-hover-dropdown.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/jquery.blockui.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/app.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/layout.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/jquery.waypoints.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/jquery.counterup.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/datatable.js')}}"></script>
            <script src="{{asset('assets/admin/js/datatables.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/datatables.bootstrap.js')}}"></script>
            <script src="{{asset('assets/admin/js/table-datatables-buttons.min.js')}}"></script>
            <script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>

           @yield('script')






@if (session('success'))
<script>
        $(document).ready(function(){
            swal("Success!", "{{ session('success') }}", "success");
        });
</script>
@endif

@if (session('alert'))
<script>
        $(document).ready(function(){
            swal("Sorry!", "{{ session('alert') }}", "error");
        });
</script>
@endif

@if($errors->any())
<script>
        $(document).ready(function(){
            swal("Opps!", "{{ implode($errors->all(), '\n') }}", "error");
        });
</script>
@endif



        </body>
        </html>
