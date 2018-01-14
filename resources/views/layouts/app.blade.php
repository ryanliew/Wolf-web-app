<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=1.1') }}" rel="stylesheet">
    <link href="{{ asset('css/wolf.css?v=1.6') }}" rel="stylesheet">
    
    <!-- Add to homescreen manifest -->
    <link rel="manifest" href="manifest.json"> 
    <link rel="icon" sizes="192x192" href="/img/icons/launcher-icon-4x.png"> 
    <meta name="mobile-web-app-capable" content="yes">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-egypt navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <span class="navbar-brand text-center">@yield('title')</span>
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">登入</a></li>
                            <li><a href="{{ route('register') }}">注册</a></li>
                        @else
                            <li>
                                <a href="/notice">公告</a>
                            </li>
                            <li>
                                <a href="/home">排行榜</a>
                            </li>
                            <li>
                                <a href="/games/create">创建游戏</a>                                
                            </li>
                            <li>
                                <a href="/games">以往游戏</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('profile', auth()->id() ) }}">
                                            个人资料
                                        </a>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            离开
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        <flash message="{{ session('flash') }}"></flash>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js?v=1.9') }}"></script>
</body>
</html>
