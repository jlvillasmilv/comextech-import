<div class="flex space-x-1 justify-around">
    <div class="flex items-center space-x-4 text-sm">
        <a  href="{{ route($route.'show', [$id]) }}" 
            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
            aria-label="Show">
           
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20">

                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                 
                  <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                
            </svg>
        </a>

        <a  href="{{ route($route.'edit', [$id]) }}"
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-gray-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                aria-label="Edit">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                    </path>
            </svg>
        </a>

    </div>


</div>
