<x-app-layout title="Import">

    <div class="container grid px-6 mx-auto">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Direcciones de destino
        </h2>

        <div class="flex justify-between items-end">
            <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Lista de direcciones
            </h4>
            <a  href="{{route('address.create')}}" class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>   
                <span> Nueva registro </span>
            </a>
        </div>
      
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr 
                            class="text-sm font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-900 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3"> Pais </th>
                            <th class="px-4 py-3"> Lugar </th>
                            <th class="px-4 py-3"> Direccion</th>
                            <th class="px-4 py-3"> </th> 
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($data as $address)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                <p class="font-semibold">{{ $address->country->name }}</p>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <div class="flex items-center text-sm">                                 
                                   {{ $address->place }}
                                </div>
                                
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{ substr($address->address, 0, 35) . '...' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                   
                                    <a  
                                    href="{{ route('address.show', base64_encode($address->id)) }}" 
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                       
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20">

                                              <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                             
                                              <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            
                                        </svg>
                                    </a>

                                        <a  href="{{ route('address.edit', base64_encode($address->id)) }}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>


                                    <form action="{{ route('address.destroy', base64_encode($address->id)) }}" method="POST" onsubmit="return confirm('¿Esta Seguro?');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" value="X">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                   <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>

                                         </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="10">No entries found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                
            </div>
              {{ $data->links() }}
        </div>
        <form action="{{ route('address.addPorts') }}" method="POST">
            @csrf
            <div class="flex justify-between items-end">
                <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
                Puertos preferidos
                </h4>
            
                    <div class="w-1/2 mb-2">
                        <select class="select2 " name="port_id[]" multiple="multiple">
                            @forelse ($ports as $port)
                            <option value="{{$port->id}}">{{$port->name}}</option>
                            @empty
                            
                            @endforelse
                        </select>
                    </div>
                    
                    <button
                        id="addPort"
                        class="flex px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>   
                        <span> Asignar puetos </span>
                    </button>
                
            </div>
        </form>
        <div class="container mx-auto">  
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                @forelse (auth()->user()->ports as $port)

                    <div class="max-w-sm rounded overflow-hidden shadow-lg">
                        <div class="px-6 py-4">
                        <div class="font-bold text-gray-600 dark:text-gray-300 text-xl mb-2"> 
                            {{$port->name}} ({{$port->unlocs}})
                        </div>
                        <div class="flex">
                            <span class="text-gray-600 dark:text-gray-300">
                                {{$port->province}} {{$port->country->name}} 
                            </span>
                            <div class="">
                                <form action="{{ route('address.delPorts', $port->id) }}" method="POST" onsubmit="return confirm('¿Esta Seguro?');" style="display: inline-block;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="flex items-center justify-between px-2 py-1 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" value="X">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
            
                                    </button>
                                </form>

                            </div>
                            
                        </div>
                        
                        
                        </div>
                    </div>
                    
                @empty
                    
                @endforelse
              
            </div>
        </div>



    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
(function() {
    $(document).ready(function() {
    $('.select2').select2();
});

})();

</script>

@endsection
</x-app-layout>