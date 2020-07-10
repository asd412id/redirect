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

Auth::routes(['verify' => true]);

Route::group(['middleware'=>['auth','verified']], function()
{
  Route::get('/beranda', 'HomeController@index')->name('home');
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


Route::get('/', 'LinksController@index')->name('index');
Route::get('/{custom}', 'LinksController@goto');
