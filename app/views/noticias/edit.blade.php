@extends('layouts.admin')

@section('title', 'Notícias')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css') }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css') }}
@stop

@section('content')
<a href="{{ action('NoticiasController@getIndex') }}" alt="Voltar para lista de Notícias" title="Voltar para lista de Notícias"><i class="fa fa-arrow-left fa-2x"></i></a>
<a href="{{ action('NoticiasController@getNoticia', array('id' => $noticia->slug)) }}" alt="Visualizar Notícia" title="Visualizar Notícia" target="view_news"><i class="fa fa-eye fa-2x"></i></a>
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	{{ Session::get('message') }}
</div>
@endif
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

				{{ Form::model(array('action' => 'NoticiasController@postEditar')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Notícia</legend>
					<div class="form-group row">
						{{ Form::label('title', 'Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('title', $noticia->title, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('description', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('description', $noticia->description, array('placeholder' => 'Digite aqui a notícia completa.', 'class' => 'form-control ckeditor')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('tags', 'Tags', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('tags', $noticia->tags, array('placeholder' => 'eletrônicos,móveis,...', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('marcacao', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<label class="c-input c-checkbox">
								{{ Form::checkbox('featured', '1', ($noticia->featured) ? true : false) }}
								<span class="c-indicator"></span>
								Destaque
							</label>
							<label class="c-input c-checkbox">
								{{ Form::checkbox('gallery', '1', ($noticia->gallery) ? true : false) }}
								<span class="c-indicator"></span>
								Galeria
							</label>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('news_categories', 'Categorias', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::select('news_categories[]', $lista_categorias, $categorias, array('id' => 'name', 'multiple', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>

				<fieldset class="form-group">
					<legend class="text-info h4">SEO</legend>
					<div class="form-group row">
						{{ Form::label('meta_title', 'Meta Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('meta_title', $noticia->meta_title, array('placeholder' => 'Titulo', 'class' => 'form-control', 'maxlength' => '63')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('meta_description', 'Meta Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('meta_description', $noticia->meta_description, array('placeholder' => 'Resumo da notícia', 'class' => 'form-control', 'maxlength' => '160')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('meta_keywords', 'Palavras Chave', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('meta_keywords', $noticia->meta_keywords, array('placeholder' => 'compras-online,futebol,saúde,...', 'class' => 'form-control')) }}
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
				Formulário de Notícias
			</div>
			<div class="panel-body">
				{{ Form::open(array('action' => array('MidiasController@getAdicionar'), 'files' => true)) }}

				{{ Form::hidden('id', $noticia->id, array('id' => 'id', 'class' => 'form-control')) }}
				{{ Form::hidden('name', $noticia->title, array('id' => 'name', 'class' => 'form-control')) }}

				{{ Form::hidden('type', 'noticias', array('id' => 'type', 'class' => 'form-control')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Imagem</legend>
					<div class="form-group row">
						{{ Form::label('path', 'Imagem', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::file('path[]', array('single', 'accept' => 'image/*', 'class' => 'form-control')) }}
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
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="{{ (count($noticia->midianoticia)) ? 'true' : 'false' }}" aria-controls="collapseOne">
									Imagens
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse {{ (count($noticia->midianoticia)) ? 'in' : null }}" role="tabpanel" aria-labelledby="headingOne">
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
								@forelse($noticia->midianoticia as $midia)
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
															@if($midia->capa) <a href="#!">Imagem ja está sendo usada como banner do noticia</a>
															@else <a href="{{action('MidiasController@getCapa', array($midia->id, $noticia->id))}}">Usar imagem como banner do noticia</a>
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
								Nenhuma imagem inserada nesta notícia.
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
						{{ HTML::image(null, 'img_edit', array('id' => 'img_edit', 'class' => 'img-responsive center-block')) }}
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