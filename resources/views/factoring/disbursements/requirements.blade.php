@php
    $legal_info =  auth()->user()->client_legal_info()->count();
@endphp


<div class="grid gap-6 mb-4">

  <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-4 ">
      <div class="flex justify-center">
         {{-- Cesión de Facturas SII --}}
        <div class="">
          <span class="px-2 py-1 dark:text-white">  Cesión de Facturas SII</span>
          <span style="color:{{$status[$invoices_sii]['color']}}" class="fas fa-{{$status[$invoices_sii]['icon']}} fa-lg">
        
        </div>

         {{-- Certificado de Deuda Tributaria (TGR) --}}
        <div class="mx-2 ">
          <span class="px-2 py-1 dark:text-white">Certificado de Deuda Tributaria (TGR)</span>
          
          <span style="color:{{$status[$tax_debt]['color']}}" class="fas fa-{{$status[$tax_debt]['icon']}} fa-lg"> 
          </span> 
          <div role="group" class="text-gray-600 flex m-2"> 
              <div class="file-select mx-2" id="src-file1"  >
                <input type="file" id="filecert_dueda_tribu" ref="file" >
              </div>
              <a data-remote="cert_dueda_tribu" class="upload bg-gray-400 hover:bg-gray-500 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded"><i class="fas fa-cloud-upload-alt fa-lg text-white-50"></i> Subir</a>
          </div>
        
        </div>
         {{-- Anexo Cesión --}}
        <div class="mx-2">
          <span class="px-2 py-1 dark:text-white">Anexo Cesión</span>
          
          <span style="color:{{$status[$annex]['color']}}" class="fas fa-{{$status[$annex]['icon']}} fa-lg"> </span>
          <div role="group" class="text-gray-600 flex m-2"> 
              <div class="file-select mx-2" id="src-file1"  >
                <input type="file"  id="filecontrato" ref="file" >
              </div>
              <a data-remote="cert_dueda_tribu" class="upload bg-gray-400 hover:bg-gray-500 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded">
                <i class="fas fa-cloud-upload-alt fa-lg text-white-50 mr-2"></i> Subir
              </a>
          </div>
        
        </div>
         {{--  Instruccion de Abono en Cuenta Corriente --}}
        <div class="mx-2">
          <span class="px-2 py-1 dark:text-white">Instruccion de Abono en Cuenta Corriente</span>
          
          <span style="color:{{$status[true]['color']}}"
           class="fas fa-{{$status[true]['icon']}} fa-lg"> </span>
          
           @if($applications->disbursement->bank_accounts_id == null ) 
              <div class="row justify-content-center align-content-center" id="rowAccount" >
              </div>
              <div class="row justify-content-{{ is_null($bankAccounts)? 'center':'between'}} align-content-center " id="FormbankAccounts" >
                      @if (is_null($bankAccounts))
                        <a   href="{{route('bank-accounts.index')}}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded my-2" >
                          <span class="text"> Agregar Cuentra Corriente </span>
                          <span class="icon">
                              <i class="fas fa-plus fa-md ml-2"></i>
                          </span>
                        </a>
                      @else 
                      <div class="px-2" id="add_to">
                        <div class="flex mb-4">
                            <div class="w-3/4 mr-1">
                                <select
                                  id="bankAccounts"
                                  name="bankAccounts"
                                  class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-blue-300 focus:outline-none focus:shadow-outline-blue form-select select2  @error('country_id') is-invalid @enderror">
                                  @foreach($bankAccounts as $account )

                                    <option value="{{ $account->id }}" selected>
                                      {{ $account->bank->name }} - {{ $account->number }}
                                    </option>

                                  @endforeach
                                  
                                </select>
                
                            </div>
                           
                            <div class="w-1/4 ml-1">

                              <button  id="addAccount" type="button" class="btn-add flex ml-2 px-3 py-1 my-7 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" 
                              data-remote="#" data-id="#" autocomplete="off"
                              title="Agregar">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                              </svg>

                              </button>

                            </div>
  
                        </div>
                    </div>
                      @endif
              </div>
            @else
              <div class="row justify-content-center align-content-center"  >
                <span class="px-2 py-1 dark:text-white mx-2">
                  {{ $applications->user->bankAccounts->where('id', $applications->disbursement->bank_accounts_id)->first()->bank->name}}
               </span>
               <span class="px-2 py-1 dark:text-white mx-2">
                 Numero: {{ $applications->user->bankAccounts->where('id', $applications->disbursement->bank_accounts_id)->first()->number}}
               </span>
              </div>
            @endif
        
        </div>
        
      </div>
  </div>
</div>

