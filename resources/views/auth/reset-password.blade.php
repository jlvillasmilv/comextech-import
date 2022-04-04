<x-guest-layout title="Reset Password">
    <x-authentication-card>
        <x-slot name="logo">
            {{-- <x-authentication-card-logo /> --}}
            
        </x-slot>
        <img aria-hidden="true" class="object-scale-down w-full h-full dark:hidden" src="https://user-images.githubusercontent.com/53098149/133094650-88a78162-0bfd-4863-a2d4-b43ff7d7292a.jpg" alt="Office" />
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <!-- <x-label value="Correo Electronico" /> -->
                <x-input type="hidden" class="block mt-1 w-full" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <div class="mt-4">
                <x-label value="Contraseña" />
                <x-input class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label value="Confirmar Contraseña" />
                <x-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="block w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1000 focus:outline-none focus:shadow-outline-blue" type="submit">
                    {{ __('Restablecer contraseña') }}
                </button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
