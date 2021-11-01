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
                        <div class="col-md-10 ">
                          <select class="form-control " id="bankAccounts" name="bankAccounts" >
                            @foreach($bankAccounts as $account )
                                <option value="{{ $account->id }}" selected>{{ $account->bank->name }} - {{ $account->number }}</option>
                            @endforeach
                          </select> 
                        </div>
                        <div class="col-md-2">
                          <button  id="addAccount" class="btn btn-primary btn-icon-split" >
                            <span class="icon ">
                                <i class="fas fa-plus "> </i>
                            </span>
                          </button>
                        </div>
                      @endif
              </div>
            @else
              <div class="row justify-content-center align-content-center"  >
                  <h6 class="tex-center text-uppercase"> 
                    {{ $applications->client->bankAccounts->where('id', $applications->disbursement->bank_accounts_id)->first()->bank->name}}
                    <br>
                    Numero: {{ $applications->client->bankAccounts->where('id', $applications->disbursement->bank_accounts_id)->first()->number}}
                  </h6> 
              </div>
            @endif
        
        </div>
        
      </div>
  </div>
</div>

