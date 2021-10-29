@php
    $legal_info =  auth()->user()->client_legal_info()->count();
@endphp




  <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-4 ">
      <div class="flex justify-start">
         {{-- Cesión de Facturas SII --}}
        <div class="mr-2">
          <span class="px-2 py-1 dark:text-white mx-2">  Cesión de Facturas SII</span>
          <span style="color:{{$status[$invoices_sii]['color']}}" class="fas fa-{{$status[$invoices_sii]['icon']}} fa-lg">
        
        </div>

         {{--  Instruccion de Abono en Cuenta Corriente --}}
        <div class="mx-2">
          <span class="px-2 py-1 dark:text-white mr-2">Instruccion de Abono en Cuenta Corriente</span>
          
          <span style="color:{{$status[true]['color']}}"
           class="fas fa-{{$status[true]['icon']}} fa-lg"> </span>
          
           @if($applications->disbursement->bank_accounts_id == null ) 
              <div class="row justify-content-center align-content-center" id="rowAccount" >
              </div>
              <div class="row justify-content-{{ is_null($bankAccounts)? 'center':'between'}} align-content-center " id="FormbankAccounts" >
                      @if (is_null($bankAccounts))
                        <a href="/clients#/bank"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded inline-flex items-center rounded my-2" >
                          <span class="text">   Agregar Cuentra Corriente </span>
                          <span class="icon ml-2">
                              <i class="fas fa-plus fa-md"></i>
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

