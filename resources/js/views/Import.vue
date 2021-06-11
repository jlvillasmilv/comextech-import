<template>
     <div class="md:container md:mx-auto text-gray-900 dark:text-gray-200">
        <ul class="flex justify-center items-center mt-2 ">
                    <button  @click="statusModal = !statusModal"  class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>   
                    </button>
            <div v-for="(item, id) in tabs"   :key="id" @click="toogleMenu(item)"    >
                <li v-if="item.selected"   :class="['cursor-pointer py-2 px-5 text-gray-500 border-b-8', item.name == activetab ? 'text-b-500 border-indigo-500' : '']">
                        {{ item.name}}
                </li>
            </div>
        </ul>
         <div class="w-full p-2 ">
                <div  v-if="activetab ==='Bodegaje Local'">
                        Bodegaje Local
                </div>
                <div  v-if="activetab ==='Pago Proveedor'" > 
                     <payment-provider/>
                </div>
                <div v-if="activetab ==='Gestion de Cambio'"> 
                        Gestion de Cambio
                </div>
                <div v-if="activetab ==='Transp. Internacional'">
                     <transport/>
                </div>
                <div v-if="activetab ==='Internacion'"> 
                        Internacion
                </div>
                <div v-if="activetab ==='Servicio de Origen'"> 
                        Internacion
                </div>
                <div v-if="activetab ==='Financiamiento'"> 
                   
                </div>
        </div>
        <Modal v-if="statusModal"  :title="title" class="mt-10"> 
            <template v-slot:body>
                <div class="mt-2" v-if="!next">
                <label   
                    v-for="(item, id) in tabs"   
                    :key="id" 
                    class="flex items-center ml-6 my-2 focu:otext-gray-600 dark:text-gray-400"
                >
                    <input  @click="tabsAdd(item)" :checked="item.selected" type="checkbox" class=" focus:outline-none  form-checkbox h-5 w-5 text-green-600"  > <span class="ml-2"> {{item.name}} </span>
                </label>
                </div>
                <div  v-else>
                    <div class="flex flex-wrap -mx-3 my-3 ">
                        <v-select 
                            label="name"  
                            v-model="payment.suppliers_id"  
                            :reduce="s => s.id"  
                            :class="[classStyle.wfull, classStyle.input, 'mx-2']" 
                            placeholder="Seleccionar Proveedor" 
                            :options="suppliers">
                            <template v-slot:no-options="{ search, searching }" >
                                <template v-if="searching" class="text-sm">
                                Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                            </template>
                            <em style="opacity: 0.5;" v-else> No posee proveedores en tu lista</em>
                                </template>
                        </v-select>
                    </div>
                    <div class="flex flex-wrap -mx-3  ">
                        <div class="w-full md:w-1/2 px-3 mb-2 md:mb-0">
                            <label 
                            :class="[classStyle.label]"
                            >
                                Monto Total Operacion
                            </label>
                            <input 
                                v-model.number="payment.amount"  
                                :class="[classStyle.input, classStyle.wfull, classStyle.formInput ]" 
                            />
                            </div>
                        <div class="w-full md:w-1/2 px-3 mb-2 md:mb-0">
                            <label  
                                :class="[classStyle.label], "> 
                                Moneda 
                            </label>
                            <v-select 
                                label="name_code" 
                                v-model="payment.currency_id" 
                                :reduce="currencie => currencie.id" 
                                :class="[classStyle.input, ' text-sm mt-1  ']"
                                placeholder="Moneda" 
                                :options="currencies" 
                            > ">
                            <template  v-slot:no-options="{ search, searching }" >
                                    <template v-if="searching" class="text-sm">
                                    Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                                    </template>
                                <em style="opacity: 0.5;" v-else>  Moneda </em>
                            </template>
                            </v-select>
                        </div>
                    </div>   
                        <div class="flex flex-wrap -mx-3  ">
                        <div class="w-1/6 md:w-1/2 px-3 mb-2 md:mb-0">
                                <label :class="[classStyle.label]" >
                                    Porcentaje de Adelanto  %
                                </label>
                                <input  
                                    v-model.number="payment.fee1" 
                                    @input="setValidate()"     
                                    placeholder="30%" 
                                    class="text-center  w-15 h-9 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                                />
                                <span 
                                    v-if="payment.fee1 > 0" 
                                    :class="[classStyle.span ]"                                     
                                    > 
                                    {{ mount1 }} 
                                </span>
                        </div>
                        <div class="w-1/6  md:w-1/2 px-3 mb-2 md:mb-0">
                            <label 
                             :class="[classStyle.label ]" 
                            >
                                Fecha a Pagar Porcentaje
                            </label>
                            <input 
                                v-model="payment.feed1_date"  
                                type="date" 
                                :class="[classStyle.input, classStyle.wfull, classStyle.formInput ]" 
                            />
                        </div>
                    </div>   
                        <div class="flex flex-wrap -mx-3  "  >
                        <div class="w-1/6 md:w-1/2 px-3 mb-2 md:mb-0">
                            <label class="flex text-gray-700 text-xs dark:text-gray-400" >
                                Porcentaje Contra Entrega %
                            </label>
                            <input  
                                    :disabled="true" 
                                    :value="payment.fee2"
                                    class="text-center  w-15 h-9 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
 
                             />
                            <span 
                                v-if="payment.fee1 > 0" 
                                :class="[classStyle.span ]"  
                             > 
                                    {{ mount2 }} 
                            </span>
                        </div>
                        <div class="w-1/6  md:w-1/2 px-3 mb-2 md:mb-0">
                            <label :class="[classStyle.label ]" >
                                Fecha a Pagar  Contra Entrega
                            </label>
                            <input 
                                type="date" 
                                v-model="payment.fee2_date" 
                                :class="[classStyle.input, classStyle.wfull, classStyle.formInput ]"  
                             />
                            </div>
                    </div>     
                        <div class="flex flex-wrap -mx-3  ">
                            <div class="w-1/2 md:w-1/2 px-3 mb-2 md:mb-0">
                                <label :class="[classStyle.label ]" >
                                Description  
                            </label>
                            <textarea 
                                    v-model="payment.description"
                                    name="message" 
                                    :class="[ classStyle.wfull, classStyle.formInput, 'py-4 px-4 text-xs' ]"   
                                    placeholder="Necesito importar un Equipo desde China con Valor del Equipo es USD 50.000,00 Pago de 20% adelanto y 80% Saldo contra entrega Entrega para 30 dias a partir del adelanto"														
                                >
                            </textarea>
                            </div>
                            <div class="w-1/2 md:w-1/2 px-3 mb-2 md:mb-0">
                            <label :class="[classStyle.label ]"  >
                                Fecha de Estimacion
                            </label>
                            <input 
                                type="date" 
                                v-model="payment.estimated_date" 
                                :class="[classStyle.input, classStyle.wfull, classStyle.formInput ]" 
                            >
                             </div>
                            
                    </div>
                </div>
            </template>
            <template v-slot:footer>
                <div v-if="next">
                    <button 
                        @click="next = !next" 
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                    >
                        Atras
                    </button>
                    <button  
                        @click="submitFormApplications()" 
                        class="transform motion-safe:hover:scale-110 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                        Aceptar
                    </button >
                </div >
                <div v-else>
                    <button @click="clearSeletedTabs()" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                        Cancelar
                    </button>
                    <button 
                        v-if="tabsSelected.length > 0"
                        @click="next = !next" 
                        class=" transform motion-safe:hover:scale-110 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green"
                    >
                        Siguiente
                    </button>
                </div>
            </template>
        </Modal>
    </div>
</template>
<script>
    import PaymentProvider from '../layouts/PaymentProvider.vue'
    import Modal from '../components/Modal.vue'
    import Transport from '../components/Transport.vue'
    
    export default {
        name:"HomeImport",
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
                payment:{
                   amount:0,
                   currency_id:'',
                   suppliers_id:'',
                   fee1:0,
                   fee2:0,
                   fee1_date:'',
                   fee2_date:'',
                   description:'',
                   estimated_date:'',
                   description:''
                },
                suppliers:[],
                activetab:"",
                statusModal:true,
                title:"Servicios para Cotizacion",
                next:false,
                currencies:[],
                tablePayment:[],
                classStyle:{
                    span:'ml-15 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray ',
                    input:'block  text-center  mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray',
                    wfull:'w-full',
                    formInput:' form-input',
                    label:'block  text-gray-700 text-xs dark:text-gray-400'
                }

           }
        },
        components:{
            Modal,
            PaymentProvider,
            Transport,
        },
        methods:{
            tabsAdd(item){
                this.tabs = this.tabs.map(e => e.id === item.id ? {...e, selected:!e.selected }: e)
            },
            toogleMenu(value){
                this.activetab = value.name
            },
            setValidate(){
                if(isNaN(this.payment.fee1) || this.payment.fee1 > 100  ){
                     this.payment.fee1 = 0
                }else{
                    this.payment.fee2 = 100 - this.payment.fee1
                }
            },
            clearSeletedTabs(){
                this.statusModal = !this.statusModal
                this.tabs.map(e => e.selected = false)
            },
            async submitFormApplications(){
                 
                try {
                    let data  = await axios.post("/applications", { payload: {
                        payment: this.payment,
                        services: this.tabs
                        }
                    })

                    this.statusModal = !this.statusModal
                } catch (error) {
                    console.log(error);
                }
            }
        },
        computed:{
            mount2(){
                return Math.round(this.payment.amount * (this.payment.fee2 / 100))
            },
            mount1(){
                return Math.round( this.payment.amount * (this.payment.fee1 / 100))
            }, 
            tabsSelected(){
                return this.tabs.filter(e => e.selected !== false )
            }
        },
        async created(){
            try {
                let suppliers   = await axios.get("/supplierlist");
                let currencies  = await axios.get("/api/currencies");
                let tabs        = await axios.get("/api/category_services");
                this.suppliers  = suppliers.data
                this.currencies = currencies.data
             
            } catch (error) {
                console.log(error);
            }
        },
        
         
    }
</script>

 