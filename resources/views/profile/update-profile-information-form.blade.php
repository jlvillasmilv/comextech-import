<x-form-section submit="updateProfileInformation">
        <x-slot name="form">
            <div class="sm:flex">
            <!-- Profile Photo -->
            <div class="w-auto sm:w-1/2">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                    <!-- Profile Photo File Input -->
                    <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                            photoName = $refs.photo.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                photoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.photo.files[0]);
                                    " />
    
                    <x-label for="photo" value="Imagen de Perfil" />
    
                    <!-- Current Profile Photo -->
                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="object-cover w-20 h-20 rounded-full">
                    </div>
    
                    <!-- New Profile Photo Preview -->
                    <div class="mt-2" x-show="photoPreview">
                        <span class="block w-20 h-20 rounded-full" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
    
                    <x-secondary-button class="mt-2" type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Seleccione una foto') }}
                    </x-secondary-button>
    
                    <x-input-error for="photo" class="mt-2" />
                </div>
                @endif
            </div>
            <div class="w-auto sm:w-1/2">
                <!-- Name -->
                <div class="col-span-6 sm:col-span-4 my-4 sm:my-0">
                    <x-label for="name" value="Nombre" />
                    <x-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autocomplete="name" />
                    <x-input-error for="name" class="mt-2" />
                </div>
    
                <!-- Email -->
                <div class="col-span-6 sm:col-span-4 mt-4 sm:mt-6">
                    <x-label for="email" value="Correo Electrónico" />
                    <x-input id="email" type="email" class="block w-full mt-1" wire:model.defer="state.email" />
                    <x-input-error for="email" class="mt-2" />
                </div>
            </div>
        </div>
        </x-slot>


    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button>
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>