@extends('layouts.admin')

@section('title', 'Paginas')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css') }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css') }}
@stop

@section('content')
<a href="{{ action('PaginasController@getIndex') }}" alt="Voltar para lista de Paginas" title="Voltar para lista de Paginas"><i class="fa fa-arrow-left fa-2x"></i></a>
<a href="{{ action('PaginasController@getPagina', array('id' => $pagina->slug)) }}" alt="Visualizar Pagina" title="Visualizar Pagina" target="view_page"><i class="fa fa-eye fa-2x"></i></a>
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	{{ Session::get('message') }}
</div>
@endif
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

				{{ Form::model(array('action' => 'PaginasController@postEditar')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Produto</legend>
					<div class="form-group row">
						{{ Form::label('title', 'Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('title', $pagina->title, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('body', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('body', $pagina->body, array('placeholder' => 'Digite aqui a página completa.', 'class' => 'form-control ckeditor')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('gallery', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<label class="c-input c-checkbox">
								{{ Form::checkbox('gallery', '1', @($pagina->gallery) ? true : false) }}
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
							{{ Form::text('meta_title', $pagina->meta_title, array('placeholder' => 'Titulo', 'class' => 'form-control', 'maxlength' => '64')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('meta_description', 'Meta Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('meta_description', $pagina->meta_description, array('placeholder' => 'Resumo da notícia', 'class' => 'form-control', 'maxlength' => '160')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('meta_keywords', 'Palavras Chave', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('meta_keywords', $pagina->meta_keywords, array('placeholder' => 'futebol,saúde,...', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>

				{{ Form::submit('Atualizar', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="galeria">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Formulário de Paginas
			</div>
			<div class="panel-body">
				{{ Form::open(array('action' => array('MidiasController@getAdicionar'), 'files' => true)) }}

				{{ Form::hidden('id', $pagina->id, array('id' => 'id', 'class' => 'form-control')) }}
				{{ Form::hidden('name', $pagina->title, array('id' => 'name', 'class' => 'form-control')) }}

				{{ Form::hidden('type', 'paginas', array('id' => 'type', 'class' => 'form-control')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Imagem</legend>
					<div class="form-group row">
						{{ Form::label('path', 'Imagem', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::file('path[]', array('multiple', 'accept' => 'image/*', 'class' => 'form-control')) }}
							<span class="center-block text-info"><small>Tamanho recomendado: 500 x 300 pixels</small></span>
						</div>
					</div>
				</fieldset>

				{{ Form::submit('Inserir', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}
				
				<hr>

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="{{ (count($pagina->midiapagina)) ? 'true' : 'false' }}" aria-controls="collapseOne">
									Imagens
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse {{ (count($pagina->midiapagina)) ? 'in' : null }}" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								@if(isset($errors) && count($errors->midias))
								<div class="alert alert-warning alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<strong>Aviso!</strong>
									@foreach ($errors->midias->all('<li>:message</li>') as $message)
									{{$message}}
									@endforeach
								</div>
								@endif
								@forelse($pagina->midiapagina as $midia)
								<div class="col-lg-2 col-md-4 col-sm-6 col-xs-6">
									<div class="thumbnail">
										{{ HTML::image(str_replace('-original', '-thumbnail', $midia->path), $midia->name, array('title' => $midia->name, 'class' => 'img-responsive thumbnail')) }}
										<div class="caption {{ ($midia->capa) ? 'bg-warning' : null }}">
											<h5>{{{ $midia->name }}}</h5>
											<div class="center-block">
												<div class="btn-group dropup">
													<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Opções <span class="caret"></span>
													</button>
													<ul class="dropdown-menu">
														<li class="{{ ($midia->capa) ? 'disabled' : null }}">
															@if($midia->capa) <a href="#!">Imagem ja está sendo usada como capa do pagina</a>
															@else <a href="{{action('MidiasController@getCapa', array($midia->id, $pagina->id))}}">Usar imagem como capa do pagina</a>
															@endif
														</li>
														<li><a href="#" name="edit-img" rel="{{{ $midia->id }}}">Editar imagem</a></li>
														<li role="separator" class="divider"></li>
													</ul>
												</div>
												<a href="{{ action('MidiasController@getDeletar', array($midia->id)) }}" title="Deletar" alt="Deletar" class="btn btn-danger btn-xs" role="button" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
											</div>
										</div>
									</div>
								</div>
								@empty
								Nenhuma imagem inserada neste pagina.
								@endforelse
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edição de Imagem</h4>
			</div>
			{{ Form::open(array('action' => 'MidiasController@postEditar')) }}
			<div class="modal-body">
				<div class="form-group row">
					{{ Form::label('image', 'Imagem', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						{{ HTML::image(null, 'img_edit', array('id' => 'img_edit', 'class' => 'img-responsive thumbnail')) }}
					</div>
				</div>
				<div class="form-group row">
					{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						{{ Form::text('name', null, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Salvar Alteração</button>
			</div>
			{{ Form::close() }}
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