import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import vuetify from './vuetify';

createInertiaApp({
  resolve: name => require(`./pages/${name}`),
  setup({ el, app, props }) {
    new Vue({
      render: h => h(app, props),
      vuetify
    }).$mount(el)
  },
})