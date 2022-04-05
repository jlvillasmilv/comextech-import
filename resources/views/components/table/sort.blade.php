@if(in_array($field, $orderable))
    @if($sortBy !== $field)

    <div class="flex justify-center text-center items-center space-x-2">
        {{$label }}
        <svg wire:click="sortBy('{{ $field }}')" class="w-6 h-6 cursor-pointer text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
        </svg>
   </div> 

    @elseif($sortBy === $field && $sortDirection == 'desc')

        <div class="flex justify-center text-center items-center space-x-2">
            {{$label }}
            <svg wire:click="sortBy('{{ $field }}')" class="w-4 h-4 fa fa-fw fa-sort-down cursor-pointer text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div> 

    @else

    <div class="flex justify-center text-center items-center space-x-2">
        {{$label }}
        <svg wire:click="sortBy('{{ $field }}')" class="w-4 h-4 fa fa-fw fa-sort-up cursor-pointer text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
            </path>
        </svg>
    </div> 

    @endif
@endif