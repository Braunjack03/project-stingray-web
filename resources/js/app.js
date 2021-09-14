import Vue from 'vue'

import { createInertiaApp } from '@inertiajs/inertia-vue'
import { TiptapVuetifyPlugin } from 'tiptap-vuetify';



import vuetify from './vuetify';
import '../css/app.css';
import '@mdi/font/css/materialdesignicons.css';

// don't forget to import CSS styles
import 'tiptap-vuetify/dist/main.css';

import 'vuetify/dist/vuetify.min.css';


createInertiaApp({
  resolve: name => require(`./pages/${name}`),
  setup({ el, app, props }) {
    new Vue({
      render: h => h(app, props),
      vuetify
    }).$mount(el)
  },
})


Vue.use(TiptapVuetifyPlugin, {
  // the next line is important! You need to provide the Vuetify Object to this place.
  vuetify, // same as "vuetify: vuetify"
  // optional, default to 'md' (default vuetify icons before v2.0.0)
  iconsGroup: 'mdi'
})