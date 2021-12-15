<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($errors->has('file'))
        <span class="text-xs text-red-600 dark:text-red-400">
            {{ $errors->first('file') }}
        </span>
    @endif
    <div class="flex justify-center">
        <div class="mt-3 w-96">
        
          <input class="form-control
          block
          w-full
          text-sm
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
          accept=".csv"
          id="formFileSm"
          type="file"
          name="file" 
           >
          
        </div>
        <button class="flex  px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>   
            <span>Enviar </span>
        </button>
        <button type="button" id="import_file_info" class="flex px-2 py-2 m-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray btn-file"
        data-remote="{{asset($file)}}"
         title="Informacion sobre documento a subir">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>   
        </button>
      </div>
</form>

