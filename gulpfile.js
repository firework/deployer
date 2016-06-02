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
		'mdl': './node_modules/material-design-lite',
	};

	mix.sass('app.scss');

	mix.scripts([
		paths.mdl + '/material.min.js',
	], './public/js/vendors.js');


	mix.copy(paths.mdl + '/src/images/**', './public/img');

	mix.browserSync({
	   proxy: 'deployer.app'
   });
});
