<template>
  <div class="flex flex-wrap">
    <partners /> 
    <div class="mt-4 sm:w-full md:w-full lg:w-4/12">
      <span class="text-blue-1300 text-base font-medium mb-4">
        Contrato de Marco
      </span>
      <hr class="mt-1 mb-1 border-solid border-t-2" />
      <SingleFile :action="`Adjuntar`" :data="`contrato_marco`"></SingleFile>
    </div>
  </div>
</template>

<script>
import SingleFile from '../components/Factoring/SingleFile';
import Partners from '../components/Factoring/Partners';
export default {
  data() {
    return {
      title: 'Informacion Legal'
    };
  },
  components: {
    partners: Partners,
    SingleFile
  },
  computed: {
    upPower() {
      // console.log('aqui');
    }
  }
};
</script>
