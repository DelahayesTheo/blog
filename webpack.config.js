// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .enableVersioning()
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    // Vendors
    .createSharedEntry('vendor', [
        'jquery',
        'bootstrap',

        // you can also extract CSS - this will create a 'vendor.css' file
        // this CSS will *not* be included in page1.css or page2.css anymore
        './assets/css/vendor.scss'
    ])
    // Custom Style
    .addStyleEntry('main', './assets/css/main.scss')

;

// export the final configuration
module.exports = Encore.getWebpackConfig();