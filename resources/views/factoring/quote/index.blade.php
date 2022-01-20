<x-app-layout title="Financiamiento">
  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
      &nbsp;
    </h2>

    <!-- With avatar -->
    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
      &nbsp;
    </h4>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap" id="table">
              <thead>
                <tr
                class="text-xs text-center font-semibold tracking-wide text-left text-white">
                  <th class="px-4 py-3  border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">Tipo de pago</th>
                  <th class="px-4 py-3">&nbsp;</th>
                  <th class="px-4 py-3  border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">Disponible</th>
                  <th class="px-4 py-3  border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">Utilizar</th>
                 </tr>
              </thead>
              <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                  <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          Pago Transferencia
                        </p>
                      </td>
                      <td class="w-1 px-4 py-3">
                        <div class="flex justify-center">

                          <button
                            id="addAccount"
                            type="button"
                            class="btn-add flex ml-2 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" 
                            data-remote="#"
                            data-id="#"
                            title="Actualizar"
                            >
                            Actualizar
                          </button>
                        </div>
                      </td>
                      <td class="px-4 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          0
                        </p>
                      </td>
                      <td class="px-4 py-3">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                          0
                        </p>
                      </td>
                  </tr>
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                      <p class="text-xs text-gray-600 dark:text-gray-400">
                        Pre pago con factoring
                      </p>
                    </td>
                    <td class="px-4 py-3">
                      <div class="flex justify-center">
                        {{-- href="{{ route('factoring.quotation') }}" --}}
                      <a
                        class="btn-info flex ml-2 px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"
                        data-remote = "{{ route('factoring.quotation') }}"
                        data-profile = "{{route('factoring.profile.index')}}"
                        href="#"
                        title="Solicitar"
                        >
                        Solicitar <br> Crédito
                      </a>
                    </div>
                    </td>
                    <td class="px-4 py-3">
                      <p class="text-xs text-gray-600 dark:text-gray-400">
                        0
                      </p>
                    </td>
                    <td class="px-4 py-3">
                      <p class="text-xs text-gray-600 dark:text-gray-400">
                        0
                      </p>
                    </td>
                </tr>
                
                <tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-4 py-3">
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                      Línea de crédito
                    </p>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex justify-center">

                       &nbsp;
                  </div>
                  </td>
                  <td class="px-4 py-3">
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                      0
                    </p>
                  </td>
                  <td class="px-4 py-3">
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                      0
                    </p>
                  </td>
              </tr>

              <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3">
                  <p class="text-xs text-gray-600 dark:text-gray-400">
                    Excedentes
                  </p>
                </td>
                <td class="px-4 py-3">
                  <div class="flex justify-center">

                     &nbsp;
                </div>
                </td>
                <td class="px-4 py-3">
                  <p class="text-xs text-gray-600 dark:text-gray-400">
                    0
                  </p>
                </td>
                <td class="px-4 py-3">
                  <p class="text-xs text-gray-600 dark:text-gray-400">
                    0
                  </p>
                </td>
            </tr>


              </tbody>
            </table>
        </div>
      </div>
  
</x-app-layout>
