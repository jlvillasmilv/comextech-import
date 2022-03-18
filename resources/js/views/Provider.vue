<template>
  <div>
    <div class="p-2 flex flex-wrap justify-around w-full">
      <form class="relative sm:w-full sm:w-6/12 md:w-6/12 px-4">
        <div class="flex flex-warp mb-4 justify-center">
          <div class="flex justify-center w-full">
            <img src="/img/SII.png" alt="SII" width="100" height="25" />
          </div>
        </div>

        <div class="flex flex-col justify-center mb-4">
          <label class="flex justify-center text-gray-600"> Actualizar Contraseña </label>
          <div class="relative flex flex-wrap justify-around items-stretch w-full mb-2">
            <div @click="passwordOldStatusIcon">
              <div
                class="
                  rounded-l-lg
                  invisible
                  md:visible
                  flex
                  whitespace-nowrap
                  h-10
                  items-center
                  px-3
                  py-1.5
                  text-base text-center
                  font-normal
                  text-gray-400
                  bg-gray-200
                  border-transparent
                "
              >
                <svg
                  v-if="showPasswordOld"
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
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
              </div>
            </div>
            <input
              v-bind:type="inputOld"
              class="
                relative
                flex flex-grow flex-shrink
                rounded-r-lg
                px-3
                py-1.5
                text-base text-gray-600
                bg-white
                border-2 border-solid border-gray-300
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
              "
              v-model="credentialSII.provider_password"
            />
            <div class="flex mt-1">
              <button
                type="button"
                class="
                  flex
                  px-4
                  py-2
                  mb-2
                  text-sm
                  font-medium
                  leading-5
                  text-white
                  transition-colors
                  duration-150
                  bg-blue-1300
                  border border-transparent
                  rounded-lg
                  hover:bg-blue-1200
                  focus:outline-none focus:shadow-outline-blue
                "
                @click="updatePassword"
              >
                Guardar
              </button>
            </div>
          </div>
        </div>
        <!-- <h1 class="flex justify-center font-medium text-gray-600 mb-4">
          Certificado Digital (Opcional)
        </h1>

       <SingleFile :action="`Adjuntar`" :data="`certificado_sii`"></SingleFile> -->
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
      client: {},
    };
  },
  components: {
    SingleFile,
    DownloadFile,
  },
  methods: {
    passwordOldStatusIcon() {
      this.showPasswordOld = !this.showPasswordOld;
      this.inputOld = this.showPasswordOld ? 'text' : 'password';
    },
    async updatePassword() {
      if (this.credentialSII.provider_password.length > 2) {
        let response = await axios.post('/factoring/clients/credential', {
          providerName: 'SII',
          password: this.credentialSII.provider_password,
        });

        this.$emit('updatePassword');
        this.$swal.fire(Option('success', 'Actualizacion Exitosa!'));
        this.credentialSII.provider_password = atob(response.data.provider_password);
        this.credentialSII.id = response.data.id;
      }
    },
    async getCredential() {
      var provider_name = 'SII';
      let response = await axios.get('/factoring/clients/credential');
      this.client = response.data.client;
      this.credentialSII = response.data.credential;
    },
  },
  async created() {
    this.getCredential();
  },
};
</script>
