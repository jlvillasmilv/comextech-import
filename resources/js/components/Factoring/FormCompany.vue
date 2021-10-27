<template>
    <form class="border p-3 ">
        <div class="d-flex  justify-content-between align-items-center">
            <div class="h4 col col-sm-8 text-primary mb-4">Empresa</div>
            <div class="col col-sm-12">
                <button
                    type="button"
                    @click="changeStatuEditing()"
                    :class="[
                        'btn btn-sm',
                        EditingCompany ? 'btn-primary' : 'btn-outline-primary'
                    ]"
                >
                    <i class="fas fa-pen fa-lg"></i>
                    {{
                        EditingCompany && EditingCompany !== "preparing"
                            ? "Guardar"
                            : "Editar"
                    }}
                </button>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label class="text-gray-500"> Nombre de la Empresa </label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    id="name"
                    v-model="company.name"
                    v-bind:disabled="!EditingCompany"
                />
            </div>
            <div class="col-sm-6">
                <label class="text-gray-500"> RUT </label>
                <input
                    type="text"
                    placeholder="RUT empresarial con digito verificador"
                    v-mask="'##.###.###-NN'"
                    class="form-control form-control-user"
                    id="rut"
                    v-model="company.rut"
                    v-bind:disabled="!EditingCompany"
                />
            </div>
        </div>
        <div class="form-group">
            <label class="text-gray-500"> Direccion </label>
            <input
                type="text"
                class="form-control form-control-user"
                id="address"
                v-model="company.address"
                v-bind:disabled="!EditingCompany"
            />
        </div>
    </form>
</template>

<script>
import Option from "../config/alert";

export default {
    data() {
        return {
            EditingCompany: false,
            buttonName: "Editar",
            error: ["1"]
        };
    },
    props: {
        company: {
            type: Object
        }
    },
    methods: {
        changeStatuEditing() {
            this.EditingCompany = !this.EditingCompany;
            if (!this.EditingCompany) {
                this.modifyCompany();
            }
        },
        async modifyCompany() {
            try {
                await axios.put("api/company/" + this.company.id, {
                    id: this.company.id,
                    name: this.company.name,
                    rut: this.company.rut,
                    address: this.company.address
                });
                this.$swal.fire(Option("success", "Actualizacion Exitosa!"));
            } catch (error) {
                this.EditingCompany = true;
                let data = error.response.data.errors;
                let message = data.rut
                    ? data.rut
                    : "Error, todos los campos son requeridos!";
                this.$swal.fire(Option("error", message));
            }
        }
    }
};
</script>

<style scoped>
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
