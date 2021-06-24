<template>
    <div class="w-1/2 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:text-gray-200 dark:bg-gray-800">
    <!-- <v-select label="name" v-model="payload.bank_id" :options="banks" :reduce="bank => bank.id" > "></v-select> -->
        <div class="dark:text-gray-200">   
            <h3 class="my-4  text-gray-500 ">
                    Proveedor de Mercancia
            </h3>
            <v-select label="name" @input="showSuplier"  placeholder="Seleccionar Proveedor" :options="suppliers" > ">
                <template  v-slot:no-options="{ search, searching }" >
                    <template v-if="searching" class="text-sm">
                    Lo sentimos no hay opciones que coincidan <strong>{{ search }}</strong>.
                </template>
                <em style="opacity: 0.5;" v-else> No posee proveedores en tu lista</em>
                    </template>
            </v-select>
        </div>
        <div v-if="supp" class="mt-15 text-center dark:text-gray-200  ">
                <h1 class="my-1 font-semibold text-blue-500  text-4xl "> {{ supplier.name }} </h1>
                <h1 class="my-3 text-gray-750 dark:text-gray-200 text-2xl  ">   {{ supplier.address }} </h1>
                <h1 class="my-3 text-gray-750 dark:text-gray-200 text-2xl  ">   {{ supplier.bank }} </h1>
                <h1 class="my-3 text-gray-750 dark:text-gray-200 text-2xl  ">  Nro  {{ supplier.account }} </h1>
                <h1 class="my-3 text-gray-750 dark:text-gray-200 text-2xl  ">   DNI {{ supplier.DNI }} </h1>
        </div> 
    </div>
</template>

<script>
export default {
     data(){
         return{
             supplier:{},
             supp:false,
             suppliers:[
                {
                 name:"Harina Pana",
                 address:"Venezuela, San Cristobal",
                 bank: "Banco Mercantil",
                 account:"426384843",
                 DNI:"27234322-3"
                },
                {
                 name:"Alimento Polar",
                 address:"Venezuela, San Cristobal",
                 bank: "Banco Mercantil",
                 account:"426384843",
                 DNI:"27234322-3"
                },
                {
                 name:"Motores Pekin",
                 address:"Venezuela, San Cristobal",
                 bank: "Banco Mercantil",
                 account:"426384843",
                 DNI:"27234322-3"
                },
                {
                 name:"Autopartes Colombia",
                 address:"Venezuela, San Cristobal",
                 bank: "Banco Mercantil",
                 account:"426384843",
                 DNI:"27234322-3"
                },
             ]
         }
     },
     methods:{
         showSuplier(index){
            this.supp     = index === null ?   false : true
            this.supplier = index === null ?   {} : index
         }
     }
}
</script>

<style>

</style>