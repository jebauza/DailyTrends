@extends('layouts.layout')
@section('content')
<div class="row">
        <section class="content">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detalles Feed</h3>
                    </div>
                    <div class="panel-body">					
                        <div class="table-container">
                            <article>
                                <h3>{{$feed->title}}</h3>
                                <h5>{{$feed->source}}</h5>
                                <h6>{{$feed->publisher}}</h6>
                                <img src="{{$feed->image}}" alt="" height="300" width="300">
                                <p>{!! $feed->body !!}</p>
                            </article>
                            <div class="row">
 
                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                            <a href="{{action('FeedController@edit', $feed->id)}}" class="btn btn-info col-sm-2" >Editar</a>
                                    <a href="{{ route('feed.index') }}" class="btn btn-success col-sm-2" >Atras</a>

                                            <form action="{{action('FeedController@destroy', $feed->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <input name="_method" type="hidden" value="DELETE">
                                  
                                                    <input type="submit"  value="Eliminar" class="btn btn-danger col-sm-2">

                                        
                                    </div>	
     
                                </div>
                        </div>
                    </div>
     
                </div>
            </div>
        </section>
@endsection