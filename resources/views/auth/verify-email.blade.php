<x-guest-layout title="Verfiy Email">
    <x-authentication-card>
        <x-slot name="logo">
            <!-- <x-authentication-card-logo /> -->
            
        </x-slot>
        <img aria-hidden="true" class="object-scale-down w-full h-full dark:hidden" src="https://user-images.githubusercontent.com/53098149/133094650-88a78162-0bfd-4863-a2d4-b43ff7d7292a.jpg" alt="Office" />
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Gracias por registrarte en ComexTech! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibiste el correo electrónico, con gusto te enviaremos otro.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="/email/verification-notification">
                @csrf

                <div>
                    <button class="block w-full px-4 py-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1000 focus:outline-none focus:shadow-outline-blue" type="submit">
                        {{ __('Reenviar correo electrónico') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="/logout">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
