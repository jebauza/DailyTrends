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

Route::get('/prueba', function() {


  //antes de esto setear el archivo de configuracion
  $directory = 'image/';
  $files = Storage::disk('public')->files($directory);
  $filesUrl = [];
  foreach($files as $file)
  {
    $filesUrl[] = ['nameFile'=>Str::replaceFirst($directory, '', $file),'urlFile'=>Storage::disk('public')->url($file)];
  }
  dd($filesUrl);
});
