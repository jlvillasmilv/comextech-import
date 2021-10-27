@extends('layouts.app')

@section('content')
   
<div class="card">
    <div class="card-header text-uppercase font-weight-bold">
        Detalles de la Solicitud
      </div>
    <div class="card-body">
      <p class="card-text">Estado: 
          
        <span title="{{$applications->status}}" style="font-size: 28px; color: {{ App\Models\Application::STATUS_COLOR[$applications->status] ?? 'none' }};">
            <i class="{{ App\Models\Application::STATUS_ICON[$applications->status] ?? 'none' }}" aria-hidden="true"></i>
        </span>
        
      </p>
      <p class="card-text">Comentario 1: {{ $applications->observation}}</p>
      <p class="card-text">{{ $applications->description}}</p>
      <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered  datatable datatable-Project">
        <thead>
            <tr>
                <th class="text-center">Folio   </th>
                <th class="text-center">Pagador </th>
                <th class="text-center">RUT </th>
                <th class="text-center">Emision </th>
                <th class="text-center"> Vencimiento</th>
                <th class="text-center">Monto Total </th>
                <th class="text-center">Dif Precio</th>
                <th class="text-center">Comisión</th>
                <th class="text-center">Descuento</th>
                <th class="text-center">Desembolso</th>
                <th class="text-center">Excedentes</th>
            </tr>
        </thead>
        <tbody>
            @each('application.row', $applications->invoices, 'invoice')
        </tbody>
      </table>
      </div>

    </div>

</div>

 
@endsection
