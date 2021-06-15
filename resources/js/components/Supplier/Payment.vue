<template>
    <div class="w-1/2 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:text-gray-200 dark:bg-gray-800  ">
    <!-- <v-select label="name" v-model="payload.bank_id" :options="banks" :reduce="bank => bank.id" > "></v-select> -->
     <h3 class="my-4  font-semibold text-gray-700 dark:text-gray-200">
             Informacion de Proveedor
    </h3>
        <div class="dark:text-gray-200">   
            <h3 class="my-4  text-gray-500 text-sm">
                    Proveedor de Mercancia
            </h3>
            <v-select 
                label="name"   
                placeholder="Seleccionar Proveedor" 
                :options="suppliers" 
            >
                <template  v-slot:no-options="{ search, searching }" >
                    <template v-if="searching" class="text-sm">
                    Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                </template>
                <em style="opacity: 0.5;" v-else> No posee proveedores en tu lista</em>
                    </template>
            </v-select>
        </div>
        <div class="dark:text-gray-200">   
             <h3 class="my-3 text-gray-500 text-sm ">
                Moneda de Pago
            </h3>
            <v-select 
                label="name_code" 
                v-model="form.currency_id" 
                :reduce="currencie => currencie.id" 
                placeholder="Moneda" 
                :options="currencies" 
                >
                            
                <template  v-slot:no-options="{ search, searching }" >
                        <template v-if="searching" class="text-sm">
                        Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                        </template>
                    <em style="opacity: 0.5;" v-else>  Moneda </em>
                </template>
            </v-select>
        </div>
       
        <div class="flex flex-wrap -mx-3  ">
                <div class="w-full md:w-1/2 px-3  md:mb-0">
                    <h3 class="my-3 text-gray-500 text-sm ">
                    Fecha de Estimacion
                    </h3>
                    <input 
                        type="date" 
                        v-model="form.estimated_date" 
                        :class="[classStyle.input, classStyle.wfull, classStyle.formInput ]" 
                    >
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <h3 class="my-3  text-gray-500  text-sm">
                    Monto Total de Operacion
                    </h3>
                    <input 
                        :class="[classStyle.input, classStyle.formInput,classStyle.wfull ]" 
                    />
                </div>
        </div>
        <div class="dark:text-gray-200">   
            <h3 class="my-4  text-gray-500  text-sm ">
                        Description
            </h3>
                <textarea 
                    v-model="form.description"
                    name="message" 
                    :class="[ classStyle.wfull, classStyle.formInput, 'py-4 px-4 text-xs' ]"   
                    placeholder="Necesito importar un Equipo desde China con Valor del Equipo es USD 50.000,00 Pago de 20% adelanto y 80% Saldo contra entrega Entrega para 30 dias a partir del adelanto"														
                >
                </textarea>
        </div>
         
    </div>
</template>

<script>
export default {
     data(){
         return{
            supplier:{},
            supp:false,
            suppliers:[],
            classStyle:{
                span:'ml-15 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray ',
                input:'block  text-center  mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none   dark:text-gray-300 dark:focus:shadow-outline-gray',
                wfull:'w-full',
                formInput:' form-input',
                label:'block  text-gray-700 text-xs dark:text-gray-400'
            },
            currencies:[],
            form: new Form({
                   amount:0,
                   currency_id:'',
                   supplier_id:'',
                   fee1:0,
                   fee2:0,
                   fee1_date:'',
                   fee2_date:'',
                   description:'',
                   estimated_date:'',
                   description:'',
                   services:[],
                }),
         }
     },
     methods:{
         showSuplier(index){
            this.supp     = index === null ?   false : true
            this.supplier = index === null ?   {} : index
         }
     },
     async created(){
            try {
                let suppliers   = await axios.get("/supplierlist");
                this.suppliers  = suppliers.data

                let currencies  = await axios.get("/api/currencies");
                this.currencies = currencies.data
         
            } catch (error) {
                console.log(error);
            }
        }
    }
</script>

<style>

</style>