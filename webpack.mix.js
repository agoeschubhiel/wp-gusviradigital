const mix = require('laravel-mix');

mix.disableNotifications();

mix.js('assets/js/app.js', 'dist/js')
   .postCss('assets/css/app.css', 'css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
   .options({
        processCssUrls: false
    })
   .setPublicPath('dist')
   .sourceMaps(true, 'source-map')
   .version();

// Enable HMR
mix.webpackConfig({
    devServer: {
        hot: true,
    },
    stats: {
        children: true,
        logging: 'warn'
    }
});

if (mix.inProduction()) {
    mix.options({
        terser: {
            extractComments: false,
        },
        cssNano: {
            discardComments: {
                removeAll: true,
            },
        },
    });
} else {
    // Development-specific settings
    mix.webpackConfig({
        devtool: 'source-map'
    });
}