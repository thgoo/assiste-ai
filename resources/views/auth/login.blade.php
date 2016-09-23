<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Comunidade voltada para indicações de filmes e séries para todos os gostos.">
        <meta name="keywords" content="assiste ai filme série seriado indicação recomendação top melhor">
        <meta name="robots" content="index,follow">
        <title>Login - Assiste Aí</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/semantic/semantic.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/sweetalert/sweetalert.min.css') }}">
    </head>
    <body class="login">
        @include('partials.google-analytics')
        <div class="ui small modal">
            <div class="header">
                <p class="text-center"><img src="{{ asset('assets/img/logo-login.png') }}" alt="Logo Assiste Aí"></p>
            </div>
            <div class="content">
                <h3 class="text-center login">FAÇA LOGIN UTILIZANDO UMA DAS OPÇÕES ABAIXO</h3>
                <p class="text-center">
                    <a class="darken margin-right-10" href="{{ url('auth/facebook') }}"><img src="{{ asset('assets/img/social/facebook.png') }}" alt="Login com Facebook"></a>
                    <img class="disabled margin-right-10" src="{{ asset('assets/img/social/twitter.png') }}" alt="Login com Twitter">
                    <img class="disabled" src="{{ asset('assets/img/social/google-plus.png') }}" alt="Login com Google Plus">
                </p>
            </div>
        </div>
        <div class="login-bg">
            @foreach ($movies as $movie)
                <span class="effect" data-src="https://image.tmdb.org/t/p/w185{{ $movie->poster_path }}"></span>
            @endforeach
        </div>
        <script src="{{ asset('assets/lib/jquery/jquery.min.js?v=2.1.4') }}"></script>
        <script src="{{ asset('assets/lib/semantic/semantic.min.js') }}"></script>
        <script src="{{ asset('assets/lib/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/js/login.min.js') }}"></script>
        @include('partials.flash')
    </body>
</html>
