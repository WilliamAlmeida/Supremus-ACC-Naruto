@extends('layouts.admin')

@section('title', 'Personagens')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')

@stop

@section('content')
<a href="{{ action('PlayersController@getIndex') }}" alt="Voltar para lista de Personagens" title="Voltar para lista de Personagens"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->player))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->player->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		Formulário de Personagens
	</div>
	<div class="panel-body">

		{{ Form::model(array('action' => 'PlayersController@postEditar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Personagem</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{{ $player->name }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('newName', 'Novo Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('newName', null, array('placeholder' => 'Novo Nome', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('level', 'Level', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('level', $player->level, array('placeholder' => '0', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('stamina', 'Stamina', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('stamina', $player->stamina, array('placeholder' => '1', 'class' => 'form-control', 'min' => 1)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('healthmax', 'Vida', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('healthmax', $player->healthmax, array('placeholder' => '150', 'class' => 'form-control', 'min' => 150)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('online', 'Online', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('online', $player->online, array('placeholder' => '0', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('town_id', 'Cidade', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('town_id', $cidades, $player->town_id, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('world_id', 'Mundo', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('world_id', $mundos, $player->world_id, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('created', 'Registrado em', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{{ Helpers::ago($player->created) }}}
				</div>
			</div>
		</fieldset>

		<fieldset class="form-group">
			<legend class="text-info h4">Nível de Acesso</legend>
			<div class="form-group row">
				{{ Form::label('group_id', 'Nível de Acesso', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('group_id', $grupos, $player->group_id, ['class' => 'form-control']) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Atualizar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('ckeditor/ckeditor.js', array('async' => 'async')) }}
@stop

@section('script-execute')

@stop