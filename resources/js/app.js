window.$ = window.jQuery = require('jquery');
require('./bootstrap');

import Import  from './views/Import'

import Vue from 'vue';

//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
window.Toast = Toast




import 'alpinejs'

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)
 

const app = new Vue({
    el: '#app',  
    components:{
        'home-import-app': Import,
    }
});
