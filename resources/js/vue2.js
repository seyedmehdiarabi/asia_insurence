import Vue from "vue";
window.Vue = Vue;
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);
import {store} from "./store";
window.store = store;

import(/* webpackChunkName:'users' */'../../modules/users/resources/js/components.js');
import(/* webpackChunkName:'panelTheme' */'../../modules/panelTheme/resources/js/components.js');
import(/* webpackChunkName:'address' */'../../modules/address/resources/js/components.js');
import(/* webpackChunkName:'messages' */'../../modules/messages/resources/js/components.js');
import(/* webpackChunkName:'visitStatistics' */'../../modules/visitStatistics/resources/js/components.js');

