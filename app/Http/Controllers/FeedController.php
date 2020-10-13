<?php

namespace App\Http\Controllers;

use App\Feed;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class FeedController extends Controller
{
    private $texto;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->getFeedElMundo();
        $this->getFeedElPais();

        $feeds = Feed::orderBy(DB::raw('DATE(created_at)'), 'DESC')
                        ->orderBy(DB::raw("DATE_FORMAT(updated_at, '%Y%m%d%H%i')"), 'DESC')
                        ->orderBy("title")->get();
                        
        return view('feed.index',compact('feeds'));
    }

    private function getFeedElMundo()
    {
        $cliente = new Client();
        $crawler = $cliente->request('GET', 'https://www.elmundo.es/');

        try {
            $crawler->filter('.ue-l-cover-grid__unit article')->each(function ($node,$i = 0) use($cliente){
                if($i<5)
                {
                    $title =   $node->filter('.ue-c-cover-content__main span')->text().$node->filter('.ue-c-cover-content__main a h2')->text();
                    $publisher =  explode(': ',$node->filter('.ue-c-cover-content__main span.ue-c-cover-content__byline-name')->text())[1];
                    $image =  $node->filter('.ue-c-cover-content__image');
                    $url_image = $image->count() ? $image->attr('src') : '';
                    $source = 'www.elmundo.es';
                    $link = $node->filter('.ue-c-cover-content__link')->attr('href');
                    $subpage = $cliente->request('GET', $link);
                    $this->texto = "";
                    $subpage->filter('.ue-c-article__body p')->each(function ($node){
                        $this->texto .= $node->text()." </br>";
                    });

                    $feed = Feed::updateOrCreate(
                        ['title' => $title, 'source' => $source],
                        ['publisher' => $publisher, 'image' => $url_image, 'source' => $source, 'body' => $this->texto]
                    );
                }
                $i++;
             });
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private function getFeedElPais()
    {
        $cliente = new Client();
        $crawler = $cliente->request('GET', 'https://www.elpais.com/');

        try {
            $crawler->filter('article[class~="story_card story_card_default"]')->each(function ($node, $i = 0) use($cliente) {
                if($i<5)
                {
                    $link = $node->filter('h2[class~="headline"] a');
                    $title = $link->text();
                    $publisher = $node->filter('span a[class~="author"]')->text();
                    $source = 'www.elpais.com';
                    $subpage = $cliente->request('GET', 'https://www.elpais.com'.$link->attr('href'));
                    $image = $subpage->filter('figure img');
                    $url_image = $image->count() ? $image->attr('src') : '';
                    $this->texto = "";
                    $subpage->filter('div[class~="article_body"] p')->each(function ($node){
                        $this->texto .= $node->text()." </br>";
                    });

                    $feed = Feed::updateOrCreate(
                        ['title' => $title, 'source' => $source],
                        ['publisher' => $publisher, 'image' => $url_image, 'body' => $this->texto]
                    );
                }
                $i++;
             });
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feed.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Image
        $image = "";
        if($request->file('image'))
        {
            $file = $request->file('image');
            $nombre = $file->getClientOriginalName();
            $path = Storage::disk('public')->put('image',$file);
            $image = asset($path);
        }
        $this->validate($request,[ 'title'=>'required', 'body'=>'required', 'image'=>'required', 'source'=>'required', 'publisher'=>'required']);
        $feed = Feed::create($request->all());
        $feed->fill(['image'=>$image])->save();
        return redirect()->route('feed.index')->with('success','Registro creado satisfactoriamente');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feed=Feed::find($id);
        return  view('feed.show',compact('feed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feed=Feed::find($id);
        return view('feed.edit',compact('feed'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[ 'title'=>'required', 'body'=>'required', 'source'=>'required', 'publisher'=>'required']);
        $feed = Feed::find($id);
        $image = $feed->image;
        $feed->fill($request->all())->save();
        if($request->file('image'))
        {
            $file = $request->file('image');
            $nombre = $file->getClientOriginalName();
            $path = Storage::disk('public')->put('image',$file);
            $image = asset($path);
        }
        $feed->fill(['image'=>$image])->save();
        return redirect()->route('feed.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Feed::find($id)->delete();
        return redirect()->route('feed.index')->with('success','Registro eliminado satisfactoriamente');
    }
}
