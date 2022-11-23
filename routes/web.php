<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SetGatwayController;
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


Route::get('/', 'HomeController@index');

Route::get('/ckeditor', 'CkeditorController@index');
Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');

Auth::routes();

Route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function() {

    Route::get('mode/{mode}', [SetGatwayController::class, 'setGatwayMode']);

    /**
     * 3rd party Getway settings
     * */
    Route::controller(WavexpayApiKeyController::class)->prefix('gateway')
    ->group(function () {
        Route::get('list', 'index');
        Route::get('/create', 'createForm');
        Route::post('/create', 'create');
        Route::get('/edit/{id}', 'edit');
        Route::post('/update/{id}', 'update');
    });


    Route::get('/admin', function () {
        return redirect('/home');
    });
    //Dashboard
	Route::get('/home', 'HomeController@index')->name('home');

    //Countries
    Route::get('countries/changestatus', 'CountriesController@changeStatus');
    Route::resource('countries', 'CountriesController');

    //States
    Route::resource('states','StatesController');

    //Users
    Route::get('users/changestatus', 'UserController@changeStatus');
    Route::resource('users','UserController');

    Route::get('profile_update', 'UserController@profile_update')->name('user.profile');
    Route::post('profile_update', 'UserController@store_profile')->name('change.profile');
    Route::get('/profile_update/getStates/{id}', 'UserController@getStates');

    //Change Password
    Route::get('change-password', 'ChangePasswordController@index');
    Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

    //Roles
    Route::resource('roles','RoleController');

    //Payment Templates
    Route::get('payment-templates/changestatus', 'PaymentTemplateController@changeStatus');
    Route::resource('payment-templates','PaymentTemplateController');

    //Email Templates
    Route::resource('email-templates','EmailTemplateController');

    //Pages
    Route::resource('pages','PageController');

    //Merchants
    Route::get('merchants/changestatus', 'MerchantController@changeStatus');
    Route::get('merchants/changespartnertatus', 'MerchantController@changePartnerStatus');
    Route::get('merchant-rewards', 'MerchantController@merchantRewards');
    Route::get('merchants/changerewardvalue', 'MerchantController@changeRewardValue');
    Route::resource('merchants','MerchantController');
    Route::resource('merchant-keys','MerchantKeyController');
    Route::resource('dashboardheader','DashboardHeaderController');
    Route::post('merchants/getmerchantsbykey','MerchantController@getmerchantbykey');
    Route::post('searchmerchant','MerchantController@searchMerchant')->name('searchmerchant');


    //Transactions
    Route::get('payments','TransactionController@payments')->name('payments.index');
    Route::post('payments','TransactionController@payments')->name('searchpayment');
    Route::post('getpaymentdata','TransactionController@getpaymentdata')->name('getpaymentdata');
    //Route::post('searchpayment','TransactionController@searchpayment')->name('searchpayment');
    Route::get('refunds','TransactionController@refunds')->name('refunds.index');
    Route::post('getrefunddata','TransactionController@getrefunddata')->name('getrefunddata');
    Route::post('searchrefund','TransactionController@searchrefund')->name('searchrefund');
    Route::get('batch-refunds','TransactionController@batchrefunds')->name('batch-refunds.index');
    Route::get('orders','TransactionController@orders')->name('orders.index');
    Route::post('getorderdata','TransactionController@getorderdata')->name('getorderdata');
    Route::post('searchorder','TransactionController@searchorder')->name('searchorder');
    Route::get('disputes','TransactionController@disputes')->name('disputes.index');
    Route::post('getdisputedata','TransactionController@getdisputedata')->name('getdisputedata');
    Route::post('searchdispute','TransactionController@searchdispute')->name('searchdispute');


    //Invoice
    Route::get('invoice','InvoiceController@invoices')->name('invoice.index');
    Route::post('getinvoicedata','InvoiceController@getinvoicedata')->name('getinvoicedata');
    Route::get('invoice/{id}','InvoiceController@showInvoice');
    Route::post('searchinvoice','InvoiceController@searchInvoice')->name('searchinvoice');
    Route::get('item','InvoiceController@items')->name('item.index');
    Route::post('getitemdata','InvoiceController@getitemdata')->name('getitemdata');
    Route::get('settlements','SettlementController@settlements')->name('settlements.index');


    // Route::get('customers/changestatus', 'CustomerController@changeStatus');
    // Route::resource('customers','CustomerController');

    // Route::get('branches/changestatus', 'BranchController@changeStatus');
    // Route::resource('branches','BranchController');

    // Route::get('items/changestatus', 'ItemController@changeStatus');
    // Route::get('items/price/{id}', 'ItemController@price');
    // Route::post('items/updateprice/{id}', 'ItemController@updateprice');
    // Route::post('items/getprices', 'ItemController@getprices');
    // Route::resource('items','ItemController');

    // Route::get('services/changestatus', 'ServiceController@changeStatus');
    // Route::resource('services','ServiceController');

    // Route::get('order_statuses/changestatus', 'OrderStatusController@changeStatus');
    // Route::resource('order_statuses','OrderStatusController');

    // Route::get('cost_types/changestatus', 'CostTypeController@changeStatus');
    // Route::resource('cost_types','CostTypeController');


    // Route::resource('costs','CostController');



    #Route::get('orders/{id}', 'OrderController@show');
    // Route::resource('orders','OrderController');
    // Route::get('order-print/{id}','OrderController@order_print')->name('order.print');
    // Route::post('order_payment','OrderController@updatepayment')->name('order.payment');
    // Route::post('order_status','OrderController@updatestatus')->name('order.status');

    // Route::get('cutomers/getcustomer', 'CustomerController@getcustomer');



    // Route::get('order_items', 'ReportController@index')->name('order_items.index');
    // Route::get('payments', 'ReportController@payments')->name('payments.index');
    // Route::get('monthly_statement', 'ReportController@monthly_statement')->name('monthly_statement.index');
    //Route::get('cron', 'ReportController@cron')->name('cron');

    Route::post('getsuccesstransactiongraphdata','HomeController@getSuccessTransactionGraphData');


    Route::get('transactions/payments/status',  [TransactionController::class, 'statusWisePayment'] );


});
