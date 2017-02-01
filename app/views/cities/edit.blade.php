@extends('layouts.admin')

@section('title', 'Cidades')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')

@stop

@section('content')
<a href="{{ action('CitiesController@getIndex') }}" alt="Voltar para lista de Cidades" title="Voltar para lista de Cidades"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	{{ Session::get('message') }}
</div>
@endif
@if(isset($errors) && count($errors->cidade))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->cidade->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		Formulário de Cidades
	</div>
	<div class="panel-body">

		{{ Form::model(array('action' => 'CitiesController@postEditar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Cidade</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('name', $cidade->name, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('town_id', 'Town ID', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::number('town_id', $cidade->town_id, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('posx', 'Posição Inicial', array('class' => 'col-lg-2 col-md-12 col-sm-12 col-xs-12 form-control-label')) }}
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					{{ Form::number('posx', $cidade->posx, array('placeholder' => 'X', 'class' => 'form-control', 'min' => 0)) }}
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					{{ Form::number('posy', $cidade->posy, array('placeholder' => 'Y', 'class' => 'form-control', 'min' => 0)) }}
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					{{ Form::number('posz', $cidade->posz, array('placeholder' => 'Z', 'class' => 'form-control', 'min' => 0)) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Atualizar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
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