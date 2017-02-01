@extends('layouts.admin')

@section('title', 'Categorias das Notícias')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Edtiar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css') }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css') }}
@stop

@section('content')
<a href="{{ url('painel/categorias-noticias') }}" alt="Voltar para lista de Categorias" title="Voltar para lista de Categorias"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->categoria))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->categoria->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		Formulário de Categorias de Notícias
	</div>
	<div class="panel-body">

		{{ Form::model(array('action' => 'CategoriasNoticiasController@postEditar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Categoria</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('name', $categoria->name, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
				</div>
			</div>
		</fieldset>

		<fieldset class="form-group">
			<legend class="text-info h4">SEO</legend>
			<div class="form-group row">
				{{ Form::label('meta_title', 'Meta Titulo', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('meta_title', $categoria->meta_title, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('meta_description', 'Meta Descrição', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::textarea('meta_description', $categoria->meta_description, array('placeholder' => 'Resumo da categoria', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('meta_keywords', 'Palavras Chave', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('meta_keywords', $categoria->meta_keywords, array('placeholder' => 'compras-online,futebol,saúde,...', 'class' => 'form-control')) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Atualizar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
</div>

@stop

@section('scripts')
{{ HTML::script('assets/plugins/select2-3.5.4/select2.js') }}
{{ HTML::script('assets/plugins/select2-3.5.4/select2_locale_pt-BR.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('input[id=meta_keywords]').select2({
			theme: "bootstrap",
			tags: [],
			tokenSeparators: [','],
			maximumSelectionLength: 4
		});
	});
</script>
@stop