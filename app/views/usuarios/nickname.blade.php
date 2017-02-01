@extends('layouts.public')

@section('title', Lang::get('content.change nickname'))
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h4 class="foDi foDS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.choose your nickname in the') }} {{ $configuracoes->title or 'App Name' }}.</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.choose your nickname in the') }} {{ $configuracoes->title or 'App Name' }}.</h5>
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

			{{ Form::open(array('action' => 'UsersController@postNickname', 'class' => 'form')) }}

			<div class="form-group">
				{{ Form::label('nickname', Lang::get('content.nickname')) }}
				{{ Form::text('nickname', null, array('placeholder' => 'João', 'class' => 'form-control')) }}
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