<template>
  <div
    v-if="data.type_transport != 'COURIER'"
    class="relative flex flex-col items-center w-full mb-4 mt-2"
  >
    <div class="absolute w-11/12 lg:w-9/12 ">
      <button
        @click="showLocalTransport()"
        :class="[
          `md:w-4/12
                  focus:outline-none
                  uppercase
                  text-xs
                  font-semibold
                  py-3
                  px-2
                  border 
                  border-blue-1000
                  rounded`,
          showShipping
            ? 'bg-white text-blue-1000 hover:bg-blue-1000 hover:text-white'
            : 'bg-blue-1000 text-white hover:bg-white hover:text-blue-1000'
        ]"
      >
        Transporte Local
      </button>
    </div>
    <div
      :class="[
        `flex 
                flex-wrap 
                justify-center 
                w-11/12 
                lg:w-9/12 
                mt-5 
                pt-6 
                pb-4 
                border-t-2 
                border-r-2 
                border-b-2 
                rounded-t-md 
                rounded-r-md`,
        showShipping ? '' : 'h-12'
      ]"
    >
      <div v-if="showShipping" class="flex flex-col w-full">
        <div class="flex flex-wrap justify-center my-4">
          <div class="flex justify-center items-center sm:w-4/12 mx-2 my-2">
            <button
              :class="[
                `w-40 
              text-xs 
              uppercase 
              px-2 
              py-2 
              border 
              border-blue-1300
              rounded-md`,
                isLocalAddress
                  ? 'bg-white text-blue-1300 active:bg-blue-1300 active:text-white'
                  : 'bg-blue-1300 text-white hover:bg-white hover:text-blue-1300'
              ]"
              type="button"
              @click="localAddress(true)"
            >
              Dirección cliente
            </button>
          </div>
          <div class="flex justify-center items-center sm:w-4/12 mx-2 my-2">
            <button
              :class="[
                `w-40 
              text-xs 
              uppercase 
              px-2 
              py-2 
              border 
              border-blue-1300
              rounded-md`,
                isLocalAddress
                  ? 'bg-blue-1300 text-white hover:bg-white hover:text-blue-1300'
                  : 'bg-white text-blue-1300 active:bg-blue-1300 active:text-white'
              ]"
              type="button"
              @click="localAddress(false)"
            >
              Dirección bodegaje
            </button>
          </div>
        </div>
        <!-- Destino de Envio -->
        <div v-if="showShipping || data.type_transport == 'COURIER'" class="w-11/12 mb-4 md:px-2">
          <dest-address :isLocalAddress="isLocalAddress" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import DestAddress from './DestAddress.vue';
export default {
  data() {
    return {
      showShipping: false,
      isLocalAddress: true
    };
  },
  components: { DestAddress },
  methods: {
    /* Show/Hide button transporte local */
    showLocalTransport() {
      this.showShipping = !this.showShipping;
    },

    localAddress(isLocal) {
      this.isLocalAddress = isLocal;
    }
  },
  computed: {
    ...mapState('application', ['data'])
  }
};
</script>
