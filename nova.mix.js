const mix = require('laravel-mix')
const webpack = require('webpack')
const path = require('path')
console.log('__dirname', __dirname)
console.log('@', path.join(__dirname.split('/vendor/')[0], 'vendor/laravel/nova/resources/js/'))

class NovaExtension {
  name() {
    return 'nova-extension'
  }

  register(name) {
    this.name = name
  }

  webpackPlugins() {
    return new webpack.ProvidePlugin({
      _: 'lodash',
      Errors: 'form-backend-validation',
    })
  }

  webpackConfig(webpackConfig) {
    webpackConfig.externals = {
      vue: 'Vue',
    }

    // __dirname = /web/project/vendor/dnwjn/nova-button
    webpackConfig.resolve.alias = {
      ...(webpackConfig.resolve.alias || {}),
      'laravel-nova': [
          path.join(__dirname.split('/vendor/')[0], 'vendor/laravel/nova/resources/js/'),
          path.join(__dirname, './vendor/laravel/nova/resources/js/'),
          path.join(__dirname, '../vendor/laravel/nova/resources/js/'),
          path.join(__dirname, '../../vendor/laravel/nova/resources/js/'),
          path.join(__dirname, '../../../vendor/laravel/nova/resources/js/'),
      ],
      '@': [
          path.join(__dirname.split('/vendor/')[0], 'vendor/laravel/nova/resources/js/'),
          path.join(__dirname, './vendor/laravel/nova/resources/js/'),
          path.join(__dirname, '../vendor/laravel/nova/resources/js/'),
          path.join(__dirname, '../../vendor/laravel/nova/resources/js/'),
          path.join(__dirname, '../../../vendor/laravel/nova/resources/js/'),
      ]
    }

    webpackConfig.output = {
      uniqueName: this.name,
    }
  }
}

mix.extend('nova', new NovaExtension())
