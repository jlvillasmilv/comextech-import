<template>
    <div v-if="mode" class="col-lg-8">
        <div class="row justify-content-center">
            <div class="col-10">
                <h1 class="h4 text-primary mb-4">Representantes</h1>
            </div>
            <div class="col-2">
                <a class="btn btn-primary  btn-circle " @click="viewAddForm()">
                    <i class="fas fa-plus fa-md"> </i>
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">RUT</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">Correo Electronico</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="partners.length > 0">
                    <tr v-for="(item, index) in partners" :key="index">
                        <td>{{ item.rut }}</td>
                        <td>{{ item.first_name }} {{ item.last_name }}</td>
                        <td>{{ item.address }}</td>
                        <td>{{ item.email }}</td>
                        <td>
                            <a
                                class="btn btn-danger  btn-circle "
                                @click="deletePartners(item)"
                            >
                                <i class="fas fa-trash-alt fa-md"> </i>
                            </a>
                            <a
                                class="btn btn-info  btn-circle "
                                @click="viewEditForm(item)"
                            >
                                <i class="fas fa-pen fa-md"> </i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form v-else class="user col-lg-6 col-md-12 ">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h4 text-primary mb-4">{{ title }}</h1>
            </div>
            <div>
                <a
                    class="btn btn-info  btn-circle "
                    @click="AddOrUpdatePartners()"
                >
                    <i class="fas fa-plus fa-md"> </i>
                </a>
                <a class="btn btn-danger  btn-circle " @click="viewAddForm()">
                    <i class="fas fa-times fa-md"> </i>
                </a>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label class="text-gray-500"> RUT </label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    v-model="partnersAdd.rut"
                />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label class="text-gray-500"> Nombre</label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    v-model="partnersAdd.first_name"
                />
            </div>
            <div class="col-sm-6">
                <label class="text-gray-500"> Apellido </label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    v-model="partnersAdd.last_name"
                />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label class="text-gray-500"> Email </label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    v-model="partnersAdd.email"
                />
            </div>
            <div class="col-sm-6">
                <label class="text-gray-500"> Direccion </label>
                <input
                    type="text"
                    class="form-control form-control-user"
                    v-model="partnersAdd.address"
                />
            </div>
        </div>
    </form>
</template>

<script>
import Option from "../config/alert";
export default {
    data() {
        return {
            partners: [],
            company: [],
            partnersAdd: {
                id: false,
                first_name: "",
                last_name: "",
                rut: "",
                address: "",
                email: ""
            },
            mode: true,
            title: ""
        };
    },
    methods: {
        async getPartners() {
            let response = await axios.get("partners");
            this.partners = response.data.partners;
            this.company = response.data;
        },
        async AddOrUpdatePartners() {
            try {
                let payload = Object.assign(this.partnersAdd, {
                    company_id: this.company.id
                });
                let response = await axios.post("partners", payload);
                this.typeAction(response.data);
            } catch (error) {
                let data = error.response.data.errors;
                let message =
                    data.email || data.rut
                        ? data.email
                            ? data.email
                            : data.rut
                        : "Error, todos los campos son requeridos!";
                this.$swal.fire(Option("error", message));
            }
        },
        async deletePartners(item) {
            try {
                let response = await axios.delete("partners/" + item.id);
                let array = this.partners.filter(items => items.id !== item.id);
                this.partners = array;
                this.$swal.fire(Option("success", "Elimado con Exito!"));
            } catch (error) {
                this.$swal.fire(Option("error", error.response.data.message));
            }
        },
        viewEditForm(item) {
            this.title = "Editar representante";
            this.partnersAdd = item;
            this.mode = !this.mode;
        },
        typeAction(payload) {
            if (!payload.id) {
                this.partners.push(payload.partner);
            } else {
                this.partners.map(partner =>
                    partner.id === payload.partner.id
                        ? payload.partner
                        : partner
                );
            }
            this.mode = true;
            this.partnersAdd = {
                id: false,
                first_name: "",
                last_name: "",
                rut: "",
                address: "",
                email: ""
            };
            this.$swal.fire(Option("success", "Se registro con Exito!"));
        },
        viewAddForm() {
            this.title = "Añadir nuevo representante";
            this.partnersAdd = {
                id: false,
                first_name: "",
                last_name: "",
                rut: "",
                address: "",
                email: ""
            };
            this.mode = !this.mode;
        }
    },
    async created() {
        this.getPartners();
    }
};
</script>

<style></style>
