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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/shop', 'ProductsController@index')->name('shop');
Route::get('/shop/{category}', 'ProductsController@indexCategory')->name('shop.category');
Route::get('/product/{id}','ProductsController@show')->name('product.show');
Route::post('/add-to-cart','ProductsController@addCart')->name('product.addCart');
Route::patch('update-cart', 'ProductsController@updateCart');
Route::patch('check-code', 'ProductsController@promoCode');
Route::delete('remove-from-cart', 'ProductsController@removeCart');
Route::view('/cart', 'cart')->name('cart');
Route::post('rate-product', 'ProductsController@rate')->middleware('auth');
Route::get('/account/orders', 'OrdersController@index')->name('Orders.index')->middleware('auth');
Route::get('/cart/check-out', 'OrdersController@create')->name('Orders.create')->middleware('auth');
Route::view('/account/settings', 'account.settings')->name('account.index')->middleware('auth');
Route::patch('/account/settings', 'UsersController@update')->name('user.update')->middleware('auth');
Route::get('/account/addresses', 'UsersController@getAddress')->name('account.address')->middleware('auth');
Route::post('/account/addresses', 'UsersController@storeAddress')->name('address.store')->middleware('auth');
Route::get('/account/address/{id}/active', 'UsersController@setAddress')->name('address.set')->middleware('auth');
Route::view('help', 'help')->name('help');
//Socail login
Route::get('/redirect/{provider}', 'SocialAuthProviderController@redirectToProvider');
Route::get('/{provider}/callback', 'SocialAuthProviderController@handleProviderCallback');
//Admin routes
Route::get('/admin', 'Dashboard@index')->name('Dashboard')->middleware('Admin');
Route::get('/admin/Orders', 'OrdersController@index')->name('Admin.Orders')->middleware('Admin');
Route::delete('/admin/Order/remove', 'OrdersController@destroy')->name('Orders.remove')->middleware('Admin');
Route::patch('/admin/Order/update', 'OrdersController@update')->name('Orders.update')->middleware('Admin');
Route::get('/admin/Products', 'ProductsController@index')->name('Admin.Products')->middleware('Admin');
Route::delete('/admin/Product/remove', 'ProductsController@destroy')->name('Products.remove')->middleware('Admin');
Route::patch('/admin/Product/update', 'ProductsController@update')->name('Products.update')->middleware('Admin');
Route::post('/admin/Product/add', 'ProductsController@store')->name('Products.store')->middleware('Admin');
Route::get('/admin/Users', 'UsersController@DashboardIndex')->name('Admin.Users')->middleware('Admin');
Route::delete('/admin/Users/remove', 'UsersController@DashboardDestroy')->name('Users.remove')->middleware('Admin');
Route::patch('/admin/Users/update', 'UsersController@DashboardUpdate')->name('Users.update')->middleware('Admin');
Route::post('/admin/Users/create', 'UsersController@DashboardStore')->name('Users.create')->middleware('Admin');
