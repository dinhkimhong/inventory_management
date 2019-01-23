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

use App\User;
use App\Role;

Route::get('/', function () {
	$users = User::orderBy('id','ASC')->get();
	$roles = Role::orderBy('description','ASC')->get();
    return view('index',compact('users','roles'));
})->name('home1');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('auth/{provider}','Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback','Auth\LoginController@handleProviderCallback');

Route::group(['middleware'=>['auth','CheckRole']],function(){
	Route::post('/users/update',['as'=>'updateUsers','uses'=>'AdminController@updateUsers']);

});

Route::group(['middleware'=>'auth'],function(){

	Route::get('material',['as'=>'materialIndex','uses'=>'MaterialController@materialIndex']);
	Route::get('material/create',['as'=>'materialPage','uses'=>'MaterialController@materialPage']);
	Route::post('material/createnew',['as'=>'createMaterial','uses'=>'MaterialController@createMaterial']);
	Route::get('material/search',['as'=>'searchMaterial','uses'=>'MaterialController@searchMaterial']);
	Route::get('material/find',['as'=>'findMaterialInfo','uses'=>'MaterialController@findMaterialInfo']);
	Route::get('material/view',['as'=>'viewMaterial','uses'=>'MaterialController@viewMaterial']);
	Route::post('material/update',['as'=>'updateMaterial','uses'=>'MaterialController@updateMaterial']);
	Route::post('material/delete',['as'=>'deleteMaterial','uses'=>'MaterialController@deleteMaterial']);
	//Vendor
	Route::get('vendor/create',['as'=>'vendorPage','uses'=>'VendorController@vendorPage']);
	Route::post('vendor/createnew',['as'=>'createVendor','uses'=>'VendorController@createVendor']);
	Route::get('vendor',['as'=>'vendorIndex','uses'=>'VendorController@vendorIndex']);
	Route::get('vendor/search',['as'=>'searchVendor','uses'=>'VendorController@searchVendor']);
	Route::get('vendor/find',['as'=>'findVendorInfo','uses'=>'VendorController@findVendorInfo']);
	Route::get('vendor/view',['as'=>'viewVendor','uses'=>'VendorController@viewVendor']);
	Route::post('vendor/update',['as'=>'updateVendor','uses'=>'VendorController@updateVendor']);
	Route::post('vendor/delete',['as'=>'deleteVendor','uses'=>'VendorController@deleteVendor']);

	//Purchase
	Route::get('purchase/create',['as'=>'purchasePage','uses'=>'PurchaseController@purchasePage']);
	Route::post('purchase/createnew',['as'=>'createPurchase','uses'=>'PurchaseController@createPurchase']);
	Route::get('purchase',['as'=>'purchaseIndex','uses'=>'PurchaseController@purchaseIndex']);
	Route::get('purchase/view',['as'=>'viewPurchase','uses'=>'PurchaseController@viewPurchase']);
	Route::post('purchase/update',['as'=>'updatePurchase','uses'=>'PurchaseController@updatePurchase']);
	Route::post('purchase/delete',['as'=>'deletePurchase','uses'=>'PurchaseController@deletePurchase']);
	Route::get('/purchase/print/{POnumber}',['as'=>'printPurchase','uses'=>'PurchaseController@printPurchase']);

	//Inbound
	Route::get('inbound',['as'=>'inboundIndex','uses'=>'InboundController@inboundIndex']);
	Route::get('inbound/create',['as'=>'inboundPage','uses'=>'InboundController@inboundPage']);
	Route::post('inbound/createnew',['as'=>'createInbound','uses'=>'InboundController@createInbound']);

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

