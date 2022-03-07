
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" x-cloak>
        <!-- Modal -->
        <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0  transform translate-y-1/2" x-on:keydown.escape="closeModal" class="w-full px-6 py-4 bg-white dark:bg-gray-800 sm:rounded-3xl border-2 border-blue-1200 sm:m-4 h-11/12 sm:max-w-xl" role="dialog" id="modal">
            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-end">
                <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" aria-label="close" x-on:click="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <div class="h-9/12" >
              <form action="/application-generate-order" method="POST" class="flex flex-col justify-evenly h-10/12" x-on:submit.prevent="submitModalPayment">
                <input type="hidden" name="application_id" id="application_id" x-model="application.id" />

                    <h2 class="text-xl font-bold" id="solicitud">Solicitud: <span x-html="application.code"></span></h2>
                    <div class="mt-4 h-4/12 flex justify-between border-b-4">
                      <div class="w-6/12">
                        <h3 class="text-lg uppercase font-semibold">Tipo de operación</h3>
                        <div class="flex justify-start w-full">
                          <div
                            
                            class="w-7/12 sm:w-7/12 flex flex-col justify-center items-center mt-2 mb-3 lg:mb-8"
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
                                x-bind:d="icon"
                                fill="bg-white"
                              />
                            </svg>
                           
                            <p id="servicio" class="text-center font-semibold" x-html="application.type_transport"></p>
                          </div>
                        </div>
                      </div>
                      <div class="w-6/12 flex justify-center">
                        <div class="flex flex-col">
                          <details>
                            <summary class="text-lg uppercase font-semibold">Resumen de costos</summary>
                            {{-- <div class="flex flex-col">
                              <div class="mt-2 flex justify-between">
                                <label class="text-lg">Proveedor</label>
                                <span class="text-center w-6/12 text-lg border-b-2" id="proveedor">1.600.000</span>
                              </div>
                              <div class="mt-2 flex justify-between">
                                <label class="text-lg">Transporte</label>
                                <span class="text-center w-6/12 text-lg border-b-2" id="transporte">500.000</span>
                              </div>
                              <div class="mt-2 flex justify-between">
                                <label class="text-lg">Internacion</label>
                                <span class="text-center w-6/12 text-lg border-b-2" id="internacion">399.000</span>
                              </div>
                            </div> --}}
                          </details>
                          <div class="mt-2 flex justify-between">
                            <label class="text-lg font-semibold">Total</label>
                            <span id="total-costos" class="rounded bg-blue-1000 text-center font-semibold w-7/12" x-html="new Intl.NumberFormat('es-es', { style: 'currency', currency: 'CLP' }).format(application.tco_clp)"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mt-2 flex justify-between">
                        <h3 class="text-left font-hairline">Fuentes de pago</h3>
                        <h3 class="text-lg text-left font-semibold">Resumen de pagos</h3>
                    </div>
                    <div class="flex flex-col">
                      <div class="w-full overflow-x-auto">
                        <table class="w-full table-auto">
                          <thead>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="w-3/12" id="prepagoSII">
                                <span x-html="formPaymentApp.availablePrepaid"></span>
                                </td>
                              <td class="w-1/12">
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
                              <td class="w-5/12">PREPAGO (Cesion SII)</td>
                              <td class="w-1/12">
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
                              <td class="w-3/12" id="total-prepagoSII">
                                <input type="number"
                                    class="w-10/12"
                                    x-model.number="formPaymentApp.available_prepaid"
                                />
                               </td>
                            </tr>
                            <tr>
                              <td id="credito-disponible"><span x-html="new Intl.NumberFormat('es-es', { style: 'currency', currency: 'CLP' }).format(formPaymentApp.availableCredit)"></span></td>
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
                              <td id="total-credito">
                                <input type="number"
                                 class="w-10/12"
                                 x-model.number="formPaymentApp.available_credit"
                                />

                              </td>
                            </tr>
                            <tr>
                              <td>2% mensual</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td class="text-left">
                                <div class="px-4">
                                  <button class="p-2 border rounded" x-bind:disabled="loading">Pagar</button>
                                </div>
                              </td>
                              <td id="btn-total-pagar" >
                                <span id="total-costos" x-text="new Intl.NumberFormat('es-es', { style: 'currency', currency: 'CLP' }).format(parseFloat(application.tco_clp - formPaymentApp.available_credit - formPaymentApp.available_prepaid).toFixed(2))"></span>
                              </td>
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
                              <td id="total-pagos"
                              >
                                <span id="total-costos" x-text="new Intl.NumberFormat('es-es', { style: 'currency', currency: 'CLP' }).format(parseFloat(application.tco_clp - formPaymentApp.available_credit - formPaymentApp.available_prepaid).toFixed(2))"></span>
                              </td>
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
                </form>
            </div>
            <!-- <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                <button x-on:click="closeModal" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                </button>
                <button class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    Accept
                </button>
            </footer> -->
        </div>
    </div>
