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

Route::get('/', 'MainController@index');

Route::post('/login-me','MainController@login');
Route::get('/logout','MainController@logout');
Route::get('/get-current-user', 'MainController@getCurrentUser');
Route::get('/get-role', 'MainController@getRoles');

Route::post('/save-role', 'MainController@saveRole');
Route::post('/delete-role', 'MainController@deleteRole');
Route::post('/delete-user', 'MainController@deleteUser');
Route::post('/save-user', 'MainController@saveUser');

Route::get('/get-expense-category', 'MainController@getExpenseCat');
Route::get('/get-expenses', 'MainController@getExpense');
Route::post('/save-expense-cat', 'MainController@saveExpenseCat');

Route::post('/save-expense', 'MainController@saveExpense');
Route::post('/delete-cat', 'MainController@deleteExpenseCat');
Route::post('/delete-expense', 'MainController@deleteExpense');
Route::get('/get-user', 'MainController@getUser');
Route::get('get-chart', 'MainController@getChart');
Route::post('/user/change-password', 'MainController@changePassword');
Route::get('{any}', 'MainController@index')->where('any', '.*');
