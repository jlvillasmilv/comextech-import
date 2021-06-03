<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\{
    ImportsController,
    SupplierController
};


Route::get('/', function () {
    return view('auth.login');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    
    Route::resource('supplier',  'App\Http\Controllers\Web\SupplierController');
  
    Route::get('/imports', [ImportsController::class, 'index'])->name('imports.index');

    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');
    Route::view('calendar', 'calendar')->name('calendar');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('currencies', 'CurrencyController');
    Route::resource('users', 'UserController');
    Route::resource('clients', 'CompanyController');

});
