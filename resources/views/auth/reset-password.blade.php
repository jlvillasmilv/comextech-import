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
                <x-label value="Confirm Contraseña" />
                <x-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
