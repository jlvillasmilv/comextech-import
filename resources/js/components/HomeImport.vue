<template>
  <div class="container grid px-6 mx-auto my-6 text-1xl font-semibold text-gray-700 dark:text-gray-200">
        <ul class="flex justify-center items-center my-4">
            <div v-for="(item, id) in tabs"   :key="id" @click="toogleMenu(item)"    >
                <li v-if="item.selected"   :class="['cursor-pointer py-2 px-5 text-gray-500 border-b-8', item.name == activetab ? 'text-b-500 border-indigo-500' : '']">
                        {{ item.name}}
                </li>
            </div>
        </ul>
         <div class="w-full  p-2 ">
                <div  v-if="activetab ==='Bodegaje Local'">
                        Bodegaje Local
                </div>
                <div  v-if="activetab ==='Pago Proveedor'" > 
                    <div class="flex justify-end">
                        <button class="flex  px-2 py-2 my-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>    
                            <span> Agregar Pago </span>
                        </button>
                        <button class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>   
                            <span> Cotizar </span>
                        </button>
                    </div>
                    <div class="flex">
                        <FormSupplier></FormSupplier>
                        <TablePayment></TablePayment>
                    </div>
                </div>
                <div v-if="activetab ==='Gestion de Cambio'"> 
                        Gestion de Cambio
                </div>
                <div v-if="activetab ==='Transp. Local'"> 
                        Transp. Local
                </div>
                <div v-if="activetab ==='Internacion'"> 
                        Internacion
                </div>
                <div v-if="activetab ==='Servicio de Origen'"> 
                        Internacion
                </div>
        </div>
        <Modal @sucessModal="generateForm" :default="statusModal" :title="title"> 
             <template v-slot:body>
                 <div class="mt-2">
                    <label   v-for="(item, id) in tabs"   :key="id" class="flex items-center ml-6 text-gray-600 dark:text-gray-400">
                        <input    @click="tabsAdd(item)" value="Financiamiento" type="checkbox" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="3"  />
                        <span class="ml-2"> {{item.name}} </span>
                    </label>
                </div>
            </template>
        </Modal>
      
</div>
</template>
<script>
    import FormSupplier from './FormSupplier'
    import Modal from './Modal.vue'
    import TablePayment from './TablePayment'

    export default {
        data(){
            return {
                tabs:[
                    {
                        name:"Gestion de Cambio", selected:false, id:1
                    },
                    {
                        name:"Transp. Local", selected:false, id:2
                    },
                    {
                        name:"Internacion", selected:false, id:3
                    },
                    {
                        name:"Pago Proveedor", selected:false,id:4
                    },
                    {
                        name:"Bodegaje Local", selected:false, id:5
                    },
                    {
                        name:"Transp. Internacional", selected:false, id:6
                    },
                    {
                        name:"Servicio de Origen", selected:false, id:7
                    },

                ],
                activetab:"",
                statusModal:true,
                title:"Selecione Servicios para Cotizacion"
            }
        },
        components:{
            FormSupplier,
            TablePayment,
            Modal            
        },
        methods:{
            generateForm(){
               console.log({...this.tabs})
            },
            tabsAdd(item ){
              this.tabs = this.tabs.map(e => e.id === item.id ? {...e, selected:!e.selected }: e)
            },
            toogleMenu(value){
                this.activetab = value.name
            }
        },
        
        created(){
           
        }
    }
</script>

 