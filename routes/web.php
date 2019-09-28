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
    //return view('welcome');
    return redirect('feed');
});

Route::resource('feed', 'FeedController');

/*Route::get('/prueba', function() {

    $crawler = Goutte::request('GET', 'https://www.elpais.com/');
    $crawler->filter('#bloque_actualidad_destacadas .bloque__interior article.articulo')->each(function ($node,$i=0) {
      
      if($i<5)
      {
        $arr = [] ;
        $link = $node->filter('h2.articulo-titulo a');
        $arr['title'] = $link->text();
        $url = $link->attr('href');
        $arr['autor'] = $node->filter('span.autor-nombre a')->text();
        $arr['image'] = $node->filter('figure.foto img')->attr('src');

        dump($arr);
      }
      $i++;
    });
});
