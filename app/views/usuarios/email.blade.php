@extends('layouts.public')

@section('title', Lang::get('content.email change'))
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.we recommend that you always place a valid email') }}.</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.we recommend that you always place a valid email') }}.</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(isset($errors) && count($errors->usuario))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				@foreach ($errors->usuario->all('<li>:message</li>') as $message)
				{{$message}}
				@endforeach
			</div>
			@endif

			{{ Form::open(array('action' => 'UsersController@postEmail', 'class' => 'form')) }}

			<div class="form-group">
				{{ Form::label('email', Lang::get('content.email')) }}
				{{ Form::email('email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('repeat_email', Lang::get('content.repeat email')) }}
				{{ Form::email('repeat_email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::submit(Lang::get('content.save'), ['class' => 'btn btn-primary btn-block']) }}
			</div>

			{{ Form::close() }}
		</div>
	</div>
</div>
@stop

@section('scripts')

@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){

	});
</script>
@stop