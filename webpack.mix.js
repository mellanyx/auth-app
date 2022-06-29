const mix = require('laravel-mix');

// mix.webpackConfig({
//     stats: {
//         children: true,
//     },
// });

mix
    .js("resources/js/app.js", "public/js")
    .vue()
    .sass('resources/scss/app.scss', 'public/css/app.css');
