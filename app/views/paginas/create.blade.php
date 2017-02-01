@extends('layouts.admin')

@section('title', 'Paginas')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css') }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css') }}
@stop

@section('content')
<a href="{{ action('PaginasController@getIndex') }}" alt="Voltar para lista de Paginas" title="Voltar para lista de Paginas"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->pagina))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->pagina->all('<li>:message</li>') as $message)
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
				Formulário de Paginas
			</div>
			<div class="panel-body">
				{{ Form::open(array('action' => 'PaginasController@getAdicionar', 'class' => 'form')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Pagina</legend>

					<div class="form-group row">
						{{ Form::label('title', 'Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('title', null, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
						</div>
					</div>

					<div class="form-group row">
						{{ Form::label('body', 'Corpo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('body', null, array('placeholder' => 'Digite aqui a página completa.', 'class' => 'form-control ckeditor')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('gallery', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<label class="c-input c-checkbox">
								{{ Form::checkbox('gallery', '1') }}
								<span class="c-indicator"></span>
								Galeria
							</label>
						</div>
					</div>
				</fieldset>

				<fieldset class="form-group">
					<legend class="text-info h4">SEO</legend>
					<div class="form-group row">
						{{ Form::label('meta_title', 'Meta Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('meta_title', null, array('placeholder' => 'Titulo', 'class' => 'form-control', 'maxlength' => '64')) }}
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
							{{ Form::text('meta_keywords', null, array('placeholder' => 'eletrônicos,móveis,...', 'class' => 'form-control')) }}
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
				Formulário de Páginas
			</div>
			<div class="panel-body">
				<div class="alert alert-warning" role="alert">
					<strong>Aviso!</strong> O Banner e a Galeria de imagens poderam ser inseridas após o registro das informações desta página.
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
{{ HTML::script('ckeditor/ckeditor.js') }}
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
		$('input[name=meta_title]').maxlength();
		$('textarea[name=meta_description]').maxlength();
	});
</script>
@stop