<template>
    <div>
        <div class="p-2 flex flex-wrap justify-around">
            <form class="relative w-full px-4">
                <div class="flex flex-warp mb-4 justify-between">
                    <div class="flex w-3/5">
                        <img
                            src="/img/SII.png"
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
                        class="relative flex flex-wrap justify-around items-stretch w-full mb-2"
                    >
                        <div @click="passwordOldStatusIcon">
                            <div
                                class="invisible sm:visible flex whitespace-nowrap h-10 items-center px-3 py-1.5 text-base text-center font-normal text-gray-400 bg-gray-200 border-transparent"
                            >
                                <i>
                                    <svg
                                        v-if="showPasswordOld"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                        />
                                        <path
                                            fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <svg
                                        v-if="!showPasswordOld"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                            clip-rule="evenodd"
                                        />
                                        <path
                                            d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"
                                        />
                                    </svg>
                                </i>
                            </div>
                        </div>
                        <input
                            v-bind:type="inputOld"
                            class="relative flex flex-grow flex-shrink px-3 py-1.5 text-base text-gray-600 bg-white border-2 border-solid border-gray-300 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue"
                            v-model="credentialSII.provider_password"
                        />
                        <div class="flex">
                            <button
                                class="relative font-normal text-center whitespace-nowrap align-middle select-none border-0 border-transparent px-2 py-1 text-sm text-white bg-blue-800 focus:border-blue-400 focus:shadow-outline-blue focus:outline-none hover:bg-blue-900"
                                @click="updatePassword"
                            >
                                <i>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="inline-block h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                        />
                                    </svg>
                                </i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
                <h1 class="font-medium text-gray-600 mb-4">
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
                    '/factoring/clients/' + this.client.id + '/credential',
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
            let response = await axios.get(
                '/factoring/credentials/' + provider_name
            );
            this.client = response.data.client;
            this.credentialSII = response.data.credential;
        }
    },
    async created() {
        this.getCredential();
    }
};
</script>
