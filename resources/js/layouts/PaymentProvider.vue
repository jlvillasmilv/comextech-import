<template>
        <div>
            <!-- Header -->
            <div class="flex justify-end">
                <button  @click="creating = !creating" class="flex  px-2 py-2 my-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>    
                    <span> {{ creating ? 'Agregar Pago': 'Cancelar Pago'}} </span>
                </button>
                <!-- <button class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>   
                    <span> Cotizar </span>
                </button> -->
            </div>
            <div class="flex">
                <!-- Selected Supplier -->
                <supplier/>
                <!-- table-payment Supplier -->
                <table-payment v-if="creating"/>
                <!-- Formu Add Supplier -->
                <add-payment v-else/>
            </div>
        </div>
</template>

<script>

import AddPayment from '../components/PaymentProvider/Form.vue'
import Supplier from '../components/Supplier/Searcher.vue'
import TablePayment from '../components/PaymentProvider/Table.vue'

export default {
  components: { Supplier, TablePayment, AddPayment },
  data(){
      return {
          creating:false
      }
  }

}
</script>

<style>

</style>