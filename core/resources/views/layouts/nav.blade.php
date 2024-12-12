@auth
<div class="mobile-nav">
    <div class="container-fluid">
        <div class="mobile-nav-bottom-area">
            <ul>
            <li><a href="{{url('/')}}"><i class="material-icons">
home
</i></a></li>
            <li><a href="{{ route('user.notification') }}">@if(Auth::user()->unreadNotif())<span class="count">{{ Auth::user()->unreadNotif() }}</span> @endif <i class="material-icons">
notifications
</i></a></li>
            <li><a href="{{ route('user.message.notify') }}">@if(Auth::user()->unreadMessageCount())<span class="count">{{ Auth::user()->unreadMessageCount() }}</span> @endif <i class="material-icons">
email
</i></a></li>
            <li><a href="{{ route('peoples') }}"><i class="material-icons">
person_add
</i></a></li>
            <li>
                <a id="get_search-form"><i class="material-icons">
search
</i></a>
                <div class="search-area-mobile">
                    <div class="search-area-inner">
                        <form action="{{ route('search') }}" method="get">
                            <div class="form-group has-icon">
                                <input type="text" class="form-control" placeholder="Search" name="s">
                                <div class="the-icon">
                                    <i class="material-icons">
search
</i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </li>
            <li><a href="{{ route('links') }}"><i class="material-icons">
reorder
</i></a></li>
        </ul>
        </div>
    </div>
</div>
<nav class="navbar navbar-default navbar-fixed-top user-dashboard">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <ul class="nav navbar-nav">

                    <li>
                        <a href="{{ url('/') }}">
                            <span class="glyphicon glyphicon-home"></span><span class=""> Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.notification') }}">
                            @if(Auth::user()->unreadNotif()) <span class="count">{{ Auth::user()->unreadNotif() }}</span> @endif<span class="glyphicon glyphicon-bell"></span><span class=""> Notifications</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('user.message.notify') }}">
                            @if(Auth::user()->unreadMessageCount())<span class="count">{{ Auth::user()->unreadMessageCount() }}</span> @endif<span class="glyphicon glyphicon-envelope"></span><span class=""> Messages</span>
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-4" style="text-align: center;">
               <div class="user-dashboard-logo"> <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/front/img/logo.png') }}">
                </a></div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-4">
                <div class="navbar-right-area">
                        <form class="navbar-form navbar-left" action="{{ route('search') }}" method="get">
                        <div class="form-group has-icon input-rounded top-search-bar">
                            <input type="text" class="form-control" placeholder="Search" name="s">
                            <span class="the-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        <li class="dropdown profile-img">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('assets/front/img/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="img-responsive"></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('profile', Auth::user()->username) }}">Profile</a></li>
                                <li><a href="{{ route('user.invite') }}">Invite</a></li>
                                <li><a href="{{ route('user.groups') }}">Groups</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('user.password.change') }}">Password Change</a></li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </li>

                    </ul>
                   </div>
                              </div>
                          </div>
                      </div>
                  </nav>
                  @endauth
                  @guest
                    <div class="mobile-nav">
                        <div class="container-fluid">
                            <div class="mobile-nav-bottom-area">
                                <ul>
                                    <li style="float: right;"><a href="{{url('register')}}"><i class="material-icons">person_add</i></a></li>
                                    <li style="float: right;"><a href="{{url('login')}}"><i class="material-icons">add_to_home_screen</i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                      <nav class="navbar navbar-default navbar-fixed-top user-dashboard">
                          <div class="container">
                              <div class="row">
                                  <div class="col-md-6 col-md-offset-3 text-center">
                                      <div class="user-dashboard-logo"> <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/front/img/logo.png') }}">
                </a></div>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="navbar-right-area">
                                          <ul class="nav navbar-nav">
                                              <li>
                                                <a href="{{ url('/') }}">
                                                    <span class="glyphicon glyphicon-log-in"></span><span class=""> Login</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('register') }}">
                                                    <span class="glyphicon glyphicon-log-in"></span><span class=""> Register</span>
                                                </a>
                                            </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </nav>
                  @endguest