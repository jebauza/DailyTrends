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
use Illuminate\Support\Str;


Route::get('/', function () {
    //return view('welcome');
    return redirect('feed');
});

Route::resource('feed', 'FeedController');

Route::get('/scraping', 'ScrapingController@example')->name('scraping.example');
