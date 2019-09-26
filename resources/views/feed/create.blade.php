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
					<h3 class="panel-title">Nuevo Feed</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('feed.store') }}"  enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<input type="text" name="title" id="title" class="form-control input-sm" placeholder="Title,">
									</div>
								</div>
							</div>
 
							<div class="form-group">
								<textarea name="body" class="form-control input-sm" placeholder="Body"></textarea>
							</div>
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" name="source" id="source" class="form-control input-sm" placeholder="Source">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" name="publisher" id="publisher" class="form-control input-sm" placeholder="publisher">
									</div>
								</div>
							</div>
							<div class="form-group">
                                <label for="">Image</label>
                                <input type="file" name="image">
								
							</div>
							<div class="row">
 
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('feed.index') }}" class="btn btn-info btn-block" >Atrás</a>
								</div>	
 
							</div>
						</form>
					</div>
				</div>
 
			</div>
		</div>
	</section>
	@endsection