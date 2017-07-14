// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .enableVersioning()
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())

    // Custom Style
    .addStyleEntry('main', './assets/css/main.scss')

;

// export the final configuration
module.exports = Encore.getWebpackConfig();