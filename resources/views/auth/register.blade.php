<x-guest-layout title="Register">
    <div class="flex items-center min-h-screen p-2 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-scale-down w-full h-full dark:hidden" src="https://user-images.githubusercontent.com/53098149/133094650-88a78162-0bfd-4863-a2d4-b43ff7d7292a.jpg" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="{{asset('img/create-account-office-dark.jpeg')}}" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Crear una cuenta
                        </h3>
                        @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">...</div>

                            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Nombre y apellido</span>
                                <span class="text-red-700 dark:text-red-400">(*)</span>
                                <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Juan Soto" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Correo electrónico</span>
                                <span class="text-red-700 dark:text-red-400">(*)</span>
                                <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ejemplo@ejemplo.com" type="email" name="email" :value="old('email')" required />
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Numero identificacion fiscal</span>
                                <span class="text-red-700 dark:text-red-400">(*)</span>
                                <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="000000-0" type="text" name="tax_id" :value="old('tax_id')" required  maxlength="100"/>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Nombre empresa</span>
                                <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Nombre empresa" type="text" id="companyName" name="company_name" :value="old('company_name')"  maxlength="100"/>
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Contraseña</span>
                                <span class="text-red-700 dark:text-red-400">(*)</span>
                                <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="***************" type="password" name="password" required autocomplete="new-password" />
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">
                                    Confirmar contraseña
                                </span>
                                <span class="text-red-700 dark:text-red-400">(*)</span>
                                <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="***************" type="password" name="password_confirmation" required autocomplete="new-password" />
                            </label>


                            <x-jet-input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"  type="hidden" id="country" name="country" />
                            

                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1000 focus:outline-none focus:shadow-outline-blue" type="submit">
                                {{ __('Register') }}
                            </button>
                        </form>

                        <p class="mt-4">
                            <a class="text-sm font-medium text-blue-1100 dark:text-blue-400 hover:underline" href="{{ route('login') }}">
                                ¿Ya tienes una cuenta?
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
@parent

<script>
  function recordData (data) {
    el = document.getElementById("country").value = data.country;
  }
</script>
<script src="https://ipinfo.io/json?token=95f90ffda2dc97&callback=recordData"></script>

@endsection
</x-guest-layout>