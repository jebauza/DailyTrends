@extends('layouts.layout')
@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Details Feed</h3>
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
                        <div class="form-row">
                            <form action="{{action('FeedController@destroy', $feed->id)}}" method="post">
                                {{csrf_field()}}
                                <input name="_method" type="hidden" value="DELETE">

                                <a href="{{action('FeedController@edit', $feed->id)}}" class="btn btn-success"
                                    role="button">Edit</a>

                                <a href="{{ route('feed.index') }}" class="btn btn-primary" role="button">Back</a>

                                <input class="btn btn-danger" type="submit" value="Delete">

                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endsection
