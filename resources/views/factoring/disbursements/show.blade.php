<x-app-layout title="Detalles de la Solicitud">

 
  @php
    $invoices_sii    = $applications->disbursement->assign_invoices_sii;
    $tax_folder      = $applications->disbursement->tax_folder;
    $declaration_sii = $applications->disbursement->tax_declaration_sii;
    $tax_debt        = $applications->disbursement->tax_debt;
    $annex           = $applications->disbursement->assignment_annex;
    $accountStatus = !isset($bankAccounts)? 0:1;
    $size = 12;  
    $sii = auth()->user()->credentialStores()->where('provider_name', 'SII')->first();

  @endphp


  <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        <a href="{{route('factoring.disbursements.index')}}">Desembolsos</a> 
    </h2>

      {{-- clients who have SII keys, premium clients  --}}
      @empty(!$sii)   
        @if ($applications->disbursement->status === 'PENDIENTE' || $applications->disbursement->status === 'RECHAZADO') 
          @include('factoring.disbursements.requirements_sii')
        @endif
      @endempty

    @if($applications->disbursement->status === 'PENDIENTE' || $applications->disbursement->status === 'RECHAZADO')
    {{--invoices uploaded in XML way --}}
      @empty($sii)
        @php
            $size = 9;
        @endphp
        @include('factoring.disbursements.requirements')
      @endempty
    @endif

    <div class="grid gap-6 mb-8 ">
      <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <p class="font-semibold  dark:text-white ">Desembolso #: {{str_pad($applications->disbursement->id, 6, '0', STR_PAD_LEFT) }} </p>
        <p class="font-semibold  dark:text-white ">Estado: {{$applications->disbursement->status}} </p>
        
          <div class="w-full overflow-x-auto">
              <table  id="table" class="w-full whitespace-no-wrap">
                  <thead>
                      <tr
                          class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                      
                          <th class="px-4 py-3"> <b>Factura</b> <br> Folio / Emisión </th>
                          <th class="px-4 py-3"> <strong>Pagador</strong><br>Nombre / RUT </th>
                          <th class="px-4 py-3"> <strong>Tasa</strong> <br> Fcto / Mora </th>
                          <th class="px-4 py-3"> <strong>Montos</strong> <br> Factura/ Desembolso</th>
                          <th class="px-4 py-3"> <strong>Costos</strong> <br> Comisión/ Dif. Precio</th>
                          <th class="px-4 py-3"> <strong>Operación</strong> <br> Fcto/ Excedentes</th>
                          <th class="px-4 py-3"> Vencimiento</th>
                          <th class="px-4 py-3"> Mora</th>
                      </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @include('factoring.disbursements.row')
                  </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
{{-- Input hidden --}}
<input type="hidden" id="status_view" value="{{$applications->disbursement->status_view}}">
<input type="hidden" id="status" value="{{$applications->disbursement->status}}">

@section('scripts')
@parent

<script>

  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
  var status_view = document.getElementById("status_view").value;
  var status = document.getElementById("status").value;
  var bank_accounts_id = $('#bankAccounts').val();
  console.log(status_view)
  if(status === 'DESEMBOLSADO' &&  status_view == '0'){
    Swal.fire({
      title: 'Felicitaciones! Tu dinero fue desembolsado.',
      html:' Los Fondos fueron abonados a tu Cuenta Bancaria  ',
      imageUrl:  "{{ asset('images/manos.png')}}",
      imageWidth: 200,
      imageHeight: 200,
      confirmButtonText:
          '  Verificado!',
    }).then((result) => {
      if (result.isConfirmed) {
        axios.put( "{{ route('factoring.disbursements.update',$applications->disbursement->id) }}",{'bankAccounts': bank_accounts_id, status_view:true});
      }  
    })
  }

  $(".upload").on('click', function() {
    var type = $(this).data('remote');
    var formData = new FormData();
    var files =   $('#file'+type)[0].files[0];
    var route = type !== 'contrato' ? "{{route('factoring.single-file')}}" : "{{route('factoring.disbursements.store')}}";
   if(files !== undefined){
      Toast.fire({
      icon: 'warning',
      title: 'Estamos almacenando tu archivo, un momento!'
      })
    formData.append('file',files);
    formData.append('type', type);
    formData.append('disbursement_id', {{$applications->disbursement->id}});
    formData.append( "_token", "{{ csrf_token() }}");
    $.ajax({
        url: route,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
              Toast.fire({
              icon: 'success',
              title: 'Archivo subido! Entrara en revision'
              })
        }
    });
  }else{
      Toast.fire({
          icon: 'info',
          title: 'Seleccione el archivo desde tu ordenandor!'
      })
  }
    
});
      
  $('#addAccount').on('click', function (e) { 
    console.log(11)
          e.preventDefault();
          var bank_accounts_id = $('#bankAccounts').val();
          let payload = {'bank_accounts_id': bank_accounts_id}
          axios.put( "{{ route('factoring.disbursements.update',$applications->disbursement->id) }}",payload).then(response => {
              $('#FormbankAccounts').hide();
              document.getElementById('rowAccount').innerHTML= "<h6 class='tex-center text-uppercase'>"+response.data.name +" <br> "+ "Numero:"+response.data.number+"<h6>";
          });
          
  });

</script>

@endsection
 
</x-app-layout>

<style >
  .file-select {          
    position: relative;
    display: inline-block;
  }
  
  .file-select::before {
    background-color:#C8C8C8;
    color:white;
    display: flex;            
    justify-content: center;
    align-items: center;
      radius: 4px;
      content: 'Cargar Archivo '; /* testo por defecto */
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;                
  }
  .team {
      position: relative;
    display: inline-block;; /* the default for span */
  }
  
  .file-select input[type="file"] {
    opacity: 0;
    width: 79px;
    height: 30px;
    display: inline-block;            
  }
  
  #src-file1::before {
    content: 'Seleccionar';
  }
  
 
</style>
 
