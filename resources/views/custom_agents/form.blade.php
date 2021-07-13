<x-app-layout title="Import">
    <div class="container px-6 mx-auto ">
        <h2 class="mt-5   text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <a href="{{route('supplier.index')}}">Proveedores</a>  
        </h2>
        <div class="flex justify-center px-6 m-auto my-2 ">
            <div class=" w-2/3 mx-3 px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800    ">
                <h3 class="my-4  font-semibold text-gray-700 dark:text-gray-200">
                    Nuevo Proveedor
                </h3>
                <form class="form-horizontal" role="form" method="POST" action="{{ isset($supplier) ? route('supplier.update', $supplier->id) : route('supplier.store') }}" >
                    @csrf
                     @if(isset($supplier))
                       @method('PUT')
                    @endif
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Nombre</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Empresa" name="name" value="{{ old('name', isset($supplier) ? $supplier->name : '') }}" max="100" required="">
                    @if($errors->has('name'))
                             <span class="text-xs text-red-600 dark:text-red-400">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Banco</span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Cuenta Bancaria" name="bank" value="{{ old('bank', isset($supplier) ? $supplier->bank : '') }}" max="100" required="">
	                 @if($errors->has('bank'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('bank') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> ISIN </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder=" Número de identificación de valores internacionales
                    "  name="isin" value="{{ old('isin', isset($supplier) ? $supplier->isin : '') }}" max="100" required="">
	            @if($errors->has('isin'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('isin') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Direccion Postal" name="address" value="{{ old('address', isset($supplier) ? $supplier->address : '') }}" max="100" required="">
	                @if($errors->has('address'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('address') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> IBAN </span>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Código Internacional de Cuenta Bancaria" name="iban" value="{{ old('iban', isset($supplier) ? $supplier->iban : '') }}" max="100" required="">
	                @if($errors->has('iban'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('iban') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Direccion de Correo </span>
                    <input type="email" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Origen de importacion" name="email" value="{{ old('email', isset($supplier) ? $supplier->email : '') }}" max="100" required="">
	                @if($errors->has('email'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('email') }}
		                </span>
	                @endif
                </label>
                <label class="block text-sm my-3">
                    <span class="text-gray-700 dark:text-gray-400"> Telefono </span>
                    <input type="text" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Origen de importacion" name="phone" value="{{ old('phone', isset($supplier) ? $supplier->phone : '') }}" max="100" required="">
	                @if($errors->has('phone'))
		             	<span class="text-xs text-red-600 dark:text-red-400">
		                    {{ $errors->first('phone') }}
		                </span>
	                @endif
                </label>
                <div class="flex  justify-start">
                        <button class="flex  px-5 py-2  text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                                </svg>
                            <span> Guardar </span>
                        </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>