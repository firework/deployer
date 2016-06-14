var elixir = require('laravel-elixir');

elixir(function(mix) {

	var paths = {
		'mdl': './node_modules/material-design-lite',
		'dialog': './node_modules/dialog-polyfill'
	};

	mix.sass('app.scss');

	mix.scripts([
		paths.mdl + '/material.min.js',
		paths.dialog + '/dialog-polyfill.js'
	], './public/js/vendors.js');


	mix.copy(paths.mdl + '/src/images/**', './public/img');

	mix.browserSync({
	   proxy: 'deployer.app'
   	});
});
