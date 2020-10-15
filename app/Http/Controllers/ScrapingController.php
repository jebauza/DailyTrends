<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\PeopleExport;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingController extends Controller
{
    protected $person, $list;

    public function example(Client $client, Excel $excel)
    {
        $crawler = $client->request('GET', 'https://www.quemedico.com/dentistas/valencia/1');
        $this->list = [];
        $text_count = $crawler->filter('div[class~="breadcrumb"] ul li')->last()->text();
        $pos_ini = strrpos($text_count, "(");
        $pos_end = strrpos($text_count, ")");
        $total = (int) substr($text_count,$pos_ini+1,($pos_end-$pos_ini)-1);

        for ($i=1; count($this->list) < $total && $i < $total; $i++) {
            if($i != 1) {
                $crawler = $client->request('GET', "https://www.quemedico.com/dentistas/valencia/$i");
            }

            $crawler->filter('main[class~="pagination-list-content"] ul li[class~="list-item"]')->each(function (Crawler $person) use($client) {
                $this->person = [];
                $person_data = $person->filter('div[class~="module text"] main div[class~="inner"]');
                $this->person['name'] = $person_data->filter('h2 a')->text();
                $this->person['specialties'] = "";
                $person_data->filter('p')->each(function ($node){
                    if($node->filter('i.fa-star')->count()){
                        $this->person['specialties'] .= $node->text().", ";
                    }
                });
                $this->person['address'] = $person_data->filter('p')->last()->text();
                $this->list[] = $this->person;

                /* $divs = $person->children()->filter('');
                $textInfo = $divs->eq(0)->text(); */
            });
        }

        return $excel->download(new PeopleExport(collect($this->list)), 'Directorio.xlsx');
    }
}
