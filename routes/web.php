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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('feed', 'FeedController');

Route::get('/prueba', function() {

    $crawler = Goutte::request('GET', 'https://www.elmundo.es/');
    $crawler->filter('.ue-l-cover-grid__unit article')->each(function ($node,$i=0) {
      if($i<5)
      {
        $arr = [] ;
        $arr['title'] =   $node->filter('.ue-c-cover-content__main span')->text();
        $arr['title2'] =   $node->filter('.ue-c-cover-content__main a h2')->text();
        $arr['publisher'] =  explode(': ',$node->filter('.ue-c-cover-content__main span.ue-c-cover-content__byline-name')->text())[1];
        $arr['imag'] =   $node->filter('.ue-c-cover-content__media figure img')->attr('src');
        dump($arr);
      }
      $i++;
      //dump($node->text());
    });

});
