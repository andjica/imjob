const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue({
     version: 3,
     options: {
       compilerOptions: {
         // Ovo je ključno:
         define: {
           __VUE_OPTIONS_API__: true,
           __VUE_PROD_DEVTOOLS__: false,
           __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
         },
       },
     },
   })
   .sass('resources/sass/app.scss', 'public/css');
