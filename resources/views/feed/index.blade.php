@extends('layouts.layout')
@section('content')
<div class="row">
  <section class="content">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
              <div class="boton">
                  <div class="btn-group">
                    <a href="{{ route('feed.create') }}" class="btn btn-info" >Añadir Seed</a>
                  </div>
              </div>
        </div>
        <div class="panel-body">
          <div class="table-container">
            @if($feeds->count())  
            @foreach($feeds as $feed)  
            <a href="{{action('FeedController@show', $feed->id)}}" ><article class="articulo">
              <div class="row">
                @if($feed->image != "")
                <div class="col-xs-3">
                  <div class="thumbnail"><img src="{{$feed->image}}" alt="" title="{{$feed->title}}"></div>
                </div>
                <div class="col-xs-9">
                @else
                <div class="col-xs-12">
                @endif
                  <h3>{{$feed->title}}</h3>
                  <span><h5>{{strtoupper($feed->publisher)}} | {{$feed->source}}</h5></span>
                  <p>{{substr($feed->body, 0, 180)}}....</p>
                </div>
              </div>
            </article></a>
            @endforeach 
            @else
            <p>No hay Feed</p>
            @endif  


            
        </div>
      </div>
    </div>
  </div>
</section>
 
@endsection