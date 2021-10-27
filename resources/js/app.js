window.$ = window.jQuery = require('jquery');
require('./bootstrap');

import Import from './pages/Import';

import Vue from 'vue';
import store from './store';

//Import Sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
window.Toast = Toast;

import 'alpinejs';

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect);

import VueMask from 'v-mask';
Vue.use(VueMask);

//Import v-from
import { Form } from 'vform';
window.Form = Form;

//date time Luxon
import VueLuxon from 'vue-luxon';
Vue.use(VueLuxon, {
    templates: {},
    input: {
        zone: 'utc',
        format: 'iso'
    },
    output: {
        zone: 'local',
        format: 'date_huge',
        locale: null,
        relative: {
            round: true,
            unit: null
        }
    }
});

import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(VueLoading);

// component tab 
import './assets/tabs-component.css'
import Tabs from 'vue-tabs-component';
Vue.use(Tabs);

import Quote from './views/Quote'

const app = new Vue({
    el: '#app',
    store,
    components: {
        'home-import-app': Import,
        'view-quote': Quote,
    }
});
