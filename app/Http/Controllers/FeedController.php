<?php

namespace App\Http\Controllers;

use App\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->getFeedMundoYpais();
        $feeds = Feed::orderBy('id','DESC')->get();
        return view('feed.index',compact('feeds'));
    }

    private function getFeedMundoYpais()
    {
        dd("entre getFeedMundoYpais");
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
