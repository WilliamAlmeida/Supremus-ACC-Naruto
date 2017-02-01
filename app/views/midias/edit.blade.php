@extends('layouts.admin')

@section('title', 'Mídia')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')

@stop

@section('content')
<a href="{{ url('midias') }}" alt="Voltar para lista de Midias" title="Voltar para lista de Midias"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>

@if(isset($errors) && count($errors->midias))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->midias->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		Formulário de Mídia
	</div>
	<div class="panel-body">

		{{ Form::model(array('action' => 'MidiasController@postEditar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Mídia</legend>
			<div class="form-group row">
				{{ Form::label('image', 'Imagem', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
				{{ HTML::image(str_replace('-original', '-thumbnail', $midia->path), $midia->name, array('title' => $midia->name, 'class' => 'img-responsive thumbnail')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('name', $midia->name, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
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

@stop