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

    <!-- Add to homescreen manifest -->
    <link rel="manifest" href="manifest.json"> 
    <link rel="icon" sizes="192x192" href="/img/icons/launcher-icon-4x.png"> 
    <meta name="mobile-web-app-capable" content="yes">

    <style type="text/css">
        
        body {
            background-color: #3f51b5;
            color: white;
            height: 100vh;
            font-family: 'Noto Sans SC', sans-serif;
        } 
        .no-padding, li.no-padding {
            padding-top: 0;
            padding-right: 0;
            padding-bottom: 0;
            padding-left: 0;
        }
        
        .margin-1 {
            margin: 10px 0;
        }
        .margin-bottom-1 {
            margin-bottom: 10px;
        }

        .name {
            color: white;
        }

        .dead .name {
            color: #333;
            text-decoration: line-through;
        }

        .dead .img-circle {
            -moz-filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
            -o-filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
            -webkit-filter: grayscale(100%);
            filter: gray;
            filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
        }

        .dead img {
            filter: grayscale(100%);
        }

        .alive .name {
            color: #5de95d;
        }

        .player-list li {
            max-width: 25%;
            margin: 15px 0;
            cursor: pointer;
        }

        .roles-list, .script-dialog {
            position: fixed;
            top: 20vh;
            left: 15vw;
            min-height: 30vh;
            width: 70vw;
            z-index: 5;
            background: white;
            -webkit-box-shadow: 0px 0px 10px 3px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 10px 3px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 10px 3px rgba(0,0,0,0.75);
            padding: 5vw;
            color: black;
        }

        .script-dialog ul {
            padding-left: 0;
        }

        .script-dialog li {
            list-style: none;
        }

        .roles-list li {
            margin: 0;
        }

        .flex {
            display:flex;
        }

        .level {
            flex: 1;
        }

        .game-summary {
            color: white;
        }
       
        .game-list .list-inline li img{
            max-width: 50px;
        }

        .profile-img-container {
            max-width: 150px;
            display: block;
            position: relative;
            margin: auto;
        }

        .panel-egypt {
            background-size: cover;
            background-color: transparent;
            color: white;
            padding: 15px;
            font-size: 16px;
            background-position: center;
            border: 1px solid white;
            -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
        }

        .panel-egypt .panel-heading {
            background-color: transparent;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .list-inline img {
            margin-top: 5px;
        }

        .flex-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .overflow-scroll {
            max-width: 100vw;
            overflow-x: scroll;
            margin-top: 5px;
        }

        
        .borderless, .borderless td, .borderless th {
            border: 0px solid transparent !important;
        }

        .text-center th {
            text-align: center;
        }

        .panel-egypt table tr td {
            vertical-align: middle;
        }

        .navbar-egypt {
            background: #303f9f;
            color: white;
            border-color: transparent;
        }

        .navbar-egypt .navbar-brand {
            color: white;
        }

        .navbar-egypt .navbar-toggle {
            border-color: white;
        }

        .navbar-egypt .navbar-toggle .icon-bar {
            background-color: white;
        }

        .navbar-egypt .navbar-nav li a, .navbar-egypt .navbar-nav .open .dropdown-menu li a {
            color: white;
        }

        .navbar-egypt .navbar-nav .open a, .navbar-egypt .navbar-nav .open a:hover, .navbar-egypt .navbar-nav .open a:focus {
            color: white;
            background: #303f9f;
        }

        .navbar-egypt .nav li a:hover, .navbar-egypt .nav li a:focus {
            color: white;
            background: #303f9f;
        }

        .v-select .dropdown-menu .active > a {
            background: #FF5252 !important;
            color: white !important;
        }

        .panel-egypt .btn-primary {
            background: #FF5252;
            border: none;
        }
        
        .profile {
            width: 70px;
            height: 70px;
            background-size: cover;
            background-position: center;
        }

        .profile.player-detail {
            width: 100%;
            padding-bottom: 100%;
            min-width: 79.5px;
        }

        .img-small {
            min-width: 40px;
            width: 40px;
            height: 40px;
            margin-right: 5px;
        }

        .img-medium {
            min-width: 50px;
            width: 50px;
            height: 50px;
            margin-right: 5px;
        }

        .img-big {
            min-width: 160px;
            width: 160px;
            height: 160px;
        }

        .past-game .profile {
            min-width: auto;
        }

        .blind-file-input {
            width: 0;
            height: 0;
            overflow: hidden;
        }

        .navbar-brand {
            width: 100%;
        }

        .navbar-toggle {
            position: absolute;
            right: 5px;
        }

        .instructions img, .role {
            max-width: 50px;
        }

        .game-summary {
            padding: 15px 10px;
            border-bottom: 1px solid white;
            border-radius: 15px;
            margin-bottom: 10px;
        }

        .ml-5 {
            margin-left: 5px;
        }

        .ml-10 {
            margin-left: 10px;
        }

        .background-good {
            background: #2ab27b;
        }

        .background-bad {
            background: #ff5252;
        }

        .game-create .role {
            max-width: 60px;
        }

        .game-create .role label {
            margin-top: -25px;
        }

        .game-create .role img {
            filter: grayscale(100%);
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -ms-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        .game-create .role input[type=checkbox]:checked + label img {
            filter: none;
        }

        .pt-1 {
            padding: 10px 0;
        }

        tr.is-user {
            background: rgba(255,82,82,0.7);
        }

        .panel-egypt a {
            color: white;
        }

    </style>
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
    <script src="{{ asset('js/app.js?v=1.6') }}"></script>
</body>
</html>
