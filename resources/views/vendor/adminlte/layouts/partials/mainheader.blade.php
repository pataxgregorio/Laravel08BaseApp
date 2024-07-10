<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a style="background-color: {{$array_color['encabezado_color']}};" href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span style="background-color: {{$array_color['encabezado_color']}};" class="logo-mini"><b>HORUS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span style="background-color: {{$array_color['encabezado_color']}};" class="logo-lg"><b>{{ trans('message.home_1') }}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background-color: {{$array_color['encabezado_color']}};">
        <!-- Sidebar toggle button-->
        <a  style="background-color: {{$array_color['encabezado_color']}};" href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">{{ trans('message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('message.tabmessages') }}</li>
                        <li>
                            <!-- inner menu: contains the messages -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="{{ url('/mail') }}">
                                        <div class="pull-left">
                                            <!-- User Image -->
                                            <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image"/>
                                        </div>
                                        <!-- Message title and timestamp -->
                                        <h4>
                                            {{ trans('message.supteam') }}
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <!-- The message -->
                                        <p>{{ trans('message.awesometheme') }}</p>
                                    </a>
                                </li><!-- end message -->
                            </ul><!-- /.menu -->
                        </li>
                        <li class="footer"><a href="#">c</a></li>
                    </ul>
                </li><!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">{{$count_notification}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('message.notifications') }}{{$count_notification}}{{ trans('message.notifications_2') }}</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    <a href="{{ url('/notificaciones') }}">
                                        <i class="fa fa-bell text-aqua"></i> {{ trans('message.notifications') }}{{$count_notification}}{{ trans('message.notifications_2') }}
                                    </a>
                                </li><!-- end notification -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#">{{ trans('message.viewall') }}</a></li>
                    </ul>
                </li>
                <!-- Tasks Menu -->
                <li class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger">3</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">{{ trans('message.tasks') }}</li>
                        <li>
                            <!-- Inner menu: contains the tasks -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="{{ url('/homework') }}">
                                        <!-- Task title and progress text -->
                                        <h3>
                                            {{ trans('message.tasks') }}
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <!-- The progress bar -->
                                        <div class="progress xs">
                                            <!-- Change the css width attribute to simulate progress -->
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% {{ trans('message.complete') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li><!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">{{ trans('message.alltasks') }}</a>
                        </li>
                    </ul>
                </li>
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu" id="user_menu" style="max-width: 280px;white-space: nowrap;">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="max-width: 280px;white-space: nowrap;overflow: hidden;overflow-text: ellipsis">
                            <!-- The user image in the navbar-->                          
                          @if (Auth::user()->avatar == 'default.jpg' || is_null(Auth::user()->avatar))
                            <img src="{{ url('/storage/avatars/default.jpg') }}" class="user-image" alt="User Image"/>
                          @else
                            <img src="{{ url('/storage/avatars/'.Auth::user()->avatar) }}" class="user-image" alt="User Image">
                          @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header" style="background-color: {{$array_color['encabezado_color']}};">
                              <!--  <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" /> -->
                                @if (Auth::user()->avatar == 'default.jpg' || is_null(Auth::user()->avatar))
                                    <img src="{{ url('/storage/avatars/default.jpg') }}" class="img-circle" alt="User Image"/>
                                @else
                                    <img src="{{ url('/storage/avatars/'.Auth::user()->avatar) }}" class="img-circle" alt="User Image">
                                @endif
                                <p>
                                    <span data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                                    <small>{{ trans('message.login') }} Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('message.followers') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('message.sales') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('message.friends') }}</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('/users/'.Auth::user()->id.'/edit') }}" class="btn btn-default btn-flat">{{ trans('message.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" id="logout"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
