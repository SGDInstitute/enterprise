let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.webpackConfig({
    node: {
        fs: "empty"
    },
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/checkin.js', 'public/js')
    .less('resources/less/app.less', 'public/css')
    .less('resources/less/checkin.less', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.config.js')
        ],
    });

if (mix.inProduction()) {
    mix.version();
}
