<template>
  <div v-if="mode" class="grid relative lg:w-8/12 pr-1">
    <div class="flex flex-wrap justify-center">
      <div class="sm:px-2 flex w-10/12">
        <h2 class="text-blue-1300 text-xl font-medium mb-3">
          Representantes
        </h2>
      </div>
      <div class="w-2/12 sm:pl-4 justify-end">
        <a
          title="Agregar representante"
          class="text-white bg-blue-1300 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-blue-1200"
          @click="viewAddForm()"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
        </a>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <table class="w-full border-collapse text-gray-800 mb-4">
        <thead class="border-solid border-b-2 border-t-2">
          <tr class="text-center text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="p-3">RUT</th>
            <th class="p-3">Nombre</th>
            <th class="p-3">Direccion</th>
            <th class="p-3">Correo</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody v-if="partners.length > 0">
          <tr v-for="(item, index) in partners" :key="index" class="text-center text-gray-700 dark:text-gray-400">  
            <td class="px-2 py-1 text-sm">{{ item.rut }}</td>
            <td class="px-2 py-1 text-sm">{{ item.first_name }} {{ item.last_name }}</td>
            <td class="px-2 py-1 text-sm">{{ item.address }}</td>
            <td class="px-2 py-1 text-sm">{{ item.email }}</td>
            <td class="px-2 py-1 text-sm">
              <a
                class="text-white bg-red-500 border-red-500 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-red-600 mb-2"
                @click="deletePartners(item)"
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
                class="text-white bg-blue-500 border-blue-800 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-blue-700 "
                @click="viewEditForm(item)"
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
  <form v-else class="flex flex-col relative sm:w-full md:w-full lg:w-7/12 pr-3">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-blue-1300 text-xl font-medium mb-3">
          {{ title }}
        </h2>
      </div>
      <div>
        <a
          title="Guardar datos"
          class="text-white bg-blue-1300 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-blue-1200"
          @click="AddOrUpdatePartners()"
        >

            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-5 w-5"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                clip-rule="evenodd"
              />
            </svg>
        </a>
        <a
          title="Cancelar"
          class="text-white bg-red-500 border-red-500 rounded-lg h-9 w-9 inline-flex items-center justify-center hover:bg-red-600"
          @click="viewAddForm()"
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
        <input
          type="text"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="partnersAdd.rut"
        />
      </div>
    </div>
    <div class="flex flex-row flex-wrap mb-4 -mr-3.5 -ml-3.5">
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Nombre</label>
        <input
          type="text"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="partnersAdd.first_name"
        />
      </div>
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Apellido </label>
        <input
          type="text"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="partnersAdd.last_name"
        />
      </div>
    </div>
    <div class="flex flex-row flex-wrap mb-4 -mr-3.5 -ml-3.5">
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Email </label>
        <input
          type="email"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="partnersAdd.email"
        />
      </div>
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Direccion </label>
        <input
          type="text"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
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
        let response = await axios.delete('/factoring/partners/' + item.id);
        let array = this.partners.filter((items) => items.id !== item.id);
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
        this.partners.map((partner) =>
          partner.id === payload.partner.id ? payload.partner : partner
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
