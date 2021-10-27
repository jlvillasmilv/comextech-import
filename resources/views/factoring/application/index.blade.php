@php
$impuesto_sii     = auth()->user()->FileStoreClient->where('type','impuesto_sii');
$carp_tributaria  = auth()->user()->FileStoreClient->where('type','carp_tributaria');
$credential       = auth()->user()->credentialStores;
@endphp
                
 
<x-app-layout title="Solicitudes">
    <div class="container grid px-6 mx-auto">
    @if(!$credential->provider_password)
        @if($impuesto_sii->isEmpty() ||  $carp_tributaria->isEmpty())
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Atencion!</h4>
            <p>Estamos a la espera de tu <a  class="alert-link">  Carpetas Tributarias Actualizadas y la Última declaracion de Impuesto Renta (SII) </a> para aprobar tu Solicitud <a href="client#/finacial-information" class="alert-link"> Inserta tus documentos aqui! </a>
                <hr>
            </a>  Ingresa <a href="/client#/providers" class="alert-link">  tu contraseña del SII  a nuestro sistema </a>y  agiliza tu proceso! 
            </p> 
        </div>
        @endif 
    @endif
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Solicitudes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$applications->count()}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Solicitudes Aceptadas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$aprobadas}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Solicitudes en Proceso</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$proceso}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="far fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Solicitudes Rechazadas
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$rechazada}}</div>
                                </div>
                            
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="card">
        <div class="card-header text-uppercase font-weight-bold">
        Listado de Solicitudes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered  datatable datatable-Project">
                    <thead>
                        <tr class="text-center">
                            <th role="row" class="text-center ">N°</th>
                            <th role="row" class="text-center ">Fecha</th>
                            <th role="row" class="text-center ">Cant. <br> Facturas</th>
                            <th role="row" class="text-center ">Monto</th>
                            <th role="row" class="text-center ">Diferencia Precio</th>
                            <th role="row" class="text-center ">Comisión</th>
                            <th role="row" class="text-center ">Descuento</th>
                            <th role="row" class="text-center ">Desembolso</th>
                            <th role="row" class="text-center ">Excedentes</th>
                            <th role="row" class="text-center ">Estado</th>
                            <th role="row" class="text-center ">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($applications) > 0 )
                                    
                            @foreach ($applications->sortBy('status') as $application)
                            <tr>
                                <td class="text-center">{{ $application->id }}</td>
                                <td class="text-center">{{ date_format($application->created_at, 'd-m-y') }}</td>
                                <td class="text-center">
                                    {{ $application->invoices->count('number') }}
                                </td>
                                <td class="text-center">
                                {{number_format($application->invoices->sum('total_amount'),0,",",".")}}
                                </td>
                                <td class="text-center">
                                    @php
                                    $dif_total = 0;  
                                    @endphp
                                
                                    @foreach ($application->invoices as $key=> $invoice)

                                    @php
                                    
                                    $dif = (($invoice->feesHistory->rate / 100) * ($invoice->feesHistory->discount / 100) * $invoice->total_amount * ($invoice->payment_real / 30)); 
                                    $dif_total += $dif;
                                    @endphp
                            
        
                                    @endforeach
                                    {{number_format($application->invoices->sum('price_difference'),0,",",".")}}

                                </td>
                                <td class="text-center">
                                    @php
                                    $com_total = 0;  
                                    @endphp
                                
                                    @foreach ($application->invoices as $key=> $invoice)

                                        @php
                                        
                                        $dif = $invoice->feesHistory->commission;
                                        $com_total += $dif;
                                        @endphp
                            
                                    @endforeach

                                    {{number_format($com_total,0,",",".") }}
                                        
                                </td>
                                <td class="text-center">
                                    {{number_format($com_total + $application->invoices->sum('price_difference'),0,",",".")}}
                                </td>
                                <td class="text-center">
                                    {{number_format($application->invoices->sum('disbursement'),0,",",".")}}
                                </td>
                                <td class="text-center">
                                    {{number_format($application->invoices->sum('surplus'),0,",",".")}}
                                </td>
                                <td  class="text-center">
                                    <span title="{{$application->status}}" style="font-size: 20px; color: {{ App\Models\Application::STATUS_COLOR[$application->status] ?? 'none' }};">
                                        <i class="{{ App\Models\Application::STATUS_ICON[$application->status] ?? 'none' }}" aria-hidden="true"> </i>
                                    </span><br>
                                    <span class="text-capitalize text-gray-500">  {{$application->status}} </span>
                                </td>
    
                                <td class="text-center">
                                    <a href="{{ route('applications.show', $application->id) }}" class="btn  btn-info btn-sm " > 
                                        <i class="fa fa-server"> </i>
                                    </a>
                                    @if (!$application->disbursement_status and  $application->status == 'Aprobada')      
                                    <a  data-remote="{{ route('applications.update', $application->id) }}"  href="{{ route('applications.show', $application->id) }}"  class="btn btn-sm btn-status btn-dark btn-icon-split"> <span class="icon" >    <i class="fas fa-hand-holding-usd  "></i></span></a>
                                    <br>
                                    
                                    @endif
                                </td>
                                
                            </tr>
                            @endforeach

                                
                            @else

                            <tr>
                                <td colspan="12" class="text-center">  No tienes solicitudes</td> 
                            </tr>
                                

                        @endif
                    </tbody>
                    
                </table>
            </div>
        </div>              
    </div>
</div>

</x-app-layout>


@section('scripts')
@parent

<script>

$.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-Project:not(.ajaxTable)').DataTable({ language: {
                    url: '{{asset("js/lang.json")}}'
                } }).columns.adjust();
  
</script>
@endsection

