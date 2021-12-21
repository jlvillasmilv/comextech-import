<div class="w-full overflow-x-auto">
    <table id="table" class="w-full whitespace-no-wrap">
        <thead>
            <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Servicio </th>
                <th class="px-4 py-3">Fecha </th>
                <th class="px-4 py-3">Moneda / Monto origen </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @forelse($application->summary as $key => $detail)
            <tr class="text-gray-700 dark:text-gray-400" id="{{$detail->id}}">
        
                <td class="px-4 py-3 text-sm">
                    <input type="hidden" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                     name="detail_id[]"
                     value="{{ isset($detail) ? $detail->id : '' }}" >

                    <p class="font-semibold">{{ $detail->service->name }}</p>
                </td>

                <td class="px-4 py-3 text-sm">
                    <input class="{{ $errors->has('fee_date.'.$key) ? ' border-red-600 ' : '' }} block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
							type="date"
							name="fee_date[]"
                            value="{{ old('fee_date.'.$key, (isset($detail)) && strtotime($detail->fee_date) != false  ? date('Y-m-d', strtotime($detail->fee_date)) : date('Y-m-d')) }}"
							>
                        
                    @if($errors->has('fee_date.'.$key))
                        <span class="text-xs text-red-600 dark:text-red-400">
                           {{ $errors->first('fee_date.'.$key) }}
                        </span>
                    @endif
                </td>

                <td class="px-4 py-3 ">

                        <div class="flex ">
                            <div class="w-1/2 mr-1">
                               
                                <select name="currency_id[]" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray  @error('currency_id.'.$key) is-invalid @enderror">

                                    @foreach($currencies as $id => $name)

                                        @if(isset($detail->currency_id) && $detail->currency_id == $id || old('currency_id.'.$key) == $id)
                                            <option value="{{ $id }}" selected>{{ $name }}</option>
                                        @else
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endif
    
                                    @endforeach
                                </select>


                                @if($errors->has('currency_id.'.$key))
                                    <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('currency_id.'.$key) }}
                                    </span>
                                @endif

                            </div>
                            <div class="w-1/2 ml-1">

                                <input type="number" class=" block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                 name="amount[]"
                                  value="{{ old('amount.'.$key, isset($detail) ? $detail->amount : '') }}">
                   
                                @if($errors->has('amount.'.$key))
                                     <span class="text-xs text-red-600 dark:text-red-400">
                                        {{ $errors->first('amount.'.$key) }}
                                    </span>
                                @endif
                                
                            </div>
                        </div>

                </td>
            </tr>

            @empty
            <tr class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 text-sm" colspan="5">No entries found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>