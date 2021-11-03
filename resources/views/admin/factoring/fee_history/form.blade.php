<x-app-layout title="Desembolsos">
    @php
        $invoices_sii     = $data->assign_invoices_sii;
        $tax_debt         = $data->tax_debt;
        $annex            = $data->assignment_annex;
        ///array file
        $contrato         = $data->file_disbursement->where('type', 'contrato')->first();
        $cert_dueda_tribu = $data->file_disbursement->where('type', 'cert_dueda_tribu')->first();
    
    @endphp
    <div class="container grid px-6 mx-auto">
        <div class="bg-blue-300 text-blue-700 text-sm font-bold px-4 py-3 my-3" role="alert">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="font-bold" > {{ $data->application->user->company->name }}</p>
                    <p> <strong class="font-bold">RUT</strong>  {{ $data->application->user->company->tax_id }}</p>

                </div>
                <div>
                    <h5 class="alert-link" > Cuenta Bancaria Seleccionada</h5>
                    @if($data->bank_accounts_id !== null)
                       <h6> Nro Cuenta: {{$data->application->disbursement->BankAccount->number}}  -  {{$data->bankAccount->bank->name}}</h6>
                    @else
                        <h5> No ha selecionada cuenta.</h5>
                    @endif

                </div>
                
            </div>
        </div>


        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Actualizacion Desembolso
				 # {{  isset($data) ? str_pad($data->id, 6, '0', STR_PAD_LEFT) : '' }}
            </h4>
           
        </div>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form class="form-horizontal" role="form" method="POST" action="{{ isset($data) ? route('admin.factoring.disbursements.update', $id) : route('admin.factoring.disbursements.store') }}"  enctype="multipart/form-data">

                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-2/4 px-3 ">

                        <label class="block text-sm my-3">
                            <span class="text-gray-700 dark:text-gray-400">Status</span>
        
                            <select name="status" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select select2  @error('bank_id') is-invalid @enderror">
        
                                @foreach($status as $id )
        
                                @if(old('status', isset($data->status) && $data->status == $id) == $id )
                                    <option value="{{ $id }}" selected>{{ $id }}</option>
                                @else
                                    <option value="{{ $id }}">{{ $id }}</option>
                                @endif
        
                            @endforeach
        
                            </select>
                            
                            @if($errors->has('status'))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('status') }}
                                </span>
                            @endif
                        </label>

                    </div>
                    <div class="md:w-2/4 px-3 sm:w-full">
                        <div class="flex justify-start">
                            <button class="flex  px-4 py-2 my-8 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                               
                                <span> Actualizar Estatus </span>
                            </button>
                          </div>

                    </div>
                </div>

                

                <div class="flex flex-wrap">
                    <div class="sm:w-full md:w-1/3 px-3 ">
                      <label class="block text-sm my-3">
                        <span class="text-gray-800 dark:text-gray-400">
                            Certificado de Deuda Tributaria (TGR)
                            <a {{$cert_dueda_tribu !== null ? 'download' :'required' }} href="{{  $cert_dueda_tribu !== null ? route('admin.download', [$data->id, 'cert_dueda_tribu']):'#' }}"  class="text-white font-bold py-1 px-2 rounded {{$cert_dueda_tribu !== null ? 'bg-blue-300 hover:bg-blue-500' :'bg-gray-400 hover:bg-gray-500' }}" >
                                <i class="fas fa-{{$cert_dueda_tribu !== null ? 'file-download' :'times' }} "></i>
                              </a>
              
                        </span>
    
                        <div class="mt-2">
                            <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="tax_debt" value="1"
                                {{ $tax_debt  ? 'checked': ''}}
                                 />
                                <span class="ml-2">APROBADO</span>
                            </label>
                            <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                                <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="tax_debt" value="0"
                                {{ !$tax_debt? 'checked': ''}} 
                                 />
                                <span class="ml-2">RECHAZADO</span>
                            </label>
                            @if($errors->has('tax_debt'))
                                    <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('tax_debt') }}
                                    </span>
                                @endif
                        </div>
                       
                        </label>
                    </div>
    
                    <div class="sm:w-full md:w-1/3 px-3">
                        <label class="block text-sm my-3">
                            <span class="text-gray-800 dark:text-gray-400">
                                 Última declaracion de Impuesto Renta (SII)
                            </span>
    
                            <div class="mt-2">
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                    <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="assign_invoices_sii" value="1"
                                    {{ $invoices_sii  ? 'checked': ''}}
                                     />
                                    <span class="ml-2">APROBADO</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                                    <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="assign_invoices_sii" value="0"
                                    {{ !$invoices_sii ? 'checked': ''}} 
                                     />
                                    <span class="ml-2">RECHAZADO</span>
                                </label>
                                @if($errors->has('assign_invoices_sii'))
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{ $errors->first('assign_invoices_sii') }}
                                        </span>
                                    @endif
                            </div>
                           
                        </label>
                    </div>
    
                    <div class="sm:w-full md:w-1/3 px-3">
                        <label class="block text-sm my-3">
                            <span class="text-gray-800 dark:text-gray-400">
                                Anexo Cesión
                                <a {{$contrato !== null ? 'download' :'required' }} href="{{  $contrato !== null ? route('admin.download', [$data->id, 'contrato']):'#' }}"  class="text-white font-bold py-1 px-2 rounded {{$contrato !== null ? 'bg-blue-300 hover:bg-blue-500' :'bg-gray-400 hover:bg-gray-500' }}" >
                                    <i class="fas fa-{{$contrato !== null ? 'file-download' :'times' }}"></i>
                                  </a>
                            </span>
    
                            <div class="mt-2">
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-400">
                                    <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="assignment_annex" value="1"
                                    {{ $annex  ? 'checked': ''}}
                                     />
                                    <span class="ml-2">APROBADO</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-400">
                                    <input type="radio" class="text-blue-600 form-radio focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray" name="assignment_annex" value="0"
                                    {{ !$annex ? 'checked': ''}} 
                                     />
                                    <span class="ml-2">RECHAZADO</span>
                                </label>
                                @if($errors->has('assignment_annex'))
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{ $errors->first('assignment_annex') }}
                                        </span>
                                    @endif
                            </div>
                        
                        </label>
                    </div>
                </div>
            </form>
            <div class="grid gap-6 my-8 ">
		  
                @include('admin.factoring.disbursements.table')
    
            </div>
        </div>


    </div>

</x-app-layout>