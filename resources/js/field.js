Nova.booting((Vue) => {
  Vue.component('nova-button-field', require('./components/NovaButton').default);
  Vue.component('index-nova-button-field', require('./components/Index/NovaButtonField').default);
  Vue.component('detail-nova-button-field', require('./components/Detail/NovaButtonField').default);
  Vue.component('form-nova-button-field', require('./components/Form/NovaButtonField').default);
  Vue.component('index-nova-button-group-field', require('./components/Index/NovaButtonGroupField').default);
  Vue.component('detail-nova-button-group-field', require('./components/Detail/NovaButtonGroupField').default);
  Vue.component('form-nova-button-group-field', require('./components/Form/NovaButtonGroupField').default);
});
