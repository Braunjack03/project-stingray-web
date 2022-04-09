import Vue from 'vue';

import { createInertiaApp } from '@inertiajs/inertia-vue';
import { TiptapVuetifyPlugin } from 'tiptap-vuetify';
import Vuelidate from 'vuelidate';
import vuetify from './vuetify';
import VueMeta from 'vue-meta'

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
import '../css/style.scss';
import '../css/additional-styles/theme.scss';
import '../css/additional-styles/utility-patterns.scss';
import '../css/additional-styles/range-slider.scss';

import '@mdi/font/css/materialdesignicons.css';

// don't forget to import CSS styles
import 'tiptap-vuetify/dist/main.css';

Vue.use(Vuelidate);

Vue.use(VueSweetalert2);

createInertiaApp({
  resolve: (name) => require(`./pages/${name}`),
  setup({ el, app, props }) {
    new Vue({
      render: (h) => h(app, props),
      vuetify,
    }).$mount(el);
  },
});

Vue.use(TiptapVuetifyPlugin, {
  // the next line is important! You need to provide the Vuetify Object to this place.
  vuetify, // same as "vuetify: vuetify"
  // optional, default to 'md' (default vuetify icons before v2.0.0)
  iconsGroup: 'mdi',
});

Vue.use(VueMeta, {
  // optional pluginOptions
  refreshOnceOnNavigation: true
})

Vue.filter('stripHTML', (value) => {
  const div = document.createElement('div');
  div.innerHTML = value;
  const text = div.textContent || div.innerText || '';
  return text;
});
