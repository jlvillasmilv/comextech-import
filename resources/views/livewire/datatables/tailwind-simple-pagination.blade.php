<div class="flex justify-between">
<!-- Previous Page Link -->
@if ($paginator->onFirstPage())
<div class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple">
    <svg class="w-4 h-4 fill-current" aria-hidden="true"
    viewBox="0 0 20 20">
    <path
         d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
        clip-rule="evenodd" fill-rule="evenodd"></path>
    </svg>
</div>
@else
<button wire:click="previousPage" class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
     aria-label="Previous">
     <svg class="w-4 h-4 fill-current" aria-hidden="true"
            viewBox="0 0 20 20">
            <path
                 d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd" fill-rule="evenodd"></path>
        </svg>
</button>
@endif


<!-- Next Page pnk -->
@if ($paginator->hasMorePages())
<button wire:click="nextPage" class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
aria-label="Next">
    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
        <path
             d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" fill-rule="evenodd"></path>
    </svg>
</button>
@else
<div class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple">
    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
        <path
             d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" fill-rule="evenodd"></path>
    </svg>
</div>
@endif
</div>
