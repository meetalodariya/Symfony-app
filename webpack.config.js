var Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('js/app',['./node_modules/jquery/dist/jquery.min.js',
        './node_modules/bootstrap/dist/js/bootstrap.min.js'
    , './node_modules/holderjs/holder.min.js'
    , './node_modules/popper.js/dist/popper.js'] )

    .addStyleEntry('css/app' , ['./assets/css/font/css/font-awesome.css'
    , './node_modules/bootstrap/dist/css/bootstrap.min.css'
    ])
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use Sass/SCSS files
//.enableSassLoader()

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
