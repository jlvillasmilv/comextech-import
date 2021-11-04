<template>
    <div>
        <div class="p-2 flex flex-wrap justify-around">
            <form class="relative w-full px-4">
                <div class="flex flex-warp mb-4 justify-between">
                    <div class="flex w-3/5">
                        <img
                            src="img/SII.png"
                            class="img-responsive"
                            alt="SII"
                            width="100"
                            height="25"
                        />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-gray-600"> Actualizar Contraseña </label>
                    <div
                        class="relative flex flex-wrap items-stretch w-full mb-2"
                    >
                        <div
                            class="input-group-prepend"
                            @click="passwordOldStatusIcon"
                        >
                            <div class="input-group-text">
                                <i
                                    :class="[
                                        showPasswordOld
                                            ? 'fas fa-eye fa-md'
                                            : 'fas fa-eye-slash fa-md'
                                    ]"
                                ></i>
                            </div>
                        </div>
                        <input
                            v-bind:type="inputOld"
                            class="form-control"
                            v-model="credentialSII.provider_password"
                        />
                        <div class="input-group-prepend">
                            <button
                                class="btn btn-primary btn-sm  "
                                @click="updatePassword"
                            >
                                <i class="fas fa-pen fa-lg"> </i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
                <h1 class="h6 text-gray-600 mb-4">
                    Certificado Digital (Opcional)
                </h1>

                <SingleFile
                    :action="`Adjuntar`"
                    :data="`certificado_sii`"
                ></SingleFile>
            </form>
        </div>
    </div>
</template>

<script>
import Option from '../config/alert';
import SingleFile from '../components/Factoring/SingleFile';
import DownloadFile from '../components/Factoring/DownloadFile';

export default {
    data() {
        return {
            title: 'cuentas Bancarias del Cliente',
            oldPassword: '',
            editing: false,
            showPasswordOld: false,
            inputOld: 'password',
            credentialSII: {},
            client: {}
        };
    },
    components: {
        SingleFile,
        DownloadFile
    },
    methods: {
        passwordOldStatusIcon() {
            this.showPasswordOld = !this.showPasswordOld;
            this.inputOld = this.showPasswordOld ? 'text' : 'password';
        },
        async updatePassword() {
            if (this.credentialSII.provider_password.length > 2) {
                let response = await axios.post(
                    '/clients/' + this.client.id + '/credential',
                    {
                        id: this.credentialSII.id,
                        providerName: 'SII',
                        password: this.credentialSII.provider_password
                    }
                );
                this.$emit('updatePassword');
                this.$swal.fire(Option('success', 'Actualizacion Exitosa!'));
                this.credentialSII.provider_password =
                    response.data.provider_password;
                this.credentialSII.id = response.data.id;
            }
        },
        async getCredential() {
            var provider_name = 'SII';
            let response = await axios.get('/credentials/' + provider_name);
            this.client = response.data.client;
            this.credentialSII = response.data.credential;
        }
    },
    async created() {
        this.getCredential();
    }
};
</script>
