<x-guest-layout title="Login">
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-scale-down w-full h-full dark:hidden" src="https://user-images.githubusercontent.com/53098149/133094650-88a78162-0bfd-4863-a2d4-b43ff7d7292a.jpg" alt="Office" />
                 </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <!-- <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Login
                        </h1> -->
                        @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">Algo salió mal.</div>

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
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Correo electrónico</span>
                                <x-jet-input class="form-input rounded-md shadow-sm block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 hover:border-blue-1000 focus:border-blue-1000 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="ejemplo@ejemplo.com" type="email" name="email" value="{{ old('email') }}" required autofocus />
                            </label>
                            <label class="block mt-4 text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Contraseña</span>
                                <input class="form-input rounded-md shadow-sm block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 hover:border-blue-1000 focus:border-blue-1000 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="***************" type="password" name="password" required autocomplete="current-password" />
                            </label>
                            <label class="block mt-4 text-sm">
                                <input type="checkbox" class="form-checkbox" name="remember"> <span class="ml-1 text-gray-700 dark:text-gray-400">{{ __('Recordarme') }}</span>
                            </label>
                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1000 focus:outline-none focus:shadow-outline-blue" type="submit">
                              {{ __('Login') }}
                            </button>
                        </form>

                        <p class="mt-4">
                            <a class="text-sm font-medium text-blue-1100 dark:text-blue-400 hover:underline" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </p>

                        {{-- <p class="mt-4">
                            <a class="text-sm font-medium text-blue-1100 dark:text-blue-400 hover:underline" href="{{ route('register') }}">
                               ¿No tienes cuenta?
                            </a>
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>