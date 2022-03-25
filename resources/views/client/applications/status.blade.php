 <!-- <span class="px-2 py-1 font-semibold leading-tight {{ $application->status->status_color }}  rounded-full dark:text-white dark:bg-green-600">
                                    {{ $application->status->name }}
                                </span>
                                <br>
                                <span class="py-2 font-semibold leading-tight  rounded-full dark:text-white dark:bg-green-600">
                                {{ $application->payment->status }}
                                </span> -->

 <div
     class="flex items-center justify-center leading-tight rounded-lg p-1 border border-gray-400
 {{ $application->status->name == 'Activada' ? 'bg-blue-1000 ' : '' }}  dark:text-white ">

     {!! $application->status->name == 'Activada' ? (!$application->state_process ? "<p class='animate-pulse text-red-300'>Activando</p>" : 'Activada') : 'Activación' !!}
     @if ($application->status->name == 'Activada')
         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
             <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
         </svg>
     @endif
 </div>
 <div
     class="flex items-center justify-center rounded-lg mt-1 p-1 leading-tight border border-gray-400 dark:text-white {{ $application->status->name == 'Activada'? 'bg-gray-200': ($application->status->name == 'Validada'? 'bg-blue-1000': '') }} ">
     {!! $application->status->name == 'Validada' || $application->status->name == 'Activada' ? ($application->status->name == 'Validada' && !$application->state_process ? "<p class='animate-pulse text-red-300'>Validando</p>" : 'Validada') : 'Validación' !!}

     @if ($application->status->name == 'Validada' and $application->state_process)
         <button type="button" data-id="{{ base64_encode($application->id) }}"
             data-msg="Desea validar solicitud {{ $application->code }}" data-remote="{{ route('application.status') }}"
             class="animate-pulse ml-2 leading-5 text-gray-800 dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync-app">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
             </svg>
         </button>
     @endif
 </div>
 <div
     class="flex items-center justify-center rounded-lg mt-1 p-1 leading-tight border border-gray-400 
{{ $application->status->name == 'Borrador' ? ' bg-blue-1000' : ' bg-gray-200' }}">
     Borrador
     @if (!$application->state_process)
         <button title="Ver detalles de Observaciones" data-id="{{ base64_encode($application->id) }}"
             data-remote="{{ route('application.notifications') }}"
             class="float-right animate-pulse ml-2 leading-5 text-red-500 dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-notif-app">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
             </svg>
         </button>
     @endif

     @if ($application->status->name == 'Borrador' and $application->state_process)
         <button type="button" data-id="{{ base64_encode($application->id) }}"
             data-msg="Desea validar solicitud {{ $application->code }}"
             data-remote="{{ route('application.status') }}"
             class="animate-pulse ml-2 leading-5 text-gray-800 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-sync-app">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
             </svg>
         </button>
     @endif
 </div>
