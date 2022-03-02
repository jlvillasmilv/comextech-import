<template>
  <div>
    <div class="flex flex-wrap justify-center md:-mx-5 p-1 w-full">
      <div
        class="flex flex-col md:flex-shrink-0 md:flex-grow-0 relative sm:w-full md:w-full lg:w-6/12 px-2"
      >
        <span class="text-center text-blue-1300 text-lg font-medium mb-2">
          Estados Financieros
        </span>
        <hr />
        <SingleFile :action="`Adjuntar`" :data="`estados_finacieros`"></SingleFile>
        <br />
        <span class="text-center text-blue-1300 text-lg font-medium mb-2"> Presentacion de Empresa</span>
        <hr />
        <SingleFile :action="`Adjuntar`" :data="`presentacion_empresa`"></SingleFile>
        <!-- <br />
        <span class="text-center text-blue-1300 text-lg font-medium mb-2">
          Otros
        </span>
        <hr />
        <SingleFile :action="`Adjuntar`" :data="`otros`"></SingleFile> -->
      </div>
      <div
        class="flex flex-col md:flex-shrink-0 md:flex-grow-0 relative sm:w-full md:w-full lg:w-6/12 px-2"
      >
        <span class="text-center text-blue-1300 text-lg font-medium mb-2">
          Carpetas Tributarias Actualizadas
        </span>
        <hr />
        <SingleFile :action="`Adjuntar`" :data="`carp_tributaria`"></SingleFile>
        <br />
        <span class="text-center text-blue-1300 text-lg font-medium mb-2">
          Última declaracion de Impuesto (SII)
        </span>
        <hr />
        <SingleFile :action="`Adjuntar`" :data="`impuesto_sii`"></SingleFile>
      </div>
    </div>
  </div>
</template>

<script>
import SingleFile from '../components/Factoring/SingleFile';
import DownloadFile from '../components/Factoring/DownloadFile';

export default {
  data() {
    return {
      title: 'Informacion Financiera'
    };
  },
  components: {
    SingleFile,
    DownloadFile
  },
  computed: {
    upPower() {
      // console.log('aqui');
    }
  }
};
</script>
