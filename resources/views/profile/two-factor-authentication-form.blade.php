<x-action-section>
    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-300">
            @if ($this->enabled)
            {{ __('Ha habilitado la autenticación de dos factores.') }}
            @else
            {{ __('No ha habilitado la autenticación de dos factores.') }}
            @endif
        </h3>

        <div class="max-w-xl mt-3 text-sm text-gray-600 dark:text-gray-400">
            <p>
                {{ __('Cuando la autenticación de dos factores está habilitada, se le solicitará un token seguro y aleatorio durante la autenticación. Puede recuperar este token de la aplicación Google Authenticator de su teléfono.') }}
            </p>
        </div>

        @if ($this->enabled)
        @if ($showingQrCode)
        <div class="max-w-xl mt-4 text-sm text-gray-600 dark:text-gray-400">
            <p class="font-semibold">
                {{ __('La autenticación de dos factores ahora está habilitada. Escanee el siguiente código QR usando la aplicación de autenticación de su teléfono.') }}
            </p>
        </div>

        <div class="mt-4">
            {!! $this->user->twoFactorQrCodeSvg() !!}
        </div>
        @endif

        @if ($showingRecoveryCodes)
        <div class="max-w-xl mt-4 text-sm text-gray-600 dark:text-gray-400">
            <p class="font-semibold">
                {{ __('Guarde estos códigos de recuperación en un administrador de contraseñas seguro. Se pueden usar para recuperar el acceso a su cuenta si se pierde su dispositivo de autenticación de dos factores.') }}
            </p>
        </div>

        <div class="grid max-w-xl gap-1 px-4 py-4 mt-4 font-mono text-sm bg-gray-100 rounded-lg">
            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
            @endforeach
        </div>
        @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
            <x-button type="button" wire:click="enableTwoFactorAuthentication" wire:loading.attr="disabled">
                {{ __('Habilitado') }}
            </x-button>
            @else
            @if ($showingRecoveryCodes)
            <x-secondary-button class="mr-3" wire:click="regenerateRecoveryCodes">
                {{ __('Regenerar códigos de recuperación') }}
            </x-secondary-button>
            @else
            <x-secondary-button class="mr-3" wire:click="$toggle('showingRecoveryCodes')">
                {{ __('Mostrar códigos de recuperación') }}
            </x-secondary-button>
            @endif

            <x-danger-button wire:click="disableTwoFactorAuthentication" wire:loading.attr="disabled">
                {{ __('Desactivar') }}
            </x-danger-button>
            @endif
        </div>
    </x-slot>
</x-action-section>