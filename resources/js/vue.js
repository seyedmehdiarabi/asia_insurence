import Vue from "vue";
window.Vue = Vue;
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

import {store} from "./store";
window.store = store;

Vue.prototype.$siteUrl = document.querySelector('meta[name="app_url"]').getAttribute('content');
Vue.prototype.$siteName = 'CRM Towse Pesteh Shargh';
Vue.prototype.$productUrlParam = '/';

Vue.component('app-content', require('./components/AppContent').default);
Vue.component('progress-box', require('./components/Progress').default);

import Vuetify from 'vuetify';
Vue.use(Vuetify);
window.Vuetify = Vuetify;

import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

Vue.use(VuePersianDatetimePicker, {
    name: 'date-picker',
    props: {
        editable: false,
        inputClass: 'datePicker',
        color: '#039eff',
        autoSubmit: false,
        locale: "fa,en",
    }
});

import(/* webpackChunkName:'users' */'../../modules/users/resources/js/components.js');
import(/* webpackChunkName:'panelTheme' */'../../modules/panelTheme/resources/js/components.js');
import(/* webpackChunkName:'address' */'../../modules/address/resources/js/components.js');
import(/* webpackChunkName:'messages' */'../../modules/messages/resources/js/components.js');
import(/* webpackChunkName:'visitStatistics' */'../../modules/visitStatistics/resources/js/components.js');
import(/* webpackChunkName:'lands' */'../../modules/lands/resources/js/components.js');
import(/* webpackChunkName:'planVisit' */'../../modules/planVisit/resources/js/components.js');
import(/* webpackChunkName:'gallery' */'../../modules/gallery/resources/js/components.js');
import(/* webpackChunkName:'panel-gallery' */'../../modules/gallery/resources/js/panel-components.js');
import(/* webpackChunkName:'phoneBook' */'../../modules/phoneBook/resources/js/components.js');
import(/* webpackChunkName:'orders' */'../../modules/orders/resources/js/components.js');
import(/* webpackChunkName:'stockroom' */'../../modules/stockroom/resources/js/components.js');
import(/* webpackChunkName:'Customer' */'../../modules/Customer/resources/js/components.js');
