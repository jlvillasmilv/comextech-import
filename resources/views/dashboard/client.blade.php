  <!-- Cards -->
  <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">

    <!-- Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-1000 bg-blue-1300 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                </path>
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Solicitudes
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{auth()->user()->application->count('id')}}
            </p>
        </div>
    </div>
    <!-- Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-blue-1300 bg-blue-1000 rounded-full dark:text-teal-100 dark:bg-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Pendiente
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{auth()->user()->application->where('application_statuses_id',1)->count('id')}}
            </p>
        </div>
    </div>

    <!-- Card -->
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="p-3 mr-4 text-gray-500 bg-gray-200 rounded-full dark:text-red-100 dark:bg-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Rechazadas
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{auth()->user()->application->where('application_statuses_id',5)->count('id')}}
            </p>
        </div>
    </div>
</div>

 <div class="form-group">
        
        <input type="hidden" name="latitude" id="latitude"  />
        <input type="hidden" name="longitude" id="longitude"  />
 
</div>
    <div id="address-map-container" class="md:w-5/6" style="height:400px; ">
        <div class="w-full h-full" id="address-map"></div>
    </div>
@section('scripts')
@parent


<script type="text/javascript">

    (function() {
        // your page initialization code here
        // the DOM will be available here
        initial_map();

    })();

</script>

@endsection