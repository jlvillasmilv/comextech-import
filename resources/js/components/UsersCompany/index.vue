<template>
  <div v-if="mode" class="w-full">
    <div class="flex flex-wrap justify-center">
      <div class="sm:px-2 flex w-10/12">
        <h2 class="text-blue-1300 text-xl font-medium mb-3">
          Usuarios
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
            <th class="p-3">Nombre</th>
            <th class="p-3">Correo</th>
            <th class="p-3">Perfil</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody v-if="users.length > 0">
          <tr v-for="(item, index) in users" :key="index" class="text-center text-gray-700 dark:text-gray-400">  
            <td class="px-2 py-1 text-sm">{{ item.name }}</td>
            <td class="px-2 py-1 text-sm">{{ item.email }}</td>
            <td class="px-2 py-1 text-sm"> <p v-for="rol in item.roles" :key="rol.name">{{rol.name}}</p> </td>
            <td class="px-2 py-1 text-sm">
            
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
          @click="AddOrUpdateUser()"
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
        <label class="text-gray-500 mb-2"> Nombre </label>
        <input
          type="text"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="userCompany.name"
        />
      </div>
    </div>
   
    <div class="flex flex-row flex-wrap mb-4 -mr-3.5 -ml-3.5">
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Correo Electronico </label>
        <input
          type="email"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="userCompany.email"
        />
      </div>
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Telefono </label>
        <input
          type="text"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="userCompany.phone"
        />
      </div>
    </div>

     <div class="flex flex-row flex-wrap mb-4 -mr-3.5 -ml-3.5">
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Contraseña </label>
        <input
          type="password"
          class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
          v-model="userCompany.password"
        />
      </div>
      <div class="flex flex-col relative sm:w-full md:w-full lg:w-6/12 px-3.5">
        <label class="text-gray-500 mb-2"> Perfil </label>
        <select id="roles-select" v-model="userCompany.role_id">
          <option value="2">Cliente Admin</option>
          <option value="3">Cliente Operador</option>
        </select>
      </div>
    </div>
  </form>
</template>

<script>
import Option from '../../config/alert';
import Form from 'vform';

export default {
  data() {
    return {
      users: [],
      company: [],
      userCompany: new Form({
        id: 0,
        name: '',
        email: '',
        password: '',
        role_id:3
      }),
      mode: true,
      title: ''
    };
  },
  methods: {
    async getUsers() {
      let response = await axios.get('/users-company');
      this.users = response.data;
    },
    async AddOrUpdateUser() {
      try {
       
        let response = this.userCompany.id == 0 
        ? await axios.post('/users-company', this.userCompany)
        : await this.userCompany.put(`/users-company/${this.userCompany.id}`)
       
       this.typeAction(response.data);
      } catch (error) {
        let data = error.response.data.errors;
        let message =
          data.email || data.name
            ? data.email
              ? data.email
              : data.name
            : 'Error, todos los campos son requeridos!';
        this.$swal.fire(Option('error', message));
      }
    },
    viewEditForm(item) {
       this.title = 'Editar usuario';
       this.userCompany.id = item.id
       this.userCompany.name = item.name
       this.userCompany.email = item.email
       this.userCompany.phone = item.phone
       item.roles.map((rol) =>
         this.userCompany.role_id = rol.id
        );
      this.mode = !this.mode;
    },
    typeAction(payload) {
      this.getUsers();
      this.mode = true;
      this.userCompany = {
        id: false,
        name: '',
        email: '',
        password: '',
        phone: ''
      };
      this.$swal.fire(Option('success', 'Se registro con Exito!'));
    },
    viewAddForm() {
      this.title = 'Registrar nuevo usuario';
      this.userCompany = {
        id: 0,
        name: '',
        email: '',
        password: '',
        phone: ''
      };
      this.mode = !this.mode;
    }
  },
  async created() {
    this.getUsers();
  }
};
</script>

<style></style>
