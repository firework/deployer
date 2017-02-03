var elixir = require('laravel-elixir');

elixir(function(mix) {

	var paths = {
		'mdl': 'node_modules/material-design-lite',
		'dialog': 'node_modules/dialog-polyfill',
		'socketio' : 'node_modules/socket.io-client/dist',
	};

	mix.sass('app.scss');

	mix.combine([
		paths.mdl + '/material.min.js',
		paths.dialog + '/dialog-polyfill.js',
		paths.socketio + '/socket.io.js',
		'resources/assets/js/lib/main.js',
	], 'public/js/vendor/global.js');

	mix
		.copy(paths.mdl + '/src/images/**', 'public/img')
		.copy('resources/assets/js/pages/**', 'public/js/pages/')
	;

	mix.version([
		'css/app.css',
		'js/pages/**',
		'js/vendor/**',
	]);

	mix.browserSync({
	   proxy: 'deployer.app'
   	});
});
