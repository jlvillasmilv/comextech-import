<template>
    <div>
        <form class="border p-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="h4 col col-sm-8 text-primary ">
                    Informacion Personal
                </div>
                <div class="col col-sm-4 ">
                    <button
                        type="button"
                        @click="changeStatuEditing()"
                        :class="[
                            'btn btn-sm',
                            EditingClient
                                ? 'btn-primary'
                                : 'btn-outline-primary'
                        ]"
                    >
                        <i class="fas fa-pen fa-lg"></i>
                        {{ EditingClient ? "Guardar" : "Editar" }}
                    </button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-">
                    <label class="text-gray-500"> Nombre </label>
                    <input
                        type="text"
                        class="form-control form-control-user"
                        v-model="client.first_name"
                        v-bind:disabled="!EditingClient"
                    />
                </div>
                <div class="col-sm-6">
                    <label class="text-gray-500"> Apellido </label>
                    <input
                        type="text"
                        class="form-control form-control-user"
                        v-model="client.last_name"
                        v-bind:disabled="!EditingClient"
                    />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label class="text-gray-500"> RUT </label>
                    <input
                        type="text"
                        placeholder="Ingresa tu RUT con digito verificador"
                        v-mask="'##.###.###-NN'"
                        class="form-control form-control-user"
                        v-model="client.rut"
                        v-bind:disabled="!EditingClient"
                    />
                </div>
                <div class="col-sm-6">
                    <label class="text-gray-500"> Telefono</label>
                    <input
                        type="text"
                        class="form-control form-control-user"
                        v-model="client.phone"
                        v-bind:disabled="!EditingClient"
                    />
                </div>
            </div>
            <div class="form-group">
                <label class="text-gray-500"> Direccion</label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    v-model="client.address"
                    v-bind:disabled="!EditingClient"
                />
            </div>
        </form>
        <FormChangePassword></FormChangePassword>
    </div>
</template>
<script>
import Option from "../config/alert";
import FormChangePassword from "./FormChangePassword";

export default {
    data() {
        return {
            EditingClient: false
        };
    },
    components: {
        FormChangePassword: FormChangePassword
    },
    props: {
        client: {
            type: Object
        }
    },
    methods: {
        changeStatuEditing() {
            this.EditingClient = !this.EditingClient;

            if (!this.EditingClient) {
                this.modifyClient();
            }
        },

        async modifyClient() {
            try {
                let response = await axios.put(
                    "api/clients/" + this.client.id,
                    {
                        id: this.client.id,
                        rut: this.client.rut,
                        phone: this.client.phone,
                        first_name: this.client.first_name,
                        last_name: this.client.last_name,
                        address: this.client.address
                    }
                );
                this.$swal.fire(Option("success", "Actualizacion Exitosa!"));
            } catch (error) {
                this.EditingClient = true;
                let data = error.response.data.errors;
                let message =
                    data.email || data.rut
                        ? data.email
                            ? data.email
                            : data.rut
                        : "Error, todos los campos son requeridos!";
                this.$swal.fire(Option("error", message));
            }
        }
    },
    computed: {
        // ...mapState(['user','client'])
    }
};
</script>

<style>
input[type="text"]:disabled {
    background: white;
    border: none;
}
input[type="password"]:disabled {
    background: white;
    border: none;
}
input[type="number"]:disabled {
    background: white;
    border: none;
}
</style>
