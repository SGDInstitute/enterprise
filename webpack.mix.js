let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.webpackConfig({
    node: {
        fs: "empty"
    },
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/checkin.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .less('resources/less/checkin.less', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.js')
        ],
    });

if (mix.inProduction()) {
    mix.version();
}
