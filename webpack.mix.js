let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
   .less('resources/less/app.less', 'public/css')
   .options({
      processCssUrls: false,
      postCss: [
         tailwindcss('./tailwind.config.js')
      ],
   });

if (mix.inProduction()) {
   mix.version();
}
