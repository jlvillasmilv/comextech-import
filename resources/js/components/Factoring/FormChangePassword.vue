<template>
    <div class="border mt-3 mb-2 p-2">
        <div class="d-flex justify-content-between align-items-center  mb-4">
            <div class="h4 col col-sm-8 text-primary">Contraseña</div>
            <div class="col col-sm-4 ">
                <button
                    type="button"
                    @click="changeStatusPassword()"
                    :class="[
                        'btn btn-sm',
                        EditingPassword ? 'btn-primary ' : 'btn-outline-primary'
                    ]"
                >
                    <i class="fas fa-pen fa-lg"></i>
                    {{ EditingPassword ? "Guardar" : "Editar" }}
                </button>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label class="text-gray-500"> Nueva Contraseña </label>
                <input
                    type="password"
                    class="form-control form-control-user"
                    v-model="password"
                    v-bind:disabled="!EditingPassword"
                />
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label class="text-gray-500"> Confirme Contraseña </label>
                <input
                    type="password"
                    class="form-control form-control-user"
                    v-model="password_validated"
                    v-bind:disabled="!EditingPassword"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Option from "../config/alert";

export default {
    data() {
        return {
            EditingPassword: false,
            password_validated: "",
            password: ""
        };
    },
    methods: {
        changeStatusPassword() {
            this.EditingPassword = !this.EditingPassword;
            if (!this.EditingPassword) {
                this.modifyPassword();
            }
        },
        async modifyPassword() {
            if (
                this.password_validated === this.password &&
                this.password.length > 0
            ) {
                this.EditingPassword = true;
                let response = axios.post("client/password", {
                    password: this.password
                });
                this.password_validated = "";
                this.password = "";

                this.$swal.fire(Option("success", "Actualizacion Exitosa!"));
            } else {
                var message =
                    this.password.length > 0
                        ? "Contraseña no coinciden!"
                        : "Ingrese una contraseña";
                this.EditingPassword = true;
                this.$swal.fire(Option("error", message));
            }
        }
    }
};
</script>

<style></style>
