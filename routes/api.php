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

use App\Models\{Currency, CategoryService, CustomAgent, Warehouse, TransCompany, ApplicationCondSale};

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/currencies', function (Request $request) {
    $currencies = Currency::select('id', 'code', DB::raw("CONCAT(name,' (', code,')') as name_code"))
        ->where('status', '=', true)->OrderBy('name')->get();
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


Route::get('/custom_agents', function (Request $request) {
    $custom_agents = CustomAgent::select('id', DB::raw("CONCAT(name,' - ', rate) as name"))
        ->where('status', true)
        ->OrderBy('name')->get();
    return response()->json($custom_agents, 200);
});