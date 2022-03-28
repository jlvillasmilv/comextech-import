<?php

use Illuminate\Support\Facades\Route;
use App\Exports\PayersExport;
use Maatwebsite\Excel\Facades\Excel;

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

Route::resource('cotizador',  'App\Http\Controllers\Web\FreightQuotesController');
Route::post('freight-quotes/calculate',  'App\Http\Controllers\Web\FreightQuotesController@freightQuotes'); 

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
   
    Route::resource('supplier',  'App\Http\Controllers\Client\SupplierController');
    Route::post('asupplier/remove', 'App\Http\Controllers\Client\SupplierController@remove')
    ->name('supplier.remove'); 

    // Applications
    Route::resource('applications',  'App\Http\Controllers\Client\ApplicationController');

    Route::get('user-applications/dashboard-map',  'App\Http\Controllers\Client\ApplicationController@dashboardMap');
    
    Route::get('/application-summary/{id}','App\Http\Controllers\Client\ApplicationController@getApplicationSummary')->where('id', '[0-9]+');
    Route::post('set-application-summary','App\Http\Controllers\Client\ApplicationController@setApplicationSummary')->name('application.importUpdateCost');
    
    Route::post('application-status','App\Http\Controllers\Client\ApplicationController@updateStaus')->name('application.status');
    Route::post('application-notifications','App\Http\Controllers\Client\ApplicationController@notifications')->name('application.notifications');
    
    Route::post('application-generate-order','App\Http\Controllers\Client\PaymentApplicationController@generateOrder')->name('application.generate.order');
    Route::get('/get-appayment/{id}','App\Http\Controllers\Client\PaymentApplicationController@paymentProcces')->where('id', '[0-9]+');
    Route::get('/generate-code/{id}','App\Http\Controllers\Client\PaymentApplicationController@generateCode')->where('id', '[0-9]+');

    // Get condition sale
    Route::get('/suppl_cond_sales', function (Request $request) {
   
        $suppl = App\Models\ApplicationCondSale::where('status', '=', true)
            ->with('services')
            ->get(['id','name','description','sort']);
    
        return response()->json($suppl, 200);
    });

    Route::resource('account-statement',  'App\Http\Controllers\Client\ApplicationPaymentController'); 

    

    /* get sea port by code country status
    ** id number or code country
    ** flag indicate if code country o id addres supplier
    */
    Route::get('/ports-supplier/{id}/{type}','App\Http\Controllers\Client\TransportsControllers@portSupplier')->where('id', '[0-9]+');
    Route::get('/ports/{type}','App\Http\Controllers\Client\TransportsControllers@ports')->name('ports')->where('type', '[A-Z]+');
    Route::get('/ports-user/{type}','App\Http\Controllers\Client\TransportsControllers@portUser')->where('type', '[A-Z]+')->name('port.user');

    Route::post('applications/transports', 'App\Http\Controllers\Client\TransportsControllers@add')->name('applications.transports'); 

    // Connect with apis courier service
    Route::post('/get-fedex-rate','App\Http\Controllers\Client\TransportsControllers@fedexRate');
    Route::post('/get-dhl-quote','App\Http\Controllers\Client\TransportsControllers@dhlQuote');
    Route::get('/test-courier','App\Http\Controllers\Client\TransportsControllers@test');

    Route::get('/get-application/{id}','App\Http\Controllers\Client\ApplicationController@getApplication')->where('id', '[0-9]+');
    
    Route::post('applications/payment_provider', 'App\Http\Controllers\Client\ApplicationController@paymentProvider')
    ->name('applications.payment.provider'); 

     // Internment Process
    Route::post('internment', 'App\Http\Controllers\Client\ApplicationController@internmentProcesses')
    ->name('applications.internment'); 

    Route::get('download/{id}/{type}', 'DisbursementController@downloadAsset')->name('download');

     // Bodegaje local "Entrega"
    Route::post('local-warehouse', 'App\Http\Controllers\Client\ApplicationController@localWarehouse');


    Route::resource('company',  'App\Http\Controllers\Client\CompanyController')->except(['destroy','create']);
   
    Route::resource('address',  'App\Http\Controllers\Client\CompanyAddressController');
    Route::post('address/add-port', 'App\Http\Controllers\Client\CompanyAddressController@addPorts')->name('address.addPorts'); 
    Route::post('address/del-port/{id}', 'App\Http\Controllers\Client\CompanyAddressController@delPorts')->name('address.delPorts');
    
    Route::get('supplierlist', 'App\Http\Controllers\Client\SupplierController@list');

    Route::resource('custom-agents',  'App\Http\Controllers\Client\CustomAgentController');

    Route::get('agentslist', 'App\Http\Controllers\Client\CustomAgentController@list');
    Route::get('customs_house', 'App\Http\Controllers\Client\CustomAgentController@customsHouse');
  
    //services
    Route::get('/services', [ServicesController::class, 'show'])->name('services.show');
    Route::get('/services/index', [ServicesController::class, 'index'])->name('services.index');
    Route::get('/services/summary/{id}', [ServicesController::class, 'summary'])->name('services.summary');
    Route::get('/services/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');
    Route::get('download/{id}/{type}', [ServicesController::class, 'downloadAsset'])->name('download.file.internment');

    
    //company address
    Route::get('/company/address/all', 'App\Http\Controllers\Client\CompanyController@address')->name('company.address');

    Route::resource('bank-accounts', 'App\Http\Controllers\Client\BankAccountController'); 

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('markAsRead', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');

    Route::get('show-notifications', 'App\Http\Controllers\HomeController@showNotifications')->name('show.notifications');
    Route::post('/mark-as-read', 'App\Http\Controllers\HomeController@markNotification')->name('markNotification');

    Route::post('/notifications-transport', 'App\Http\Controllers\Client\TransportsControllers@sendNotification');

    Route::get('/convert-currency-date/{date}/{from_currency}/{to_currency}', [ServicesController::class, 'convertCurrencyDate']);
    Route::get('/custom-convert-currency/{amount}/{from_currency}', [ServicesController::class, 'customsConvertCurrency']);

    Route::get('settings', function(){
       
        $sett = \DB::table('settings')
            ->first([
                'min_rate_fcl',
                'min_rate_lcl',
                'min_rate_aereo',
                'min_rate_transp',
                'doc_mgmt_fcl',
                'loan_fcl',
                'gate_in_fcl',
                'doc_mgmt_lcl', 
                'doc_visa_lcl', 
                'dispatch_lcl'
                ]);
    
        return response()->json($sett, 200);

    });

    Route::resource('users-company', 'App\Http\Controllers\Client\UserController')->only('index','update', 'store'); 

});

// Factoring route

Route::group(['prefix' => 'factoring', 'as' => 'factoring.', 'namespace' => 'App\Http\Controllers\Factoring', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/payers/export', 'PayerController@export')->name('payers.export');
    
    Route::resource('profile', 'ProfileController');
    Route::resource('clients/credential', 'CredentialStoreController')->only('index','update', 'store');

    Route::get('/quote', 'QuoteController@index')->name('quote');
    Route::get('/quotation', 'QuoteController@quotation')->name('quotation');
    
    Route::post('quote/anticipate', 'QuoteController@anticipate')->name('quote.anticipate'); 
       //calculate
    Route::post('quote/calculation', 'QuoteController@calc')->name('quote.calculation'); 
    
    Route::resource('applications', 'ApplicationController')->except(['destroy']);   
    
    Route::resource('partners', 'PartnerController');

    Route::post('single-file', 'FileStoreClientController@store')->name('single-file');
    Route::get('download-file/{name}', 'FileStoreClientController@show');
    Route::get('libredte', 'ApplicationController@libredte');
    Route::resource('disbursements', 'DisbursementController');
    Route::get ('assignment_contract/{id}', 'PdfController@assignment_contract')->name('assignment.contract');
    Route::get('download-file-validate/{name}', 'FileStoreClientController@validatedFile');

    Route::get('show_notifications', 'HomeController@show_notifications')->name('show.notifications');
    Route::post('/mark-as-read', 'HomeController@markNotification')->name('markNotification');
   
    //fileStore
    Route::post('file', 'FileStoreController@addFileClient')->name('xml.add'); 

    Route::get('ventas/detalle', 'SiiController@ventas_detalle')->name('ventas.detalle');
    Route::get('compras/detalle', 'SiiController@compras_detalle')->name('compras.detalle');
    
});

// end factoring route

// Admin Panel

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('users', 'UserController');
    Route::resource('applications', 'ApplicationController')->except(['create']);
    Route::get('applications/tracking/{id}', 'ApplicationController@tracking')->name('applications.tracking');
    Route::resources([
        'category_service' => CategoryServiceController::class,
        'currencies'       => CurrencyController::class,
        'clients'          => CompanyController::class,
        'services'         => 'ServicesController',
        'warehouses'       => WarehouseController::class,
        'trans_companies'  => TransCompanyController::class,
        'suppl_cond_sales' => ApplicationCondSaleController::class,
        'customs-exchange-rates' => CustomsExchangeRateController::class
    ]);
    
    Route::post('clients/excutive/', 'CompanyController@excutive')->name('clients.excutive');
    Route::post('clients/discount', 'CompanyController@clientDiscount')->name('clients.discount');
    Route::get('clients/legal/{id}', 'CompanyController@legal')->name('clients.legal');
    Route::resource('settings', 'SettingController')->except(['destroy','create']);
    Route::resource('freight-quotes',  'FreightQuotesController')->except(['destroy','create']);
    Route::resource('transport-modes', 'TransportModesController')->except(['destroy','create']);    
});

//admin factoring
Route::group(['prefix' => 'admin/factoring', 'as' => 'admin.factoring.', 'namespace' => 'App\Http\Controllers\Admin\Factoring', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('applications', 'ApplicationController')->except(['destroy','create']);
    Route::resource('disbursements', 'DisbursementController')->except(['destroy','create']);
    Route::resource('fee_history', 'FeesHistoryController')->except(['destroy']);
    
    Route::get('fee_edit/fee_history/{id}', 'FeesHistoryController@fee_edit')->name('fee_edit');
    Route::post('fee_store/fee_history/', 'FeesHistoryController@fee_store')->name('fee_store');

    Route::get('download/{id}/{type}', 'DisbursementController@downloadAsset')->name('download');

    Route::get('/payers/export', 'PayerController@export')->name('payers.export');
    Route::post('/feehistory/import', 'FeesHistoryController@import')->name('feehistory.import.excel');

    Route::get('ventas/detalle', 'SiiController@ventas_detalle')->name('ventas.detalle');
    Route::get('compras/detalle', 'SiiController@compras_detalle')->name('compras.detalle');
    
});


//admin rates

Route::group(['prefix' => 'admin/rates', 'as' => 'admin.rates.', 'namespace' => 'App\Http\Controllers\Admin\Rates', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('air', 'RateAirController');
    Route::resource('fcl', 'RateFCLController');
    Route::post('fcl-file-import', 'RateFCLController@fileImport')->name('fcl.file.import');

    Route::resource('lcl', 'RateLCLController');
    Route::post('lcl-file-import', 'RateLCLController@fileImport')->name('lcl.file.import');
    
    Route::resource('local-transport', 'LocalTransportController');
    Route::resource('local-spending', 'LocalSpendingController');

});