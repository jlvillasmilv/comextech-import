<template>
    <div class="row justify-content-around">
        <!-- Form Create -->

        <!-- <div v-else-if="!AddAccount" class="col-md-8" > -->
        <div class="col-md-7">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-md-6">
                    <h1 class="h4 text-primary mb-4">Cuentas Corrientes</h1>
                </div>
                <div class="col-md-3">
                    <a
                        class="btn btn-primary  btn-circle "
                        @click="showFormCreate"
                        ><i class="fas fa-plus fa-md"></i>
                    </a>
                </div>
            </div>
            <div class="table-responsive-md ">
                <table class="table ">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Numero de Cuenta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(accounts, index) in bank_accounts"
                            :key="index"
                        >
                            <th scope="row">
                                {{ index + 1 }}
                            </th>
                            <td>{{ getNameBanks(accounts.bank_id) }}</td>
                            <td>{{ accounts.number }}</td>
                            <td>
                                <a
                                    class="btn btn-danger  btn-circle "
                                    @click="deleteBankAccount(accounts.id)"
                                >
                                    <i class="fas fa-trash-alt fa-md"></i>
                                </a>
                                <a
                                    class="btn btn-info  btn-circle "
                                    @click="showFormEdit(accounts)"
                                >
                                    <i class="fas fa-pen fa-md"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form v-if="AddAccount || payload.number.length > 0" class=" col-md-5">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 text-primary mb-4">{{ title }}</h1>
                </div>
                <div>
                    <a
                        class="btn btn-info  btn-circle "
                        @click="AddBankAccount()"
                        ><i class="fas fa-pen fa-md"></i>
                    </a>
                    <a
                        class="btn btn-danger  btn-circle "
                        @click="showFormCreate"
                        ><i class="fas fa-times fa-md"></i>
                    </a>
                </div>
            </div>
            <div class="form-group">
                <label class="text-gray-500"> Bancos </label>
                <v-select
                    label="name"
                    v-model="payload.bank_id"
                    :options="banks"
                    :reduce="bank => bank.id"
                >
                    "></v-select
                >
            </div>
            <div class="form-group">
                <label class="text-gray-500"> Numero de Cuenta </label>
                <input
                    type="number"
                    v-model="payload.number"
                    class="form-control form-control-user"
                    id="address"
                />
            </div>
        </form>
    </div>
</template>

<script>
import Option from "../config/alert";

export default {
    data() {
        return {
            banks: [],
            bank_accounts: [],
            payload: { id: false, number: "", bank_id: 0 },
            AddAccount: false,
            selected: false,
            title: ""
        };
    },
    methods: {
        async fetchBanks() {
            let response = await axios.get("/api/banks/");
            this.banks = this.banks.concat(response.data);
        },
        async AddBankAccount() {
            if (this.payload.bank_id > 0 && this.payload.number > 1) {
                try {
                    let response = await axios.post(
                        "/api/clients/" + this.client.id + "/bankAccount",
                        this.payload
                    );
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
                this.bank_accounts.push(data);
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
            let response = await axios.get("/clients/" + this.user.id);
            this.bank_accounts = response.data.bank_accounts;
            this.client = response.data;
        }
    },
    async created() {
        this.fetchBanks();
        this.user = JSON.parse(
            document.head.querySelector('meta[name="user"]').content
        );
        this.getProfileClient();
    }
};
</script>
