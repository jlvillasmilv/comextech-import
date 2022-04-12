<div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" x-cloak>
    <!-- Modal -->
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0  transform translate-y-1/2" x-on:keydown.escape="closeModal"
        class="w-full h-auto sm:px-6 sm:py-4 bg-white dark:bg-gray-800 sm:rounded-3xl border-2 border-blue-1200 sm:m-4 sm:max-w-2xl"
        role="dialog" id="modal">
        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
        <header class="flex justify-end">
            <button
                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                aria-label="close" x-on:click="closeModal">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                    <path
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" fill-rule="evenodd"></path>
                </svg>
            </button>
        </header>
        <!-- Modal body -->
        <div class="h-auto">
            <form class="flex flex-col justify-evenly h-auto"
                x-on:submit.prevent="submitModalPayment">
                <input type="hidden" name="application_id" id="application_id" x-model="application.id" />

                <h2 class="text-xl font-bold" id="solicitud">Solicitud: <span x-html="application.code"></span></h2>
                <div class="mt-4 h-4/12 flex justify-between border-b-4">
                    <div class="w-6/12">
                        <h3 class="font-bold">Tipo de operación</h3>
                        <div class="flex justify-start w-full">
                            <div class="w-7/12 sm:w-7/12 flex flex-col justify-center items-center mt-2 mb-3 lg:mb-8">

                                <span class="iconify h-10 w-10" x-bind:data-icon="icon"></span>

                                <p id="servicio" class="text-center font-semibold" x-html="application.type_transport">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-6/12 flex justify-center">
                        <div class="w-10/12 flex flex-col">
                            <h3 class="font-bold text-center text-blue-1400">Resumen</h3>
                            <div class="mt-2 flex justify-center">
                                <label class="mr-2 flex flex-col justify-center text-xl font-semibold">Total</label>
                                <span id="total-costos"
                                    class="flex flex-col flex-wrap justify-center w-11/12 sm:w-8/12 h-11 bg-gray-200 text-center text-lg font-semibold rounded"
                                    x-html="new Intl.NumberFormat('es-es', { style: 'currency', currency: 'CLP' }).format(application.tco_clp)"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-4 flex justify-between">
                    <h3 class="w-3/12 text-left font-bold">Fuentes de pago</h3>
                    <div class="w-6/12 flex flex-col items-center">
                        <span class="font-semibold align-bottom w-full text-center text-xs text-red-500"
                            x-show="prepaidValidate(formPaymentApp.available_prepaid)" x-text="prepaidValidate(formPaymentApp.available_prepaid)
                                ? `El monto de PREPAGO utilizado puede ser 0 ó el mismo monto autorizado`
                                : ''"></span>
                        <span class="font-semibold align-bottom w-full text-center text-xs text-red-500"
                            x-show="creditValidate(formPaymentApp.available_credit)" x-text="creditValidate(formPaymentApp.available_credit)
                                ? 'Monto de CREDITO no permitido'
                                : ''"></span>
                    </div>
                    <h3 class="w-3/12 text-right font-bold">Resumen de pagos</h3>
                </div>
                <div class="flex flex-col">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="w-4/12" id="prepagoSII">
                                        <p class="flex flex-col justify-center h-12 my-2 bg-gray-200 text-center rounded"
                                            x-html="new Intl.NumberFormat('es-es', {
                                                style: 'currency',
                                                currency: 'CLP',
                                            })
                                            .format(formPaymentApp.availablePrepaid)"></p>
                                    </td>
                                    <td class="w-1/12">
                                        <div>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="font-semibold text-center w-3/12">
                                        <div class="flex flex-col">
                                            <span>PREPAGO</span>
                                            <span>(Cesión SII)</span>
                                        </div>
                                    </td>
                                    <td class="w-1/12">
                                        <div>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="w-4/12" id="total-prepagoSII">
                                        <input id="input-available" type="text" value="0"
                                            class="text-center h-12 w-full p-3 border-black border rounded"
                                            onfocus="if(this.flag == undefined){ this.flag = true; this.value=''; }"
                                            x-on:keydown.enter.prevent=""
                                            x-on:change.debounce="formatterCredit($event.target.id)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-4/12" id="credito-disponible">
                                        <p class="flex flex-col justify-center h-12 my-2 bg-gray-200 text-center rounded"
                                            x-html="
                                            new Intl.NumberFormat('es-es', {
                                                style: 'currency',
                                                currency: 'CLP'
                                            })
                                            .format(formPaymentApp.availableCredit)">
                                        </p>
                                    </td>
                                    <td class="w-1/12">
                                        <div>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="font-semibold text-center w-3/12">CREDITO DISPONIBLE</td>
                                    <td class="1/12">
                                        <div>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="w-4/12" id="total-credito">
                                        <input type="text" id="input-credit" value="0"
                                            class="text-center h-12 w-full p-3 border-black border rounded"
                                            onfocus="if(this.value == '0'){this.value='';}"
                                            x-on:keydown.enter.prevent=""
                                            x-on:change.debounce="formatterCredit($event.target.id)" />
                                    </td>
                                </tr>
                                <tr class="border-b-4">
                                    <td class="w-4/12 text-xs font-bold text-blue-1400 align-text-top">2%
                                        mensual
                                    </td>
                                    <td class="w-1/12">

                                    </td>
                                    <td class="uppercase font-semibold text-center w-3/12">
                                        <p>A pagar</p>
                                    </td>
                                    <td class="1/12">
                                        <div>
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="w-4/12" id="btn-total-pagar">
                                        <p id="total-costos" x-text="new Intl.NumberFormat('es-es', {
                                                style: 'currency',
                                                currency: 'CLP'
                                            }).format(parseFloat(application.tco_clp - formPaymentApp.available_credit - formPaymentApp.available_prepaid)
                                            .toFixed(2)) < '0'
                                            ? 0
                                            : new Intl.NumberFormat('es-es', {
                                                style: 'currency',
                                                currency: 'CLP'
                                            }).format(parseFloat(application.tco_clp - formPaymentApp.available_credit - formPaymentApp.available_prepaid)
                                            .toFixed(2))"
                                            class="flex flex-col justify-center h-11 my-2 bg-blue-1500 text-center rounded">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="py-2 text-left">Validar Codigo</td>
                                    <td colspan="1" class="py-2 text-left">Total Operación</td>
                                </tr>
                                <tr>
                                    <td colspan="1">
                                        <span class="flex flex-col">
                                            <input type="text" placeholder="Codigo"
                                                class="bg-gray-100 text-center px-2 h-11 border rounded w-11/12"
                                                x-model="formPaymentApp.authorization_code" />
                                        </span>
                                    </td>
                                    <td colspan="3">
                                        <div class="flex justify-center px-4">
                                            <button
                                                class="flex flex-col items-center justify-center w-40 h-20 bg-blue-1400 text-white text-sm border rounded-lg hover:bg-blue-1000"
                                                x-bind:disabled="isLoadingPay"
                                                >
                                                <span class="font-semibold uppercase">Activar</span>
                                                <span>(Firmar y/o Pagar)</span>
                                                <svg x-show="isLoadingPay" class="animate-spin  h-5 w-5 text-white"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg></button>
                                        </div>
                                    </td>
                                    <td colspan="1" id="total-pagos">
                                        <p id="total-costos"
                                            x-text="new Intl.NumberFormat('es-es', { style: 'currency', currency: 'CLP' }).format(parseFloat(application.tco_clp - formPaymentApp.available_credit - formPaymentApp.available_prepaid).toFixed(2))"
                                            class="font-semibold flex flex-col justify-center h-11 my-2 bg-gray-200 text-center rounded">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <button
                                                class="flex items-center justify-evenly bg-gray-100 text-sm text-center font-semibold px-4 w-28 h-8 border border-blue-1400 rounded-lg hover:bg-gray-300"
                                                type="button"
                                                id="btn-solicitar"
                                                x-on:click="sendAuthorizationCode(application.id)"
                                                x-bind:disabled="isDisabled && isLoadingValidation">
                                                Solicitar<svg x-show="isLoadingValidation"
                                                    class="animate-spin ml-1 h-4 w-4 text-black"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="text-black opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </button>
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
</div>
</div>
