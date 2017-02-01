@extends('layouts.admin')

@section('title', 'Notícias')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css') }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css') }}
@stop

@section('content')
<a href="{{ action('NoticiasController@getIndex') }}" alt="Voltar para lista de Notícias" title="Voltar para lista de Notícias"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->noticia))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->noticia->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Informações</a></li>
	<li role="presentation"><a href="#galeria" aria-controls="galeria" role="tab" data-toggle="tab">Galeria</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="info">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Formulário de Notícias
			</div>
			<div class="panel-body">

				{{ Form::open(array('action' => 'NoticiasController@getAdicionar')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Notícia</legend>
					<div class="form-group row">
						{{ Form::label('title', 'Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('title', null, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('description', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('description', null, array('placeholder' => 'Digite aqui a notícia completa.', 'class' => 'form-control ckeditor')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('tags', 'Tags', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('tags', null, array('placeholder' => 'eletrônicos,móveis,...', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('featured', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<label class="c-input c-checkbox">
								{{ Form::checkbox('featured', '1') }}
								<span class="c-indicator"></span>
								Destaque
							</label>
							<label class="c-input c-checkbox">
								{{ Form::checkbox('gallery', '1') }}
								<span class="c-indicator"></span>
								Galeria
							</label>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('news_categories', 'Categorias', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::select('news_categories[]', $categorias, null, array('id' => 'name', 'multiple', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>

				<fieldset class="form-group">
					<legend class="text-info h4">SEO</legend>
					<div class="form-group row">
						{{ Form::label('meta_title', 'Meta Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('meta_title', null, array('placeholder' => 'Titulo', 'class' => 'form-control', 'maxlength' => '63')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('meta_description', 'Meta Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('meta_description', null, array('placeholder' => 'Resumo da notícia', 'class' => 'form-control', 'maxlength' => '160')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('meta_keywords', 'Palavras Chave', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('meta_keywords', null, array('placeholder' => 'compras-online,futebol,saúde,...', 'class' => 'form-control')) }}
						</div>
					</div>

				</fieldset>

				{{ Form::submit('Cadastrar', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}

			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="galeria">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Formulário de Notícias
			</div>
			<div class="panel-body">
				<div class="alert alert-warning" role="alert">
					<strong>Aviso!</strong> O Banner e a Galeria de imagens poderam ser inseridas após o registro das informações desta notícia.
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/select2-3.5.4/select2.js') }}
{{ HTML::script('assets/plugins/select2-3.5.4/select2_locale_pt-BR.js') }}
{{ HTML::script('assets/plugins/bootstrap/maxlength/bootstrap-maxlength.js') }}
{{ HTML::script('ckeditor/ckeditor.js', array('async' => 'async')) }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('input[id=meta_keywords], input[id=tags]').select2({
			theme: "bootstrap",
			tags: [],
			tokenSeparators: [','],
			maximumSelectionLength: 4
		});
		$('select[name="news_categories[]"]').select2({
			theme: "bootstrap",
			placeholder: "Selecione uma ou mais categorias",
			maximumSelectionLength: 4,
			allowClear: true
		});
		$('input[name=meta_title]').maxlength();
		$('textarea[name=meta_description]').maxlength();
	});
</script>
@stop