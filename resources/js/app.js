window.$ = window.jQuery = require('jquery');
require('./bootstrap');
require('datatables');

import HomeImport  from './components/HomeImport'

import Vue from 'vue';

import 'alpinejs'


const app = new Vue({
    el: '#app',
    
    components:{
        'menu-app': HomeImport,
    }
});
