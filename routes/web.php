<?php

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

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/register/account', function () {
    return view('register');
})->name('registerPage');

Auth::routes();

// Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::get('auth/{provider}','Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback','Auth\LoginController@handleProviderCallback');

Route::group(['middleware'=>['auth','CheckRole']],function(){
	Route::post('/users/update',['as'=>'updateUsers','uses'=>'AdminController@updateUsers']);

});

Route::group(['middleware'=>'auth'],function(){

	Route::get('material',['as'=>'materialIndex','uses'=>'MaterialController@index']);
	Route::get('material/create',['as'=>'materialPage','uses'=>'MaterialController@create']);
	Route::post('material/new',['as'=>'createMaterial','uses'=>'MaterialController@new']);
	Route::get('material/search',['as'=>'searchMaterial','uses'=>'MaterialController@search']);
	Route::get('material/find',['as'=>'findMaterialInfo','uses'=>'MaterialController@findInfo']);
	Route::get('material/view/{material_number}',['as'=>'viewMaterial','uses'=>'MaterialController@view']);
	Route::post('material/update',['as'=>'updateMaterial','uses'=>'MaterialController@update']);
	Route::post('material/delete',['as'=>'deleteMaterial','uses'=>'MaterialController@delete']);
	
	//Vendor
	Route::get('vendor/create',['as'=>'vendorPage','uses'=>'VendorController@create']);
	Route::post('vendor/createnew',['as'=>'createVendor','uses'=>'VendorController@new']);
	Route::get('vendor',['as'=>'vendorIndex','uses'=>'VendorController@index']);
	Route::get('vendor/search',['as'=>'searchVendor','uses'=>'VendorController@search']);
	Route::get('vendor/find',['as'=>'findVendorInfo','uses'=>'VendorController@findInfo']);
	Route::get('vendor/view/{vendor_number}',['as'=>'viewVendor','uses'=>'VendorController@view']);
	Route::post('vendor/update',['as'=>'updateVendor','uses'=>'VendorController@update']);
	Route::post('vendor/delete',['as'=>'deleteVendor','uses'=>'VendorController@delete']);

	//Purchase
	Route::get('purchase/create',['as'=>'purchasePage','uses'=>'PurchaseController@create']);
	Route::post('purchase/createnew',['as'=>'createPurchase','uses'=>'PurchaseController@new']);
	Route::get('purchase',['as'=>'purchaseIndex','uses'=>'PurchaseController@index']);
	Route::get('purchase/view/{po_number}',['as'=>'viewPurchase','uses'=>'PurchaseController@view']);
	Route::get('purchase/update/{po_number}',['as'=>'updatePurchasePage','uses'=>'PurchaseController@updatePage']);
	Route::post('purchase/update',['as'=>'updatePurchase','uses'=>'PurchaseController@update']);
	Route::post('purchase/delete',['as'=>'deletePurchase','uses'=>'PurchaseController@delete']);
	Route::get('/purchase/print/{POnumber}',['as'=>'printPurchase','uses'=>'PurchaseController@print']);

	//Inbound
	Route::get('inbound',['as'=>'inboundIndex','uses'=>'InboundController@index']);
	Route::get('inbound/create',['as'=>'inboundPage','uses'=>'InboundController@create']);
	Route::post('inbound/createnew',['as'=>'createInbound','uses'=>'InboundController@new']);

	//BOM
	Route::get('semi/create',['as'=>'semiPage','uses'=>'BOMController@semiPage']);
	Route::post('semi/createnew',['as'=>'createSemi','uses'=>'BOMController@createSemi']);
	Route::get('finished/create',['as'=>'finishedPage','uses'=>'BOMController@finishedPage']);
	Route::get('semi/search',['as'=>'searchSemi','uses'=>'BOMController@searchSemi']);
	Route::get('semi/find',['as'=>'findSemiInfo','uses'=>'BOMController@findSemiInfo']);
	Route::post('finished/createnew',['as'=>'createFinished','uses'=>'BOMController@createFinished']);
	Route::get('project',['as'=>'projectIndex','uses'=>'BOMController@projectIndex']);
	Route::get('project/create',['as'=>'projectPage','uses'=>'BOMController@projectPage']);
	Route::get('finished/search',['as'=>'searchFinished','uses'=>'BOMController@searchFinished']);
	Route::get('finished/find',['as'=>'findFinishedInfo','uses'=>'BOMController@findFinishedInfo']);
	Route::post('project/createnew',['as'=>'createProject','uses'=>'BOMController@createProject']);
	Route::get('bom',['as'=>'bomPage','uses'=>'BOMController@bomPage']);

	//====Data
	Route::get('material/export',['as'=>'exportMaterial','uses'=>'DataController@exportMaterial']);
	Route::post('material/import',['as'=>'importMaterial','uses'=>'DataController@importMaterial']);

	//===User Setting
	Route::get('setting',['as'=>'settingPage','uses'=>'UserController@settingPage']);

	Route::post('password/reset',['as'=>'resetPassword','uses'=>'UserController@resetPassword']);
	Route::post('setting/update',['as'=>'updateUser','uses'=>'UserController@updateUser']);
	Route::get('photo',['as'=>'showPhoto','uses'=>'UserController@showPhoto']);
});

