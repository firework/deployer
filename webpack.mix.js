const mix = require('laravel-mix');

const jsFiles = [
    'resources/assets/js/laroute.js',
    'resources/assets/js/lib/main.js',
    'node_modules/material-design-lite/material.min.js',
    'node_modules/dialog-polyfill/dialog-polyfill.js',
    'node_modules/socket.io-client/dist/socket.io.js',
    'node_modules/axios/dist/axios.js',
    'node_modules/clipboard-polyfill/build/clipboard-polyfill.js',
];

mix.options({
    processCssUrls: false,
});

mix.sass('resources/assets/sass/app.scss', 'public/css')
    .combine(jsFiles, 'public/js/vendor/global.js')
    .copy('node_modules/material-design-lite/src/images/**', 'public/img')
    .copy('resources/assets/img/**', 'public/img')
    .copy('resources/assets/js/pages/**', 'public/js/pages/')
    .version([
        'public/css/app.css',
        'public/js/pages/**',
        'public/js/vendor/**',
    ]);
