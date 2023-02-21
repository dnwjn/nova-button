const mix = require('laravel-mix')
const path = require('path')

require('./nova.mix')

mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .vue({ version: 3 })
  .alias({ '@': path.join(__dirname, '../../laravel/nova/resources/js/') })
  .nova('dnwjn/nova-button')
