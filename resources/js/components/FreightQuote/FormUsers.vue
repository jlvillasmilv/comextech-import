<template>
  <div class="flex flex-col items-center justify-center w-full mt-10">
    <h1 class="text-xl font-semibold mb-4">Formulario de cotizacion</h1>
    <form action="" class="w-6/12 flex flex-col mb-6">
      <AlertError :form="expenses" message="Complete los campos solicitados" />
      <label class="flex flex-col mb-3"
        >Nombre
        <input v-model="expenses.client.name" class="form-input" type="text" placeholder="Nombre" />
        <span
          class="text-xs text-red-400 dark:text-red-400"
          v-if="expenses.errors.has('client.name')"
          v-html="expenses.errors.get('client.name')"
        ></span>
      </label>
      <label class="flex flex-col mb-3"
        >Correo
        <input
          v-model="expenses.client.email"
          class="form-input"
          type="email"
          placeholder="Correo"
        />
        <span
          class="text-xs text-red-400 dark:text-red-400"
          v-if="expenses.errors.has('client.email')"
          v-html="expenses.errors.get('client.email')"
        ></span>
      </label>
      <label for="" class="flex flex-col mb-3"
        >Telefono
        <input
          v-model="expenses.client.phone_number"
          class="form-input"
          type="text"
          :maxlength="15"
          placeholder="Telefono"
        />
      </label>
    </form>
    <button
      @click="saveForm()"
      :class="[
        !expenses.dataLoad
          ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
          : expenses.dataLoad.length <= 0
          ? 'flex items-center justify-center vld-parent sm:w-44 h-12 px-4 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
          : 'flex items-center justify-center ml-4 w-32 h-12 text-white transition-colors text-lg bg-blue-1300 rounded-lg focus:shadow-outline hover:bg-blue-1200 active:bg-blue-1300'
      ]"
      :disabled="busy"
    >
      <svg
        v-if="busy"
        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
      Cotizar
    </button>
  </div>
</template>

<script>
import { AlertError } from 'vform/src/components/tailwind';
import { mapMutations, mapState } from 'vuex';

export default {
  components: { AlertError },
  data() {
    return {};
  },
  methods: {
    ...mapMutations('application', ['BUSY_BUTTON']),
    ...mapMutations('freightQuotes', ['SHOW_ADDRESS']),
    ...mapMutations('load', ['SHOW_LOAD_CHARGE']),

    async saveForm() {
      this.BUSY_BUTTON(true);
      try {
        const response = await this.expenses.post('/freight-quotes');

        if (response.status == 200) {
          Swal.fire({
            title: 'Comextech le enviará un correo para contactarlo',
            // text: '¿Quiere solicitar una tarifa para su operación al Equipo ComexTech?',
            icon: 'warning',
            // showCancelButton: true,
            confirmButtonColor: '#142c44',
            // cancelButtonColor: '#d33',
            // cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aceptar'
          });

          setTimeout(() => {
            window.location.href = '/freight-quotes';
          }, 2000);
        }
      } catch (error) {
        console.error(error);
      } finally {
        this.BUSY_BUTTON(false);
      }
    }
  },
  computed: {
    ...mapState('freightQuotes', ['expenses']),
    ...mapState('application', ['busy'])
  }
};
</script>
