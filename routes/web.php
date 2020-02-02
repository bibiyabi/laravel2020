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

Route::get('/', function (){
    //dd('hi');
    return view('welcome');
//    echo phpinfo();
    //return view('login.register');
});


Route::post('test', 'LoginController@test');
Route::post('crawler', 'CrawlerController@testGetOriginalData');
Route::post('crawler2', 'CrawlerController@getHoroscope');



//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
