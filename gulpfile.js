var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

	var paths = {
		'bootstrap': './resources/assets/bower_components/bootstrap/dist/',
		'jquery': './resources/assets/bower_components/jquery/dist/',
	}

    mix.copy(
            paths.bootstrap + 'css/bootstrap.min.css',
            'public/vendor/bootstrap/css/bootstrap.min.css'
        ).copy(
            paths.bootstrap + 'fonts/**',
            'public/vendor/bootstrap/fonts'
        ).copy(
            paths.bootstrap + 'js/bootstrap.min.js',
            'public/vendor/bootstrap/js/bootstrap.min.js'
        ).copy(
            paths.jquery + 'jquery.min.js',
            'public/vendor/jquery/jquery.min.js'
        );

    mix.sass('app.scss');
});
