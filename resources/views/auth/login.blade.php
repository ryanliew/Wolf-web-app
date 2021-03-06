<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>狼人杀俱乐部</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <!-- Add to homescreen manifest -->
        <link rel="manifest" href="manifest.json"> 
        <link rel="icon" sizes="192x192" href="/img/icons/launcher-icon-4x.png"> 
        <meta name="mobile-web-app-capable" content="yes">


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                width: 80%;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .main-bg {
                background-image: url('/img/bg/login.jpg');
                background-size: cover;
            }

            .logo {
                max-width: 50px;
                margin-top: 9px;
            }

            .logo-text {
                height: 60px;
                padding-left: 10px;
            }

            .flex {
                display: flex;
            }

            .title {
                margin-bottom: 15vh;
            }

            .title p{
                color: white;
                font-size: 35px;
                padding-left: 15px;
            }

            .subtitle {
                color: white;
                font-size:20px;
            }

            .form-control {
                border-radius: 5px;
                font-size: 17px;
                padding: 10px;
                width: calc(100% - 20px);
                margin-bottom: 25px;
                border: none;
            }

            .btn {
                border: none;
                border-radius: 40px;
                width: 100%;
                padding: 15px 0;
                font-size: 16px;
                display: block;
                text-decoration: none;
                margin-top: 15px;
            }

            .btn-primary {
                background: #ee2337;
                color: white;
            }

            .btn-facebook {
                background: #3b5998;
                color: white;
                font-weight: bold;
                display: flex;
                justify-content: center;
            }

            .btn-facebook .fa {
                margin-right: 5px;
            }

            .btn-secondary {
                background: #0072bc;
                color: white;
            }

            .margin-top-15 {
                margin-top: 15vh;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height main-bg">
            <div class="content">
                <div class="flex-center title">
                    <img src="/img/icons/launcher-icon-4x.png" class="img-responsive logo"> 
                    <img src="/img/icons/logo-text.png" class="img-responsive logo-text"> 
                </div>
                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="电邮" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                        <input id="password" type="password" class="form-control" name="password" placeholder="密码" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="margin-top-15">
                            <button type="submit" class="btn btn-primary">
                                登入
                            </button>
                            <a href="/register" class="btn btn-secondary">
                                注册新帐号
                            </a>
                            <a href="/login/facebook" class="btn btn-facebook">
                                <i class="fa fa-lg fa-facebook-official"></i> 
                                Login with Facebook
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
