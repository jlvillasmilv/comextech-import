<template>
  <div>
    <h2 id="solicitud">Solicitud XXXXXXXXXX</h2>
    <div class="flex justify-between border-b-4">
      <div class="w-6/12">
        <h3>Tipo de operación</h3>
        <div class="flex justify-center flex-wrap w-full">
          <div
            v-for="service in typeTransport"
            :key="service.name"
            class="w-7/12 sm:w-7/12 flex flex-col justify-center mt-2 mb-3 lg:mb-8"
          >
            <div
              id="icon"
              :class="[
                'mx-1 flex flex-col items-center border border-blue-1300 rounded hover:bg-blue-1300 px-3 py-2 text-gray-900 hover:text-white border-b-2',
                service.name == $store.state.application.data.type_transport
                  ? 'bg-blue-1300 hover:bg-blue-1200 text-white'
                  : ''
              ]"
              @click="typeSelected(service.name)"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-10 w-10"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  :d="service.path"
                  fill="bg-white"
                />
              </svg>
            </div>
            <p id="servicio" class="text-center">
              {{ service.name }}
            </p>
          </div>
        </div>
      </div>
      <div class="w-6/12 flex justify-center">
        <div class="flex flex-col">
          <details>
            <summary>Resumen de costos</summary>
            <div class="flex flex-col">
              <div class="flex justify-between">
                <label>Proveedor</label>
                <span id="proveedor">1.600.000</span>
              </div>
              <div class="flex justify-between">
                <label>Transporte</label>
                <span id="transporte">500.000</span>
              </div>
              <div class="flex justify-between">
                <label>Internacion</label>
                <span id="internacion">399.000</span>
              </div>
            </div>
          </details>
          <div class="flex justify-between">
            <label>Total</label>
            <span id="total-costos">2.499.500</span>
          </div>
        </div>
      </div>
    </div>
    <h3 class="mt-3">Fuentes de pago</h3>
    <div class="mt-3 flex flex-col">
      <div class="w-full overflow-x-auto">
        <table class="w-full table-auto whitespace-no-wrap">
          <thead></thead>
          <tbody>
            <tr>
              <td id="prepagoSII">0</td>
              <td>
                <div>
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    ></path>
                  </svg>
                </div>
              </td>
              <td>PREPAGO (Cesion SII)</td>
              <td>
                <div>
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    ></path>
                  </svg>
                </div>
              </td>
              <td id="total-prepagoSII">900.000</td>
            </tr>
            <tr>
              <td id="credito-disponible">0</td>
              <td>
                <div>
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    ></path>
                  </svg>
                </div>
              </td>
              <td>CREDITO DISPONIBLE</td>
              <td>
                <div>
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    ></path>
                  </svg>
                </div>
              </td>
              <td id="total-credito">1.000.000</td>
            </tr>
            <tr>
              <td>2% mensual</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="text-left">
                <div>
                  <button>Pagar</button>
                </div>
              </td>
              <td id="btn-total-pagar">599.000</td>
            </tr>
            <tr>
              <td>Firma</td>
            </tr>
            <tr>
              <td colspan="4">
                <span>
                  <input type="text" class="form-input w-2/6" />
                </span>
              </td>
              <td id="total-pagos">2.499.500</td>
            </tr>
            <tr>
              <td>
                <div>
                  <button id="btn-solicitar">Solicitar</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
// import { mapState } from 'vuex';
export default {
  data() {
    return {
      typeTransport: [
        {
          name: 'COURIER',
          path:
            'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
        }
      ]
    };
  },
  // computed: {
  //   ...mapState('application', ['typeTransport'])
  // }
  beforeUpdate() {
    console.log('estoy aqui');
  },
  updated() {
    console.log('updated');
  }
};
</script>
<style></style>
