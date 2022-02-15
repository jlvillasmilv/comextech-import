<x-app-layout title="Detalle Registro">
<div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('admin.freight-quotes.index')}}">Cotizaciones</a>  
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Solicitud  #   {{ $data->code }}
            </h4>
           
        </div>
       
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Status:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">{{$data->status ? 'Procesado' : 'En Proceso'}}  </p>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-bold mb-2">Cliente:</span>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                        {{$data->customer->name}} 
                    </p>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                        {{$data->customer->email}} 
                    </p>
                    <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                        {{$data->customer->phone_number}} 
                    </p>
                </label>
               
                <div class="px-2">
                    <div class="sm:flex mb-4">
                        <div class="sm:w-1/4 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Monto transporte:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                 {{number_format($data->transport_amount,2,",",".") }} USD
                            </p>
                        </div>
                        <div class="sm:w-1/4 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Monto transporte Local:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{number_format($data->local_transp_amt,2,",",".") }} USD
                            </p>
                        </div>
                        <div class="sm:w-1/4 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Monto Otros gastos:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{number_format($data->oth_exp,2,",",".") }} CLP
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="sm:flex mb-4">
                        <div class="sm:w-1/4 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Mercaderia:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                 {{number_format($data->cargo_value,2,",",".") }} USD
                            </p>
                        </div>
                        <div class="sm:w-1/4 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >Seguro:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{number_format($data->insurance_amt,2,",",".") }} USD
                            </p>
                        </div>
                        <div class="sm:w-1/4 ml-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" >cif:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{number_format($data->cif,2,",",".") }} USD
                            </p>
                        </div>
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Fecha Solicitud:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ date('d-m-Y', strtotime($data->created_at)) }}
                            </p>
                        </div>

                        <div class="w-1/2 mr-1">
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Typo de transporte:</label>
                            <p class="text-grey-dark mb-2 text-sm dark:text-gray-300">
                                {{ $data->type_transport }}
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Detalle Cargamento 
            </h4>
        </div>

        @include('admin.freight_quotes.table')

    </div>
</x-app-layout>