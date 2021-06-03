window.$ = window.jQuery = require('jquery');
require('./bootstrap');
require('datatables');

import HomeImport  from './components/HomeImport'

import Vue from 'vue';

import 'alpinejs'

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)

const app = new Vue({
    el: '#app',
    
    components:{
        'home-import-app': HomeImport,
    }
});
