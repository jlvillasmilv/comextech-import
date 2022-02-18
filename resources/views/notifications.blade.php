<x-app-layout title="Notificaciones">
    <div class="container grid px-6 mx-auto">
        <!-- Big section cards -->
        <h4 class="my-4  text-lg font-semibold text-gray-600 dark:text-gray-300">
            Notificaciones
        </h4>
         @if (auth()->user())
            @forelse ($notifications as $notification)
		        <div class="px-4 py-1 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 alert alert-secondary" role="alert">
		            <p class="text-sm text-gray-600 dark:text-gray-400">
		                {{ $notification->data['title'] }}
		            </p>
		            <p class="text-sm text-gray-600 dark:text-gray-400">
		                {{ $notification->data['description'] }} | {{ $notification->created_at->diffForHumans() }}
		            </p>
		             <button type="submit" class="mark-as-read btn btn-sm btn-dark" data-id="{{ $notification->id }}">Marcar leida</button>
		        </div>
		    @if ($loop->last)
                        {{-- <a href="#" id="mark-all">Marcar todo como leido</a> --}}
                    @endif
                    
                    @empty
                        No hay notificaciones                 
            @endforelse    
        @endif          

        
    </div>


@section('scripts')
@parent
<script type="text/javascript">
 
  $(function(){
    $('.mark-as-read').click(function(){
      let id = $(this).data('id');

        axios.post("{{ route('markNotification') }}", {
		    id
		  })
		  .then(function (response) {
		  	//console.log(response);
		  	$(this).parents('div.alert').remove();
		    
		  })
		  .catch(function (error) {
		    console.log(error);
		  });

      
    });

    $('#mark-all').click(function(){
      let request = sendMarkRequest();

      request.done(() => {
        $('div.alert').remove();
      })
    });
  });
</script>
@endsection
</x-app-layout>
