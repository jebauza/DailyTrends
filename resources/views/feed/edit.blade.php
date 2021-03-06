@extends('layouts.layout')
@section('content')
<div class="row">
    <section class="content">
        <div class="col-md-8 col-md-offset-2">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-info">
                {{Session::get('success')}}
            </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Feed</h3>
                </div>
                <div class="panel-body">
                    <div class="table-container">
                        <form method="POST" action="{{ route('feed.update',$feed->id) }}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="text" name="title" id="title" class="form-control input-sm"
                                            placeholder="Title" value="{{$feed->title}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea name="body" class="form-control input-sm" placeholder="Body" rows="10"
                                    style="resize: none">{{$feed->body}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="source" id="source" class="form-control input-sm"
                                            placeholder="Source" value="{{$feed->source}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="publisher" id="publisher" class="form-control input-sm"
                                            placeholder="Publisher" value="{{$feed->publisher}}">
                                    </div>
                                </div>
                            </div>
                            <img src="{{$feed->image}}"></img>
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image">

                            </div>
                            <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="submit" value="Save" class="btn btn-success btn-block">
                                    <a href="{{action('FeedController@show', $feed->id)}}"
                                        class="btn btn-info btn-block">Back</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endsection
