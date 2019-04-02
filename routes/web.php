<?php
use \App\Models\Horse;
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
    return view('welcome');
});
/*
Route::get('horses', function() {
    return Horse::all();
});*/

Auth::routes();

// CMS Admin routes

Route::middleware('auth')
	->prefix('admin')
	->namespace('Admin')
	->group(function () {
            
        Route::get('/', function() {
            return redirect()->route('admin.dashboard');
	});
	
	Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');  
        
        //Profile Routes
	Route::get('/profile/edit', 'ProfileController@edit')->name('admin.profile.edit');
	Route::post('/profile/edit', 'ProfileController@update');
	
	Route::get('/profile/change-password', 'ProfileController@changePassword')->name('admin.profile.change-password');
	Route::post('/profile/change-password', 'ProfileController@updatePassword');
        
        //Horses routes
	Route::get('/horses', 'HorsesController@index')->name('admin.horses.index');
	Route::get('/horses/datatable', 'HorsesController@datatable')->name('admin.horses.datatable');
	
	Route::get('/horses/add', 'HorsesController@add')->name('admin.horses.add');
	Route::post('/horses/add', 'HorsesController@insert');
			
	Route::get('/horses/edit/{id}', 'HorsesController@edit')->name('admin.horses.edit');
	Route::post('/horses/edit/{id}', 'HorsesController@update');
	
	Route::post('/horses/delete', 'HorsesController@delete')->name('admin.horses.delete');
});
