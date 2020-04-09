var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    // the public path you will use in Symfony's asset() function - e.g. asset('build/some_file.js')
    .setManifestKeyPrefix('build/')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isDev())

    // the following line enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isDev())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/ad', './assets/js/ad.js')
    .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
