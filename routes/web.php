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
     Route::post('asupplier/remove', 'App\Http\Controllers\Web\SupplierController@remove')
    ->name('supplier.remove'); 

    // Applications
    Route::resource('applications',  'App\Http\Controllers\Web\ApplicationController');
    
    //Summry Applications
    Route::get('/application-summary/{id}', function ($id) {
   
        $summary = \DB::table('application_summaries as aps')
                    ->join('currencies', 'aps.currency_id', '=', 'currencies.id')
                    ->join('services as s', 'aps.service_id', 's.id')
                    ->where('application_id', $id)
                    ->select('aps.id', 'currencies.code','s.name as description','aps.fee_date','aps.amount', 'aps.amount as amo2' )
                    ->orderBy('aps.id')
                    ->get();
        
        return response()->json($summary, 200);

    })->where('id', '[0-9]+');

    Route::get('/get-application/{id}','App\Http\Controllers\Web\ApplicationController@getApplication')->where('id', '[0-9]+');
    
    // Connect with apis courier service
    Route::post('/get-fedex-rate','App\Http\Controllers\Web\ApplicationController@fedexRate');
    Route::post('/get-dhl-quote','App\Http\Controllers\Web\ApplicationController@dhlQuote');

    Route::get('/test-fedex','App\Http\Controllers\Web\ApplicationController@test');
    Route::get('/get-application-category/{id}','App\Http\Controllers\Web\ApplicationController@getApplicationCategory')->where('id', '[0-9]+');

    Route::post('applications/payment_provider', 'App\Http\Controllers\Web\ApplicationController@paymentProvider')
    ->name('applications.payment.provider'); 

     // Internment Process
    Route::post('internment', 'App\Http\Controllers\Web\ApplicationController@internmentProcesses')
    ->name('applications.internment'); 

     // Bodegaje local "Entrega"
    Route::post('local-warehouse', 'App\Http\Controllers\Web\ApplicationController@localWarehouse');
    
    Route::post('applications/transports', 'App\Http\Controllers\Web\ApplicationController@transports')->name('applications.transports'); 

    Route::resource('company',  'App\Http\Controllers\Web\CompanyController')->except(['destroy','create']);
    Route::resource('address',  'App\Http\Controllers\Web\CompanyAddressController');
    
    Route::get('supplierlist', 'App\Http\Controllers\Web\SupplierController@list');

    Route::resource('custom-agents',  'App\Http\Controllers\CustomAgentController');

    Route::get('agentslist', 'App\Http\Controllers\CustomAgentController@list');
    Route::get('customs_house', 'App\Http\Controllers\CustomAgentController@customsHouse');
  
    //services
    Route::get('/services', [ServicesController::class, 'show'])->name('services.show');
    Route::get('/services/index', [ServicesController::class, 'index'])->name('services.index');
    Route::get('/services/summary/{id}', [ServicesController::class, 'summary'])->name('services.summary');
    Route::get('/services/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');

    //company address
    Route::get('/company/address/all', 'App\Http\Controllers\Web\CompanyController@address')->name('company.address');

    Route::view('dashboard', 'dashboard')->name('dashboard');


    Route::get('markAsRead', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');

    Route::get('show-notifications', 'App\Http\Controllers\HomeController@showNotifications')->name('show.notifications');
    Route::post('/mark-as-read', 'App\Http\Controllers\HomeController@markNotification')->name('markNotification');

    Route::get('/convert-currency-date/{date}/{from_currency}/{to_currency}', [ServicesController::class, 'convertCurrencyDate']);

});


// Factoring route

Route::group(['prefix' => 'factoring', 'as' => 'factoring.', 'namespace' => 'App\Http\Controllers\Factoring', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/payers/export', 'PayerController@export')->name('payers.export');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('clients', 'ClientController');
    Route::resource('clients.credential', 'CredentialStoreController')->only('update', 'store');

    Route::get('/quote', 'QuoteController@index')->name('quote');
    Route::post('quote/anticipate', 'QuoteController@anticipate')->name('quote.anticipate'); 
       //calculate
    Route::post('quote/calculation', 'QuoteController@calc')->name('quote.calculation'); 
    
    Route::resource('applications', 'ApplicationController')->except(['destroy']); 
    
    Route::get('/credentials/{name}', 'CredentialStoreController@index');
    Route::resource('partners', 'PartnerController');
    Route::post('client/password', 'UserController@store'); 
    Route::post('single-file', 'FileStoreClientController@store')->name('single-file');
    Route::get('download-file/{name}', 'FileStoreClientController@show');
    Route::get('libredte', 'ApplicationController@libredte');
    Route::resource('disbursements', 'DisbursementController');
    Route::get ('assignment_contract/{id}', 'PdfController@assignment_contract')->name('assignment.contract');
    Route::get('download-file-validate/{name}', 'FileStoreClientController@validatedFile');

    Route::get('markAsRead', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');

    Route::get('show_notifications', 'HomeController@show_notifications')->name('show.notifications');
    Route::post('/mark-as-read', 'HomeController@markNotification')->name('markNotification');
   
     //fileStore
    Route::post('/file', 'FileStoreController@addFileClient')->name('xml.add'); 
    
    Route::get('ventas/detalle', 'SiiController@ventas_detalle')->name('ventas.detalle');
    Route::get('compras/detalle', 'SiiController@compras_detalle')->name('compras.detalle');
    
});

// end factoring route


// Admin Panel

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('users', 'UserController');
    Route::resource('applications', 'ApplicationController')->except(['create']);
    Route::resources([
        'category_service' => CategoryServiceController::class,
        'currencies'       => CurrencyController::class,
        'clients'          => CompanyController::class,
        'services'         => 'ServicesController',
        'warehouses'       => WarehouseController::class,
        'trans_companies'  => TransCompanyController::class,
        'suppl_cond_sales' => ApplicationCondSaleController::class,
    ]);
    
});
