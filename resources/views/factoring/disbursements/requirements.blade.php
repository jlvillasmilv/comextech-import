@php
    $legal_info =  auth()->user()->client_legal_info()->count();
@endphp

<div class="col-lg-3 col-md-12  col-sm-12 p-2 justify-content-center">
          {{-- Cesión de Facturas SII --}}
            <div class="d-flex bd-highlight ">
              <div class="p-1 flex-grow-1 bd-highlight"> <span class="text-dark h6  font-weight-bold ">  Cesión de Facturas SII</span>   </div>
              <div class="p-1 bd-highlight"><span style="color:{{$status[$invoices_sii]['color']}}" class="fas fa-{{$status[$invoices_sii]['icon']}} fa-lg"> </span> </div>
            </div>
            <hr> 
        
          {{-- Certificado de Deuda Tributaria (TGR) --}}
            <div class="d-flex bd-highlight ">
              <div class="p-1 flex-grow-1 bd-highlight"> <span class="text-dark h6  font-weight-bold ">  Certificado de Deuda Tributaria (TGR)</span>  
              </div>
                <div class="p-1 bd-highlight"><span style="color:{{$status[$tax_debt]['color']}}" class="fas fa-{{$status[$tax_debt]['icon']}} fa-lg"> </span> 
                </div>
            </div>
            <div class="btn btn-group btn-group-toggle ">
              <div class="file-select" id="src-file1"  >
                  <input type="file"  id="filecert_dueda_tribu" ref="file" >
              </div>
            </div>
            <a data-remote="cert_dueda_tribu" class=" upload d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-cloud-upload-alt fa-lg text-white-50"></i> Subir</a>
            <hr>
          {{-- Anexo Cesión --}}
            <div class="d-flex bd-highlight   ">
              <div class="p-1 flex-grow-1 bd-highlight"> <span class="text-dark h6  font-weight-bold ">  Anexo Cesión</span>   </div>
                <div class="p-1 bd-highlight"><span style="color:{{$status[$annex]['color']}}" class="fas fa-{{$status[$annex]['icon']}} fa-lg"> </span> </div>
              </div>
              <div class="btn btn-group btn-group-toggle ">
              <div class="file-select" id="src-file1"  >
                  <input type="file"  id="filecontrato" ref="file" >
              </div>
            </div>
            <a data-remote="contrato" class=" upload d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-cloud-upload-alt fa-lg text-white-50"></i> Subir</a>
            @if ($legal_info > 0)
              <a href="{{ route('assignment.contract' , $applications->id)}}"   class=" d-sm-inline-block btn btn-sm btn-info shadow-sm"><i class="fas fa-cloud-download-alt fa-lg text-white-50"></i> Descargar</a>
            @endif
            <hr>
        
          {{--  Instruccion de Abono en Cuenta Corriente --}}
            <div class="d-flex bd-highlight">
              <div class="p-1 flex-grow-1 bd-highlight text-center"> <span class="text-dark h6  font-weight-bold ">  Instruccion de Abono en Cuenta Corriente</span>   </div>
                @if($applications->disbursement->bank_accounts_id !== null ) 
                  <div class="p-1 bd-highlight"><span style="color:{{$status[true]['color']}}" class="fas fa-{{$status[true]['icon']}} fa-lg"> </span> </div>
                @endif
            </div>
            @if($applications->disbursement->bank_accounts_id == null ) 
              <div class="row justify-content-center align-content-center" id="rowAccount" >
              </div>
              <div class="row justify-content-{{ $bankAccounts->isEmpty()? 'center':'between'}} align-content-center " id="FormbankAccounts" >
                      @if ($bankAccounts->isEmpty())
                        <a   href="/clients#/bank"class=" btn btn-sm btn-primary btn-icon-split my-2" >
                          <span class="text">   Agregar Cuentra Corriente </span>
                          <span class="icon">
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