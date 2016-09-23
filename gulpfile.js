process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
var gulp = require('gulp');

elixir(function (mix) {
    mix.sass(
        ['app.scss'], 'public/assets/css'
    ).scripts(
        ['login.js'], 'public/assets/js/login.min.js'
    ).scripts(
        ['navbar.js'], 'public/assets/js/master.min.js'
    ).scripts(
        ['facebookfix.js', 'home.js'], 'public/assets/js/home.min.js'
    );
});