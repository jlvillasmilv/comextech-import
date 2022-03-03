<template>
    <div class="grid relative lg:w-8/12 pr-1">
        <!-- Form Create -->

        <!-- <div v-else-if="!AddAccount" class="col-md-8" > -->
        <div class="col-md-7">
            <div class="d-flex justify-content-between align-items-center">
                <div class="sm:px-2 flex w-10/12">
                    <h2 class="text-blue-1300 text-xl font-medium mb-3">
                        Cuentas Corrientes
                    </h2>
                </div>
                <div class="col-md-3">
                    <a
                        class="text-white bg-blue-1300 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-blue-1200"
                        @click="showFormCreate"
                        > 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="block w-full overflow-x-auto">
                <table class="w-full border-collapse text-gray-800 mb-4">
                    <thead>
                         <tr class="text-center text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="p-3" scope="col">#</th>
                            <th class="p-3" scope="col">Banco</th>
                            <th class="p-3" scope="col">Numero de Cuenta</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center text-gray-700 dark:text-gray-400"
                            v-for="(accounts, index) in bank_accounts"
                            :key="index"
                        >
                            <th class="px-2 py-1 text-sm" scope="row">
                                {{ index + 1 }}
                            </th>
                            <td class="px-2 py-1 text-sm">{{ getNameBanks(accounts.bank_id) }}</td>
                            <td class="px-2 py-1 text-sm">{{ accounts.number }}</td>
                            <td class="px-2 py-1 text-sm">
                                <a
                                    class="text-white bg-red-500 border-red-500 rounded-lg h-8 w-8 inline-flex items-center justify-center hover:bg-red-600 mb-2"
                                    @click="deleteBankAccount(accounts.id)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                        fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                                <a
                                    class="text-white bg-blue-500 border-blue-800 rounded-lg h-8 w-8 inline-flex items-center justify-center hover:bg-blue-700 "
                                    @click="showFormEdit(accounts)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                                        />
                                        <path
                                        fill-rule="evenodd"
                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                        clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form v-if="AddAccount || payload.number.length > 0" class=" col-md-5">
           <div class="flex items-center justify-between">
                <div>
                     <h2 class="text-blue-1300 text-xl font-medium mb-3">{{ title }}</h2>
                </div>
                <div>
                    <a
                    title="Guardar datos"
                    class="text-white bg-blue-1300 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-blue-1200"
                     @click="AddBankAccount()"
                    > 

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                        
                    </a>
                    <a
                        title="Cancelar"
                        class="text-white bg-red-500 border-red-500 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-red-600"
                         @click="showFormCreate"
                        >
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                            </svg>
                        </a>
                    
                </div>
            </div>
               <div class="flex flex-row flex-wrap mb-4 -mr-3.5 -ml-3.5">
                    <div class="flex flex-col relative w-full px-3.5">
                       <label class="text-gray-500 mb-2"> RUT </label>
                       <v-select
                        label="name"
                        v-model="payload.bank_id"
                        :options="banks"
                        :reduce="bank => bank.id"
                    />
                    </div>
                </div>

                 <div class="flex flex-row flex-wrap mb-4 -mr-3.5 -ml-3.5">
                    <div class="flex flex-col relative w-full px-3.5">
                        <label class="text-gray-500 mb-2"> Numero de Cuenta </label>
                       <input
                            type="text"
                            v-model="payload.number"
                             class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="number"
                        />
                    </div>
                </div>
        </form>
    </div>
</template>

<script>
import Option from '../config/alert';

export default {
    data() {
        return {
            banks: [],
            bank_accounts: [],
            payload: { id: false, number: "", bank_id: 0, status: true },
            AddAccount: false,
            selected: false,
            title: ""
        };
    },
    methods: {
        async fetchBanks() {
            let response = await axios.get("/api/banks/");
            this.banks = response.data;
        },
        async AddBankAccount() {
           
            if (this.payload.bank_id > 0 && this.payload.number.length > 1) {
                try {
                    let response = await axios.post("/bank-accounts",this.payload);
                    this.formAction(response.data);
                } catch (error) {
                    var message = error.response.data.errors.number
                        ? "El numero de cuenta ya se encuentra en uso!"
                        : "Ah ocurrido un error!";
                    this.$swal.fire(Option("warning", message));
                }
                } else {
                    var message =
                        this.payload.number < 1
                            ? "Ingrese Numero de Cuenta"
                            : "Seleccione Banco";
                    this.$swal.fire(Option("warning", message));
                }
        },
        async deleteBankAccount(id) {
            try {
                let response = await axios.delete("/api/bankAccount/" + id);
                this.$swal.fire(Option("success", "Eliminacion Exitosa!"));
                let array = this.bank_accounts.filter(item => item.id !== id);
                this.bank_accounts = array;
            } catch (error) {
                this.$swal.fire(Option("error", error.response.data.error));
            }
        },
        formAction(data) {
            if (!this.payload.id) {
                // this.bank_accounts.push(data);
                this.getProfileClient();
                this.$swal.fire(Option("success", "Se registro con Exito!"));
            } else {
                this.bank_accounts.map(account =>
                    account.id === this.payload.id ? this.payload : account
                );
                this.$swal.fire(Option("success", "Se Actualizo con Exito!"));
            }
            this.showFormCreate();
        },
        showFormCreate() {
            this.payload = { id: false, number: "", bank_id: 0 };
            this.AddAccount = !this.AddAccount;
            this.title = "Añadir cuenta corriente";
        },
        showFormEdit(data) {
            this.title = "Editar cuenta corriente";
            this.AddAccount = !this.AddAccount;
            this.payload = data;
        },
        getNameBanks(bankId) {
            if (this.banks && this.bank_accounts) {
                let objectName = this.banks.find(item => item.id == bankId);
                if (objectName) {
                    return objectName.name;
                }
            }
        },
        async getProfileClient() {
           
            let response = await axios.get("/bank-accounts/");
            this.bank_accounts = response.data;
            // this.client = response.data;
        }
    },
    async created() {
        this.fetchBanks();
        this.getProfileClient();
    }
};
</script>
