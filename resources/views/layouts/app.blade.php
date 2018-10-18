<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="api-base-url" content="{{ url('/') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    
    <script src="{{ asset('js/vendors/jquery.min.js') }}"></script>
    <script src="{{ asset('js/layoutsettings.js') }}"></script>
</head>
<body>
    <div id="app">
        <div class="app-sidebar">
            <div class="sidebar-header">
                <!-- Branding Image -->
                <a class="app-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="sidebar-content-wrapper">
                <div class="sidebar-content">
                    @include('admin.sidebar')
                </div>
            </div>
        </div>
        <nav class="navbar app-navbar">
            <div class="container-fluid">
                <div class="app-navbar-header pull-left">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="app-navbar-toggle">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                
                @if (isset($actionMenu))
                    @include('components.action_menu', $actionMenu)
                @endif

                <div class="dropdown clearfix pull-right">
                    <button type="button" class="btn btn-app-icon-default btn-app-round-icon dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                    </button>
                    <!-- Right Side Of Navbar -->
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- Authentication Links -->
                        @if (\Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="app-dropdown-header">
                                {{ \Auth::user()->first_name }} 
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="app-container">
        
            @yield('content')

            @if (isset($actionMenu))
            <div class="dropdown action-menu-fab">
                <button class="btn app-floating-action app-floating-action-primary dropdown-toggle" type="button" id="action_menu" data-toggle="dropdown" data-target="#action_menu_target">
                    <span>&#43;</span>
                </button>
            </div>
            @endif

        </div>
        <div class="modal fade in" id="sidebarModal"></div>
        <div id="app_modal"></div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="{{ asset('js/users.js') }}"></script> -->
    <script src="{{ asset('js/sliding.js') }}"></script>
</body>
</html>
