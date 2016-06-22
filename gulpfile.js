var elixir = require('laravel-elixir');

elixir(function(mix) {

	var paths = {
		'mdl': './node_modules/material-design-lite',
		'dialog': './node_modules/dialog-polyfill',
		'socketio' : './node_modules/socket.io-client'
	};

	mix.sass('app.scss');

	mix.scripts([
		paths.mdl + '/material.min.js',
		paths.dialog + '/dialog-polyfill.js',
		paths.socketio + '/socket.io.js'
	], './public/js/vendors.js');


	mix
		.copy(paths.mdl + '/src/images/**', './public/img')
		.copy('resources/assets/js/pages/**', 'public/js/pages/')
	;

	mix.browserSync({
	   proxy: 'deployer.app'
   	});
});
