<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Comunidade voltada para indicações de filmes e séries para todos os gostos.">
        <meta name="keywords" content="assiste ai filme série seriado indicação recomendação top melhor">
        <meta name="robots" content="index,follow">
        <title>Assiste Aí - @yield('title')</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/semantic/semantic.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/sweetalert/sweetalert.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
    </head>
    <body class="master">
        @include('partials.google-analytics')
        <div class="ui center aligned grid">
            <div class="wrapper">
                <div class="logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo_beta.png') }}" alt="Logo Assiste Aí"></a>
                </div>
                <div class="nav">
                    <div class="ui segment">
                        <div class="ui pointing dropdown">
                            <i class="fa fa-bars"></i>
                            <div class="menu">
                                <div class="item"><i class="fa-clock-o icon"></i> Assistir mais tarde</div>
                                <div class="item"><i class="fa-thumbs-o-up icon"></i> Minhas indicações</div>
                                <a class="item" href="{{ url('auth/logout') }}"><i class="fa-power-off icon"></i> Sair</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search">
                    <div class="ui segment">
                        <div class="ui transparent inverted icon input">
                            <i class="search icon"></i>
                            <input type="text" placeholder="Busca" id="search">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
        <script src="{{ asset('assets/lib/jquery/jquery.min.js?v=2.1.4') }}"></script>
        <script src="{{ asset('assets/lib/semantic/semantic.min.js') }}"></script>
        <script src="{{ asset('assets/lib/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/js/master.min.js') }}"></script>
        @yield('script')
        @include('partials.flash')
    </body>
</html>
