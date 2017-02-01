@extends('layouts.public')

@section('title', Lang::get('content.character creation'))
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.create your character and start playing') }} {{ $configuracoes->title or 'App Name' }}</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.create your character and start playing') }} {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(isset($errors) && count($errors->player))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				@foreach ($errors->player->all('<li>:message</li>') as $message)
				{{$message}}
				@endforeach
			</div>
			@endif
			@if(Session::get('message'))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				{{ Session::get('message') }}
			</div>
			@endif

			{{ Form::model(array('action' => 'PlayersController@postRegister', 'class' => 'form')) }}

			<div class="form-group">
				{{ Form::label('name', Lang::choice('content.name', 1)) }}
				{{ Form::text('name', null, array('placeholder' => Lang::get('content.type the name of the character').'.', 'class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('sex', Lang::choice('content.gender', 1)) }}
				<div class="center-block">
					<label style="font-weight:normal">{{ Form::radio('sex', '1', true) }} {{ Lang::get('content.male') }}</label>
					<label style="font-weight:normal">{{ Form::radio('sex', '0') }} {{ Lang::get('content.female') }}</label>
				</div>
			</div>
			<div class="form-group">
				{{ Form::label('vocation', Lang::choice('content.vocation', 1)) }}
				{{ Form::select('vocation', $vocacoes, 1, ['class' => 'form-control']) }}
			</div>
			<div class="form-group">
				{{ Form::label('level', Lang::get('content.initial level')) }}
				{{ Form::number('level', $configuracoes->level, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0, 'readonly')) }}
			</div>
			<div class="form-group">
				{{ Form::label('town_id', Lang::choice('content.city', 1)) }}
				{{ Form::select('town_id', $cidades, null, ['class' => 'form-control']) }}
			</div>
			<div class="form-group">
				{{ Form::label('world_id', Lang::choice('content.world', 1)) }}
				{{ Form::select('world_id', $mundos, null, ['class' => 'form-control']) }}
			</div>

			<div class="form-group">
				{{ Form::submit(Lang::get('content.register'), ['class' => 'btn btn-primary btn-block']) }}
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