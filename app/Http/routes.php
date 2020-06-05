<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/' , 'AdminController@getAdminlogin')->name('admin.getLogin');
Route::get('/login' , 'AdminController@getAdminlogin')->name('admin.getLogin');

Route::post('/login' , 'AdminController@postAdminlogin')->name('admin.postLogin');

Route::get('/logout' , 'AdminController@getAdminLogout')->name('admin.getLogout');


Route::group(['prefix' => 'dashboard' , 'middleware' => 'checklogin'] , function(){
	Route::get('all' , 'ContractsController@allContracts')->name('contracts.all');

	Route::get('add' , 'ContractsController@getAddContracts')->name('contracts.getAdd');
	Route::post('add' , 'ContractsController@postAddContracts')->name('contracts.postAdd');

	Route::get('edit/{id}' , 'ContractsController@getEditContracts')->name('contracts.getEdit');
	Route::post('edit/{id}' , 'ContractsController@postEditContracts')->name('contracts.postEdit');

	Route::get('delete' , 'ContractsController@getDeleteAllContracts')->name('contracts.getDelAll');
	Route::get('delete/{id}' , 'ContractsController@getDeleteContracts')->name('contracts.getDel');

	Route::post('chose' , 'ContractsController@postChoseContracts')->name('contracts.postChose');

	Route::get('sendmulty' , 'ContractsController@getSendMultyContracts')->name('contracts.getSendMulty');
	Route::post('sendmulty' , 'ContractsController@postSendMultyContracts')->name('contracts.postSendMulty');

	Route::get('send/{id}' , 'ContractsController@getSendContracts')->name('contracts.getSend');
	Route::post('send/{id}' , 'ContractsController@postSendContracts')->name('contracts.postSend');

	Route::get('receive' , 'ShareController@getReceiveContracts')->name('contracts.getReceive');

	Route::get('shareindex' , 'ShareController@getShareShowContracts')->name('contracts.getShareShow');
	Route::post('shareindex' , 'ShareController@postShareShowContracts')->name('contracts.postShareShow');

	Route::get('shareindex/show/{id}' , 'ShareController@getShareShowContractsHide')->name('contracts.getShareShowH');
	Route::get('shareindex/hide/{id}' , 'ShareController@getShareShowContractsShow')->name('contracts.getShareShowS');
	
	Route::get('share/{id}' , 'ShareController@getShareContracts')->name('contracts.getShare');
	Route::post('share/{id}' , 'ShareController@postShareContracts')->name('contracts.postShare');

	Route::get('sharemulty' , 'ContractsController@getShareMultyContracts')->name('contracts.getShareMulty');
	Route::post('sharemulty' , 'ContractsController@postShareMultyContracts')->name('contracts.postShareMulty');
});
