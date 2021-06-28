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
    ServicesController,
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
    
    // Applications
    Route::resource('applications',  'App\Http\Controllers\Web\ApplicationController');

    Route::post('applications/payment_provider', 'App\Http\Controllers\Web\ApplicationController@paymentProvider')
    ->name('applications.payment.provider'); 

     // Internment Process
    Route::post('internment', 'App\Http\Controllers\Web\ApplicationController@internmentProcesses')
    ->name('applications.internment'); 

    Route::post('applications/transports', 'App\Http\Controllers\Web\ApplicationController@transports')->name('applications.transports'); 

    Route::resource('company',  'App\Http\Controllers\Web\CompnayController')->except(['destroy','create']);

    Route::get('supplierlist', 'App\Http\Controllers\Web\SupplierController@list');
  
    //services
    Route::get('/services', [ServicesController::class, 'show'])->name('services.show');
    Route::get('/services/index', [ServicesController::class, 'index'])->name('services.index');
    Route::get('/services/summary/{id}', [ServicesController::class, 'summary'])->name('services.summary');
    Route::get('/services/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');

    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');

});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('currencies', 'CurrencyController');
    Route::resource('users', 'UserController');
    Route::resource('clients', 'CompanyController');
    Route::resource('applications', 'ApplicationController')->except(['create']);
    Route::resource('category_service', 'CategoryServiceController');
    Route::resource('services', 'ServicesController');
    

});
