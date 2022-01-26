<template>
  <div>
    <div>
      <h1 class="text-2xl text-blue-900">
        {{ title }}
      </h1>
    </div>

    <div v-if="data.type_transport">
      <div
        v-for="(item, id) in loads"
        :key="id"
        class="my-4 sm:mt-8 flex flex-col sm:flex-row sm:justify-center items-top dark:text-gray-400 sm:space-x-5"
      >
        <!-- tipo de carga -->
        <div
          v-if="data.type_transport != 'CONTAINER'"
          class="my-2 flex justify-center md:inline md:w-24"
        >
          <div>
            <label v-if="id == 0" class="text-sm font-semibold"> Tipo de Carga </label>
            <div class="flex justify-center">
              <select
                v-model="item.category_load_id"
                value="Seleccionar"
                class="
                block
                text-sm
                w-auto
                bg-white
                border border-gray-200
                text-gray-700
                py-2
                px-2
                pr-8
                rounded
                leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500
                dark:text-gray-300
                dark:border-gray-600
                dark:bg-gray-700
                dark:focus:shadow-outline-gray
                form-select
              "
              >
                <option value="1" selected>Caja / s</option>
                <option value="2">Pallet / s</option>
                <option value="3">Unidad/es</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Tipo container -->
        <div class="my-2 flex justify-center w-full sm:inline" v-else>
          <div class="relative">
            <label v-if="id == 0" class="block text-sm font-semibold"> Tipo de Container </label>
            <select
              v-model="item.type_container"
              class="
                block
                text-sm
                w-2/3
                bg-white
                border border-gray-200
                text-gray-700
                py-2
                px-2
                pr-8
                rounded
                leading-tight
                focus:outline-none focus:bg-white focus:border-gray-500
                dark:text-gray-300
                dark:border-gray-600
                dark:bg-gray-700
                dark:focus:shadow-outline-gray
                form-select
              "
            >
              <option value="1">20'DV</option>
              <option value="2">40'DV</option>
              <option value="3">40'HC</option>
              <option value="4">40'NOR</option>
              <option value="5">45'HC</option>
            </select>
          </div>
        </div>

        <!-- dimensiones unitarias -->
        <div class="my-2 flex justify-center sm:inline md:inline text-center">
          <div v-if="data.type_transport != 'CONTAINER'">
            <span v-if="id == 0" class="text-sm font-semibold">
              Dimension Unitaria
            </span>
            <div class="flex">
              <input
                v-model.number="item.length"
                type="number"
                class="
                  h-9
                  w-13
                  focus:outline-none
                  border
                  rounded-l-lg
                  flex
                  items-center
                  text-center text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                "
                placeholder="L"
              />
              <input
                v-model.number="item.width"
                type="number"
                class="
                  h-9
                  w-13
                  focus:outline-none
                  border
                  rounded-none
                  flex
                  items-center
                  text-center text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                "
                placeholder="W"
              />
              <input
                v-model.number="item.height"
                type="number"
                class="
                  h-9
                  w-13
                  focus:outline-none
                  border
                  rounded-r-lg
                  flex
                  items-center
                  text-center text-sm
                  dark:border-gray-600
                  dark:bg-gray-700
                  dark:text-gray-300
                  dark:focus:shadow-outline-gray
                "
                placeholder="H"
                :disabled="item.stackable"
              />
            </div>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                type="radio"
                v-model="item.length_unit"
                @click="changeLoadType('CM')"
                class="
                  form-checkbox
                  h-4
                  w-4
                  text-gray-800
                  dark:focus:shadow-outline-gray dark:text-gray-300
                "
                :id="'lengthUnit' + id"
                value="CM"
              /><span class="ml-2 text-gray-700"> cm </span>
            </label>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                :selected="true"
                type="radio"
                v-model="item.length_unit"
                @click="changeLoadType('IN')"
                class="
                  form-checkbox
                  h-4
                  w-4
                  text-gray-800
                  dark:focus:shadow-outline-gray dark:text-gray-300
                "
                :id="'lengthUnit' + id"
                value="IN"
              /><span class="ml-2 text-gray-700"> pulg </span>
            </label>
          </div>
        </div>

        <!-- CBM -->
        <div
          class="my-2 flex md:inline md:w-20 text-center"
          v-if="data.type_transport != 'CONTAINER'"
        >
          <div>
            <span v-if="id == 0" class="text-sm font-semibold"> CBM </span>
            <div class="flex">
              <input
                :value="(item.cbm = (item.length * item.width * item.height) / 1000000)"
                class="
              w-full
              h-9 
              flex
              text-center text-sm
              dark:bg-gray-700
              focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
              dark:text-gray-300 dark:focus:shadow-outline-gray
              form-input
            "
                :disabled="item.mode_calculate"
                placeholder="CBM"
              />
            </div>
          </div>
        </div>

        <!-- peso unitario -->
        <div class="my-2 flex flex-col md:w-32 text-center">
          <div>
            <span v-if="id == 0" class="text-sm font-semibold"> Peso Unitario </span>
            <div class="flex">
              <input
                v-model.number="item.weight"
                :max="99999"
                type="number"
                :class="[
                  'h-9 flex text-center text-sm dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input w-full',
                  data.type_transport != 'CONTAINER' ? '' : ''
                ]"
              />
              <span v-if="validateweight" class="text-center text-red-600 text-xs">{{
                validateweight
              }}</span>
              <br v-if="validateweight" />
            </div>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                type="radio"
                v-model="item.weight_units"
                @click="changeLoadType('CM')"
                :id="'weight_units' + id"
                :name="'weight_units' + id"
                class="
                form-checkbox
                h-4
                w-4
                text-gray-800
                form-checkbox
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:focus:shadow-outline-gray dark:text-gray-300
              "
                checked
                value="KG"
              />
              <span class="ml-2 text-gray-700"> Kg </span>
            </label>
            <label class="inline-flex text-sm items-center mx-2 mt-2">
              <input
                type="radio"
                v-model="item.weight_units"
                @click="changeLoadType('IN')"
                :id="'weight_units' + id"
                :name="'weight_units' + id"
                class="
                form-checkbox
                h-4
                w-4
                text-gray-800
                form-checkbox
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:focus:shadow-outline-gray dark:text-gray-300
              "
                value="LB"
              />
              <span class="ml-2 text-gray-700"> Lbs </span>
            </label>
          </div>
        </div>

        <!-- No aplilable -->
        <div class="my-2 flex justify-center">
          <label
            class="inline-flex text-sm items-center sm:mb-1.5"
            v-if="data.type_transport === 'CONSOLIDADO'"
          >
            <input
              type="checkbox"
              v-model="item.stackable"
              class="
                form-checkbox
                h-4
                w-4
                text-gray-800
                form-checkbox
                focus:border-blue-400 focus:outline-none focus:shadow-outline-blue
                dark:focus:shadow-outline-gray dark:text-gray-300
              "
              @click="stackable(id)"
              checked
            />
            <span class="ml-2 text-gray-700">No Apilable</span>
          </label>
        </div>

        <!-- Botones añadir/eliminar -->
        <div
          class="flex justify-center h-10 mt-5 sm:mt-7"
          v-if="item.mode_calculate || typeSelected == 'CONTAINER'"
        >
          <button
            v-if="id > 0"
            @click="deleteForm(id)"
            class="
              w-28
              bg-transparent
              focus:outline-none
              uppercase
              text-xs
              hover:bg-red-600
              text-red-700
              font-semibold
              hover:text-white
              py-2
              px-2
              border border-red-500
              hover:border-transparent
              rounded
            "
          >
            Eliminar
          </button>

          <button
            v-else
            @click="AddFielForm"
            class="
              w-28
              bg-transparent
              focus:outline-none
              uppercase
              text-xs
              hover:bg-blue-600
              text-blue-700
              font-semibold
              hover:text-white
              py-2
              px-2
              border border-blue-500
              hover:border-transparent
              rounded
            "
          >
            Añadir Carga
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
  props: {
    title: {
      require: false,
      default: 'Cotizador Online'
    }
  },
  data() {
    return {
      showKg: true,
      showIn: true
    };
  },
  methods: {
    AddFielForm() {
      this.$store.dispatch('load/addLoad', this.item);
    },
    deleteForm(id) {
      this.$store.dispatch('load/removedLoad', id);
    },
    typeSelected(value) {
      this.mode_selected = value;
      this.reset();
    },
    reset() {
      this.$store.state.load.loads = [];
      this.$store.dispatch('load/addLoad', this.item);
    },
    changeLoadType(unit) {
      this.$store.dispatch('load/changeLoadType', unit);
    },
    stackable(id) {
      this.loads[id].height = this.loads[id].stackable ? 0 : 230;
    }
  },
  computed: {
    ...mapState('load', ['item', 'loads', 'mode_selected']),
    ...mapState('application', ['data']),

    validateweight() {
      const { loads } = this.$store.state.load;

      /* switch case para peso unitario en KG y LB en courier */
      switch (
        (loads.length && loads[loads.length - 1].weight_units == 'KG') ||
        loads[loads.length - 1].weight_units == 'LB'
      ) {
        case loads[loads.length - 1].weight == '':
          return '';

        case loads[loads.length - 1].weight_units == 'KG' &&
          // this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight < 0.01:
          return 'Limite minimo de peso: 0.01 KG';

        case loads[loads.length - 1].weight_units == 'LB' &&
          // this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight < 0.02:
          return 'Limite minimo de peso: 0.02 LB';

        case loads[loads.length - 1].weight_units == 'KG' &&
          this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight > 2268:
          return 'Excede limite maximo de peso: 2268 KG';

        case loads[loads.length - 1].weight_units == 'LB' &&
          this.data.type_transport == 'COURIER' &&
          loads[loads.length - 1].weight > 5000:
          return 'Excede limite maximo de peso: 5000 LB';

        case loads[loads.length - 1].weight_units == 'KG' &&
          this.data.type_transport != 'COURIER' &&
          loads[loads.length - 1].weight > 24000:
          return 'Excede limite maximo de peso: 24.000 KG';

        case loads[loads.length - 1].weight_units == 'LB' &&
          this.data.type_transport != 'COURIER' &&
          loads[loads.length - 1].weight > 52910:
          return 'Excede limite maximo de peso: 52.910 LB';

        case loads[loads.length - 1].weight_units == 'KG' && loads[loads.length - 1].weight >= 0.01:
          return '';

        case loads[loads.length - 1].weight_units == 'LB' && loads[loads.length - 1].weight >= 0.02:
          return '';

        default:
          false;
          break;
      }
      return false;
    }
  },
  created() {
    this.$store.state.load.mode_selected = this.$store.state.application.data.type_transport;
    if (!this.loads.length) this.reset();
  }
};
</script>
