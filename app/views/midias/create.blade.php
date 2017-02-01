@extends('layouts.admin')

@section('title', 'Mídias')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')
	{{ HTML::style('http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.min.css') }}
@stop

@section('content')
<a href="{{ url('midias') }}" alt="Voltar para lista de Mídias" title="Voltar para lista de Mídias"><i class="fa fa-arrow-left fa-2x"></i></a>
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
		Formulário de Mídias
	</div>
	<div class="panel-body">

		{{ Form::open(array('action' => 'MidiasController@getAdicionar', 'files' => true)) }}

		{{ Form::hidden('type', 'produtos', array('id' => 'type', 'class' => 'form-control')) }}
		
		{{--Form::hidden('img_backup', $data['imagem'], array('id' => 'img_backup', 'class' => 'form-control'))--}}

		<fieldset class="form-group">
			<legend class="text-info h4">Mídia</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('name', null, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
				</div>
			</div>

			<div class="form-group row">
				{{ Form::label('path', 'Mídia', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::file('path[]', array('multiple', 'accept' => 'image/*', 'class' => 'form-control')) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Cadastrar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}

	</div>
</div>

<input type="hidden" id="modal" value="false"/>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Recorte de Imagem</h4>
			</div>
			{{ Form::open(array('action' => 'MidiasController@postCropImage', 'onsubmit' => 'return checkCoords();')) }}
			<div class="modal-body">
				{{ HTML::image((isset($data['imagem'])) ? $data['imagem'] : null, '', ['id' => 'crop']) }}

				{{--Form::hidden('src', $data['imagem'], array('id' => 'src', 'class' => 'form-control'))--}}

				{{ Form::hidden('x', null, array('id' => 'x', 'class' => 'form-control')) }}
				{{ Form::hidden('y', null, array('id' => 'y', 'class' => 'form-control')) }}
				{{ Form::hidden('w', null, array('id' => 'w', 'class' => 'form-control')) }}
				{{ Form::hidden('h', null, array('id' => 'h', 'class' => 'form-control')) }}


			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Salvar Recorte</button>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop

@section('scripts')
	{{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.12/js/jquery.Jcrop.min.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		var modal;
		if($('#modal').val() == 'true'){ modal = true; }else{ modal = false; }
		$("#myModal").modal({show: modal});

		$('#crop').Jcrop({
			aspectRatio: 1,
			onSelect: atualizarCoordenadas
		})
	});

	function atualizarCoordenadas(c){
		$("#x").val(c.x);
		$("#y").val(c.y);
		$("#w").val(c.w);
		$("#h").val(c.h);
	}

	function checkCoords(){
		if(parseInt($("#w").val())) return true;

		alert('Selecione uma imagem');
		
		return false;
	}
</script>
@stop