import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './registerServiceWorker'

Vue.config.productionTip = false

import Typed from 'typed.js';
Object.defineProperty(Vue.prototype, 'Typed', { value: Typed });

import saveSvgAsPng from 'save-svg-as-png';
Object.defineProperty(Vue.prototype, 'saveSvgAsPng', { value: saveSvgAsPng });

import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

axios.defaults.baseURL = '/api';
// axios.defaults.baseURL = 'http://localhost:8080/api';
// axios.defaults.baseURL = 'http://nimipet.local/api';
// axios.defaults.baseURL = 'https://nimipet.com/api';

Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

import enJson from '../public/lang/en.json';
import deJson from '../public/lang/de.json';
import frJson from '../public/lang/fr.json';
import itJson from '../public/lang/it.json';
import jpJson from '../public/lang/jp.json';
import krJson from '../public/lang/kr.json';
import nlJson from '../public/lang/nl.json';
import ruJson from '../public/lang/ru.json';
import ptbrJson from '../public/lang/ptbr.json';

// Ready translated locale messages
const messages = {
  en: { message: enJson },
  de: { message: deJson },
  fr: { message: frJson },
  it: { message: itJson },
  jp: { message: jpJson },
  kr: { message: krJson },
  nl: { message: nlJson },
  ru: { message: ruJson },
  ptbr: { message: ptbrJson },
}

// Create VueI18n instance with options
const i18n = new VueI18n({
  locale: 'en', // set locale
  messages, // set locale messages
})

new Vue({
  i18n,
  router,
  store,
  render: h => h(App)
}).$mount('#app')
