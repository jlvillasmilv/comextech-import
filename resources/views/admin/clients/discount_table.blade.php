<div class="container grid px-2 mx-auto">
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
    <form  role="form" method="POST" action="{{ route('admin.clients.discount') }}" >
    @csrf

    <input type="hidden" name="company_id" value="{{ $company->id}}">

    <div class="flex justify-between items-end">
        <h4 class="mb-4 text-lg  text-gray-600 dark:text-gray-300">
            Descuento Cliente Courier
        </h4>

        <div class="flex justify-end">
            <button class="flex  px-4 py-2 my-1 mr-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-1300 border border-transparent rounded-lg active:bg-blue-1300 hover:bg-blue-1200 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2h2m3-4H9a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-1m-1 4l-3 3m0 0l-3-3m3 3V3" />
                </svg>
                <span> Guardar </span>
            </button>
        </div>
            
    </div>

        <div class="w-full overflow-x-auto">
            <table  id="table" class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs text-center font-semibold tracking-wide text-left text-white border-b dark:border-gray-700 bg-blue-1300 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Compañia</th>
                        <th class="px-4 py-3">ZN imp A</th>
                        <th class="px-4 py-3">ZN imp B</th>
                        <th class="px-4 py-3">ZN imp C</th>
                        <th class="px-4 py-3">ZN imp D</th>
                        <th class="px-4 py-3">ZN imp E</th>
                        <th class="px-4 py-3">ZN imp F</th>
                        <th class="px-4 py-3">ZN exp A</th>
                        <th class="px-4 py-3">ZN exp B</th>
                        <th class="px-4 py-3">ZN exp C</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($company->user->discounts as $key => $discount)

                <tr class="text-gray-700 dark:text-gray-400 text-xs text-center">
                        <td class="px-1 py-2 text-center">
                            <input type="hidden" name="discount_id[]" value="{{ $discount->id}}">
                            {{ $discount->transCompany->name}}
                        </td>
                        <td class="px-1 py-2 text-center">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="imp_a[]"
                                    value="{{ old('imp_a.'.$key, isset($discount) ? $discount->imp_a : '') }}">
                    
                            @if($errors->has('imp_a.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('imp_a.'.$key) }}
                                </span>
                            @endif

                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="imp_b[]"
                                    value="{{ old('imp_b.'.$key, isset($discount) ? $discount->imp_b : '') }}">
                    
                            @if($errors->has('imp_b.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('imp_b.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="imp_c[]"
                                    value="{{ old('imp_c.'.$key, isset($discount) ? $discount->imp_c : '') }}">
                    
                            @if($errors->has('imp_c.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('imp_c.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="imp_d[]"
                                    value="{{ old('imp_d.'.$key, isset($discount) ? $discount->imp_d : '') }}">
                    
                            @if($errors->has('imp_d.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('imp_d.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="imp_e[]"
                                    value="{{ old('imp_e.'.$key, isset($discount) ? $discount->imp_e : '') }}">
                    
                            @if($errors->has('imp_e.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('imp_e.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="imp_f[]"
                                    value="{{ old('imp_f.'.$key, isset($discount) ? $discount->imp_f : '') }}">
                    
                            @if($errors->has('imp_f.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('imp_f.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="exp_a[]"
                                    value="{{ old('exp_a.'.$key, isset($discount) ? $discount->exp_a : '') }}">
                    
                            @if($errors->has('exp_a.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('exp_a.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="exp_b[]"
                                    value="{{ old('exp_b.'.$key, isset($discount) ? $discount->exp_b : '') }}">
                    
                            @if($errors->has('exp_b.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('exp_b.'.$key) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-1 py-2 text-center ">
                            <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="exp_c[]"
                                    value="{{ old('exp_c.'.$key, isset($discount) ? $discount->exp_c : '') }}">
                    
                            @if($errors->has('exp_c.'.$key))
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    {{ $errors->first('exp_c.'.$key) }}
                                </span>
                            @endif
                        </td>
                        
                    </tr>
                @empty
                    
                @endforelse
                    
                </tbody>
            </table>
            
        </div>
</form>

</div>
</div>