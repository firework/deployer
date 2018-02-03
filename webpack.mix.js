const mix = require('laravel-mix');

let paths = {
    'mdl': 'node_modules/material-design-lite',
    'dialog': 'node_modules/dialog-polyfill',
    'socketio' : 'node_modules/socket.io-client',
    'axios': 'node_modules/axios/dist'
};

mix.options({
    processCssUrls: false,
});

mix.sass('resources/assets/sass/app.scss', 'public/css')
    .combine([
        paths.mdl + '/material.min.js',
        paths.dialog + '/dialog-polyfill.js',
        paths.socketio + '/socket.io.js',
        paths.axios + '/axios.js',
        'resources/assets/js/lib/main.js',
    ], 'public/js/vendor/global.js')
    .copy(paths.mdl + '/src/images/**', 'public/img')
    .copy('resources/assets/img/**', 'public/img')
    .copy('resources/assets/js/pages/**', 'public/js/pages/')
    .version([
        'public/css/app.css',
        'public/js/pages/**',
        'public/js/vendor/**',
    ]);
