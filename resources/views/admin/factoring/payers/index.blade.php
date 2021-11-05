 
<table>
    <thead>
    <tr class="tex-center">
        <th> NRO </th>
        <th> PAGADOR </th>
        <th> RUT </th>
        <th> TASA </th>
        <th> TASA MORA </th>
        <th> DESCUENTO </th>
        <th> COMISION </th>
        <th> RUT CLIENTE </th>
        <th> LIQUIDACION </th>
    </tr>
    </thead>
    <tbody>
    @foreach($ClientPayer as $item)
    <tr class="tex-center" >
          <td>{{ $item->id }}</td>
          <td>{{ $item->payer->name }}</td>
          <td>{{ $item->payer->rut }}</td>
          <td>{{ $item->feeshistory->last()->rate ?? 0}}</td>
          <td>{{ $item->feeshistory->last()->mora_rate ?? 0 }}</td>
          <td>{{ $item->feeshistory->last()->discount ?? 0 }}</td>
          <td>{{ $item->feeshistory->last()->commission  ?? 0}}</td>
          <td>{{ $item->client->company->rut ?? 'NO INGRESADO ' }}</td>
          <td>{{ $item->SettlementStatus->value }}</td>
    </tr> 
    @endforeach
    </tbody>
</table>