@extends('layouts.layout')
@section('content')
<div class="row">
  <section class="content">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="pull-left"><h3>Lista Feed</h3></div>
          <div class="pull-right">
            <div class="btn-group">
              <a href="{{ route('feed.create') }}" class="btn btn-info" >Añadir Seed</a>
            </div>
          </div>
          <div class="table-container">
            <table id="mytable" class="table table-bordred table-striped">
             <thead>
               <th>Title</th>
               <th>Publisher</th>
               <th>Source</th>
             </thead>
             <tbody>
              @if($feeds->count())  
              @foreach($feeds as $feed)  
              <tr>
                <td>{{$feed->title}}</td>
                <td>{{$feed->publisher}}</td>
                <td>{{$feed->source}}</td>
                <td><a class="btn btn-primary btn-xs" href="{{action('FeedController@show', $feed->id)}}" ><span class="glyphicon glyphicon-eye-open"></span></a></td>
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="8">No hay registro !!</td>
              </tr>
              @endif
            </tbody>
 
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
 
@endsection