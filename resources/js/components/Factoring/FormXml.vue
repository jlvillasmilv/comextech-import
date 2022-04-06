<template>
  <div class="">
    <div class="flex">
      <div class="">
        <button
          v-if="show"
          type="submit"
          class="mt-2 mx-2 text-white bg-blue-1300 inline-block text-center align-middle p-2 text-sm rounded hover:bg-blue-1200 focus:shadow-outline-blue focus:outline-none"
          @click="onFormSubmit"
        >
          CARGAR
        </button>
        <button
          type="submit"
          v-show="sendMode"
          class="mt-2 mx-2 text-white bg-blue-1300 inline-block text-center align-middle p-2 text-sm rounded hover:bg-blue-1200 focus:shadow-outline-blue focus:outline-none"
          @click="onAnticipate"
        >
          SOLICITAR
        </button>
      </div>
      <div class="ml-auto pb-2">
        <a
          class="mt-2 mx-2 text-white bg-gray-600 border-gray-700 inline-block text-center align-middle p-2 text-sm rounded hover:bg-gray-800"
          @click="showdropzone()"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              v-if="show"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M7 11l5-5m0 0l5 5m-5-5v12"
            />

            <path
              v-else
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 13l-5 5m0 0l-5-5m5 5V6"
            />
          </svg>
        </a>
      </div>
    </div>
    <vue-dropzone
      v-show="show"
      ref="myVueDropzone"
      id="dropzone"
      @vdropzone-success="successResponse"
      :options="dropzoneOptions"
      :useCustomSlot="true"
    >
      <div class="dropzone-custom-content">
        <h3 class="dropzone-custom-title text-blue-1000 font-bold text-2xl mb-2">
          Arrastrar aqui archivos XML
        </h3>
        <div class="text-lg">
          o haga clic para seleccionar un archivo de su computadora
        </div>
      </div>
    </vue-dropzone>
    <quote_table :source="source" :items="items" />
  </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import QuoteTable from '../Factoring//QuoteTable';
const moment = require('moment');

import Option from '../../config/alert';

export default {
  name: 'Quote',
  data: function() {
    return {
      data: {},
      items: [],
      sendMode: false,
      source: 'xml',
      show: true,
      exit: false,
      route: 'applications',
      dropzoneOptions: {
        url: '/factoring/file',
        headers: {
          'X-CSRF-TOKEN': document.head.querySelector('[name=csrf-token]').content
        },
        params: {
          type: 'xml_sii',
          user: {}
        },
        dictDefaultMessage: 'Arrastrar aqui archivos XML',
        autoProcessQueue: false,
        addRemoveLinks: true,
        acceptedFiles: 'text/xml',
        thumbnailWidth: 150,
        maxFilesize: 1,
        parallelUploads: 20
      }
    };
  },
  components: {
    vueDropzone: vue2Dropzone,
    quote_table: QuoteTable
  },
  methods: {
    showdropzone() {
      this.show = !this.show;
    },
    successResponse(file, response) {
      if (response.status) {
        this.$refs.myVueDropzone.removeAllFiles();
        return this.$swal.fire(Option('error', response.status));
      }
      var date = moment().format('YYYY-MM-DD');
      var emisor = moment(response.issuing_date);
      var date = moment(date);
      let array = this.items.filter((item) => item.number === response.number);
      let diff = date.diff(emisor, 'days');

      if (array.length > 0) {
        this.$refs.myVueDropzone.removeAllFiles();
        var message = `Factura Folio #${array[0].number} ya existe!`;
        return this.$swal.fire(Option('warning', message));
      }
      if (diff < 61) {
        this.$swal.fire(Option('success', 'Factura cotizada con exito!'));
        this.items.push(response);
        localStorage.setItem('quote-xml', JSON.stringify(this.items));
        this.sendMode = this.items.length > 0 ? true : false;
        this.$refs.myVueDropzone.removeAllFiles();
      } else {
        this.$refs.myVueDropzone.removeAllFiles();
        var message =
          'Por política de aprobación, no podemos financiar facturas con fecha de emisión mayor a 30 días.!';
        return this.$swal.fire(Option('warning', message));
      }
    },
    onFormSubmit() {
      this.$refs.myVueDropzone.processQueue();
    },
    async onAnticipate() {
      let value = this.items.filter((item) => item.change_expire === undefined);

      if (value.length > 0) {
        return this.$swal.fire(
          Option('warning', 'Todas la facturas requieren de actualizar la fecha de vencimiento! ')
        );
      }
      const { value: result } = await Swal.fire({
        title: 'Esta seguro de Realizar la solicitud?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, solicitar!',
        cancelButtonText: 'Cancelar'
      });
      if (result) {
        try {
          let payload = {
            items: this.items,
            source: 'XML'
          };
          let response = await axios.post('/factoring/quote/anticipate', payload);
          this.items.splice(0);
          localStorage.removeItem('quote-xml');
          this.sendMode = this.items.length > 0 ? true : false;
          Swal.fire({
            icon: 'success',
            title: 'Se ha creado la solicitud! ',
            text: ` Tu solicitud Nº ${response.data.application.id} 
                                requiere de una evaluacion y aprobacion para su ejecucion, 
                                te informaremos a tu email ${response.data.user.email}
                                `,
            footer: '<a href=' + this.route + '> Ver tus solicitudes? </a>'
          });
          window.setTimeout(function() {
            window.location.reload();
          }, 2000);
        } catch (error) {
          Swal.fire('Ah ocurrido un error!', 'Lo sentimos, vuelva a intentar', 'error');
        }
      }
    },
    onDelete: function(index, value) {
      this.items.splice(index, 1);
      localStorage.setItem('quote-xml', JSON.stringify(this.items));
      this.sendMode = this.items.length > 0 ? true : false;
    }
  },
  created() {
    this.$root.$refs.A = this;
    let datosDB = JSON.parse(localStorage.getItem('quote-xml'));

    if (datosDB === null) {
      this.items = [];
    } else {
      this.items = datosDB;
      this.sendMode = this.items.length > 0 ? true : false;
    }
  },
  beforeMount() {
    this.dropzoneOptions.params.user = JSON.stringify(this.user);
  }
};
</script>
