@props(['submit'])

<div {{ $attributes->merge(['class' => 'mb-4 bg-white rounded-lg shadow-md dark:bg-gray-800']) }}>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="{{ $submit }}">
            <div class="overflow-hidden">
                <div class="px-4 py-2 sm:p-6">
                    {{-- <div class="grid grid-cols-6 gap-6"> --}}
                    <div class="">
                        {{ $form }}
                    </div>
                </div>

                @if (isset($actions))
                <div class="flex items-center px-4 pt-3 pb-6 sm:px-6">
                    {{ $actions }}
                </div>
                @endif
            </div>
        </form>
    </div>
</div>