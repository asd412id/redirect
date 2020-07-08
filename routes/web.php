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

Route::group(['middleware'=>'guest'], function()
{
  Route::get('/signin', 'Auth\LoginController@showLoginForm')->name('login');
  Route::post('/signin', 'Auth\LoginController@login');
  Route::get('/signup', 'Auth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/signup', 'Auth\RegisterController@register');
});

Route::group(['middleware'=>'auth'], function()
{
  Route::get('/dashboard', 'HomeController@index')->name('home');
  Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

  Route::group(['prefix'=>'links'], function()
  {
    Route::get('/tambah', 'LinksController@create')->name('link.create');
    Route::post('/tambah', 'LinksController@store')->name('link.store');
    Route::get('/ubah/{uuid}', 'LinksController@edit')->name('link.edit');
    Route::post('/ubah/{uuid}', 'LinksController@update')->name('link.update');
    Route::get('/hapus/{uuid}', 'LinksController@destroy')->name('link.destroy');
  });

});

// Auth::routes();

Route::get('/', 'LinksController@index');
Route::get('/{custom}', 'LinksController@index');
