<template>
    <div v-if="mode" class="grid mb-8 relative sm:w-8/12 px-4">
        <div class="flex flex-wrap justify-center">
            <div class="relative px-4 flex flex-grow-0 flex-shrink-0 w-10/12">
                <h1 class="text-blue-800 text-xl font-medium mb-4">
                    Representantes
                </h1>
            </div>
            <div class="relative flex w-2/12 px-4">
                <a
                    class="text-white bg-blue-800 border-blue-800 rounded-full h-10 w-10 inline-flex items-center justify-center hover:bg-blue-900"
                    @click="viewAddForm()"
                >
                    <i class="fas fa-plus fa-md"> </i>
                </a>
            </div>
        </div>
        <div class="block w-full overflow-x-auto">
            <table class="w-full border-collapse text-gray-800 mb-4">
                <thead class="border-solid border-b-2 border-t-2">
                    <tr class="text-left">
                        <th class="p-3">RUT</th>
                        <th class="p-3">Nombre Completo</th>
                        <th class="p-3">Direccion</th>
                        <th class="p-3">Correo Electronico</th>
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
import Option from '../../config/alert';
export default {
    data() {
        return {
            partners: [],
            company: [],
            partnersAdd: {
                id: false,
                first_name: '',
                last_name: '',
                rut: '',
                address: '',
                email: ''
            },
            mode: true,
            title: ''
        };
    },
    methods: {
        async getPartners() {
            let response = await axios.get('/factoring/partners');
            this.partners = response.data.partners;
            this.company = response.data;
        },
        async AddOrUpdatePartners() {
            try {
                let payload = Object.assign(this.partnersAdd, {
                    company_id: this.company.id
                });
                let response = await axios.post('/factoring/partners', payload);
                this.typeAction(response.data);
            } catch (error) {
                let data = error.response.data.errors;
                let message =
                    data.email || data.rut
                        ? data.email
                            ? data.email
                            : data.rut
                        : 'Error, todos los campos son requeridos!';
                this.$swal.fire(Option('error', message));
            }
        },
        async deletePartners(item) {
            try {
                let response = await axios.delete(
                    '/factoring/partners/' + item.id
                );
                let array = this.partners.filter(items => items.id !== item.id);
                this.partners = array;
                this.$swal.fire(Option('success', 'Elimado con Exito!'));
            } catch (error) {
                this.$swal.fire(Option('error', error.response.data.message));
            }
        },
        viewEditForm(item) {
            this.title = 'Editar representante';
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
                first_name: '',
                last_name: '',
                rut: '',
                address: '',
                email: ''
            };
            this.$swal.fire(Option('success', 'Se registro con Exito!'));
        },
        viewAddForm() {
            this.title = 'Añadir nuevo representante';
            this.partnersAdd = {
                id: false,
                first_name: '',
                last_name: '',
                rut: '',
                address: '',
                email: ''
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
