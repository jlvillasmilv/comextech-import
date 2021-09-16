<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Models\{Application,
     Currency, CategoryService,
      CustomAgent, Ecommerce,
       Warehouse, TransCompany,
        ApplicationCondSale,
        Supplier
    };

use App\Http\Controllers\{
    ServicesController
};


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/currencies', function (Request $request) {
    $currencies = Currency::where('status', '=', true)->OrderBy('name')->get();
    return response()->json($currencies, 200);
});

Route::get('/category_services', function (Request $request) {
    $currencies = CategoryService::select('id', 'name', DB::raw("false as selected"))
        ->where('status', '=', true)
        ->where('ind_service', '=', true)
        ->OrderBy('sort')->get();
    return response()->json($currencies, 200);
});

Route::get('/warehouses', function (Request $request) {
    $warehouses = Warehouse::select('id',  DB::raw("CONCAT(name,' - ', address) as address"))
        ->where('status', '=', true)
        ->OrderBy('name')->get();
    return response()->json($warehouses, 200);
});

Route::get('/trans_companies', function (Request $request) {
    $trans_cos = TransCompany::select('id', 'name')
        ->where('status', '=', true)
        ->OrderBy('name')->get();
    return response()->json($trans_cos, 200);
});

Route::get('/suppl_cond_sales', function (Request $request) {
   
    $suppl = ApplicationCondSale::where('status', '=', true)
        ->OrderBy('sort','asc')
        ->with('services')
        ->get();

    return response()->json($suppl, 200);
});

Route::get('/ecommerce', function (Request $request) {
   
    $e = Ecommerce::select('id', 'name')
    ->where('status', '=', true)
    ->OrderBy('sort','asc')
    ->get();
    
    return response()->json($e, 200);
});

Route::get('/provider/{id}', function ($id) {
   
    $provider = Supplier::where('id',$id)->with('supplierAddress')
    ->first();
    
    return response()->json($provider, 200);
})->where('id', '[0-9]+');

Route::get('/convert-currency/{amount}/{from_currency}/{to_currency}', [ServicesController::class, 'convertCurrency']);