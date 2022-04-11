<div class="bg-white border border-gray-200 mb-2" x-data="{selected:null}">
    <ul class="shadow-box">                
        <li class="relative border-b border-gray-200">

                <a x-on:click.prevent="selected !== 1 ? selected = 1 : selected = null" 
                    type="button" 
                    class="w-full px-8 py-6 text-left"
                >
                <div class="flex items-center justify-between">
                    <span class="font-bold text-gray-800 dark:text-gray-400">Documentos Finales </span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path></svg>
                </div>
            </a>

            <div class="relative overflow-hidden transition-all max-h-0 duration-700" 
                x-ref="container1"
                 x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                <div class="p-6">



                    <div class="px-2" id="add_to">
                        <div class="sm:flex mb-4">
                            <div class="w-full mt-3 sm:w-1/4 mr-1">
                                <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300">Tipo Documento:</label>
                                <select
                                 id="application_document_file_id" 
                                 class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray ">

                                    @foreach($documents as $id => $name)

                                        <option value="{{ $name }}" {{old('location') == $name ? 'selected' : ''}}>
                                            {{ $name }}
                                        </option>

                                    @endforeach

                                    
                                </select>
                                <span id="application_document_file_idError" class="text-xs text-red-600 dark:text-red-400">
                                    <strong></strong>
                                </span>
                            </div>
                           
                        <div class="w-full mt-3 sm:w-3/4 sm:ml-1">
                            
                            <label class="block text-grey-darker text-sm font-bold mb-2 dark:text-gray-300" > Documento a subir </label>

                            <input type="file"
                              class="form-control
                              block
                              w-full
                              px-3
                              py-1.5
                              text-base
                              font-normal
                              text-gray-700
                              bg-white bg-clip-padding
                              border border-solid border-gray-300
                              rounded
                              transition
                              ease-in-out
                              m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                               placeholder="Dirección Origen" 
                               id="document_file" 
                               onfocus="this.value=''" >                                                          
                            </div>

                           
                            <button
                             id="add"
                             type="button"
                             class="btn-add flex ml-2 px-3 py-2 sm:mt-10 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1400 focus:outline-none focus:shadow-outline-blue" 
                            onclick="addRow('table')"
                             title="Agregar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if (isset($application->applicationFile))
                    <table class="w-full whitespace-no-wrap" id="table">
                        <thead>
                            <tr 
                                class="text-xs font-semibold tracking-wide text-left text-white  uppercase border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800"
                            >
                                <th class="px-4 py-3">Documento</th>
                                <th class="px-4 py-3">Fecha subida</th>
                                <th class="px-4 py-3">acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        
                            @forelse ($application->applicationFile as $file)

                            <tr id="{{$file->id}}" class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">
                                    {{$file->applicationDocumentFile->name}}
                                </td>
                                <td class="px-4 py-3">
                                    {{ date('d-m-Y', strtotime($file->created_at)) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2 text-sm">
                                        <a  href="{{$file->fileStore->disk}}"
                                            target="_blank"
                                            title="{{'Descarga documento '.$file->applicationDocumentFile->name}}"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-1300 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>
    
                                        <button
                                            type="button"
                                            id="{{'bt-del-'.$application->id}}"
                                            data-id="{{ $application->id }}"
                                            title="Eliminar {{$application->code}}"
                                            data-remote="{{ route('applications.destroy', \Crypt::encryptString($application->id)) }}"
                                            class="px-1 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray btn-delete"
                                            aria-label="Delete">
                                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill="#e5494d" fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                                
                            @empty
                                
                            @endforelse
                            
                        </tbody>
                    </table>
                    @endif                 
                   
                </div>
            </div>
        </li>
    </ul>
</div>