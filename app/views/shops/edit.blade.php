@extends('layouts.admin')

@section('title', 'Itens')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')

@stop

@section('content')
<a href="{{ action('ShopsController@getIndex') }}" alt="Voltar para lista de Itens" title="Voltar para lista de Itens"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	{{ Session::get('message') }}
</div>
@endif
@if(isset($errors) && count($errors->item))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->item->all('<li>:message</li>') as $message)
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
				Formulário de Itens
			</div>
			<div class="panel-body">

				{{ Form::model(array('action' => 'ShopsController@postEditar')) }}

				{{ Form::hidden('type', 5, array('class' => 'form-control')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Item</legend>
					<div class="form-group row">
						{{ Form::label('category', 'Categoria', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::select('category', $categorias, $item->category, ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('item', 'ID', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('item', $item->item, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>ID do item no jogo.</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('name', $item->name, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('description', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('description', $item->description, array('placeholder' => 'Digite aqui algo sobre o item.', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('points', 'Pontos', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('points', $item->points, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('points_off', 'Pontos Off', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('points_off', $item->points_off, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>Isso informara no item (Este item custava "Pontos", agora custa "Pontos Off".</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('count', 'Quantidade', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('count', $item->count, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>Quantidade de itens que será dado ao jogador quando for comprado.</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('stock', 'Estoque', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('stock', $item->stock, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>Quantos itens poderam ser vendidos na loja.</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('featured', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<label class="c-input c-checkbox">
								{{ Form::checkbox('featured', '1', ($item->featured) ? true : false) }}
								<span class="c-indicator"></span>
								Destaque
							</label>
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
				Formulário de Itens
			</div>
			<div class="panel-body">
				@if($item->midiashopoffer->isEmpty())
				{{ Form::open(array('action' => array('MidiasController@getAdicionar'), 'files' => true)) }}

				{{ Form::hidden('id', $item->id, array('id' => 'id', 'class' => 'form-control')) }}
				{{ Form::hidden('name', $item->name, array('id' => 'name', 'class' => 'form-control')) }}

				{{ Form::hidden('type', 'itens', array('id' => 'type', 'class' => 'form-control')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Imagem</legend>
					<div class="form-group row">
						{{ Form::label('path', 'Imagem', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::file('path[]', array('single', 'accept' => 'image/*', 'class' => 'form-control')) }}
							<span class="center-block text-info"><small>Tamanho recomendado: 64 x 64 pixels</small></span>
						</div>
					</div>
				</fieldset>

				{{ Form::submit('Inserir', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}
				@else
				<p>Imagem já foi setada, para subir outra é necessário deleta-la antes.</p>
				@endif
				
				<hr>

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="{{ (count($item->midiashopoffer)) ? 'true' : 'false' }}" aria-controls="collapseOne">
									Imagens
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse {{ (count($item->midiashopoffer)) ? 'in' : null }}" role="tabpanel" aria-labelledby="headingOne">
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
								@forelse($item->midiashopoffer as $midia)
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
															@if($midia->capa) <a href="#!">Imagem ja está sendo usada como banner do item</a>
															@else <a href="{{action('MidiasController@getCapa', array($midia->id, $item->id))}}">Usar imagem como banner do item</a>
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
								Nenhuma imagem inserada neste item.
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

@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		if($('select[name=category]').val()==2){
			$('input[name=item]').prop('readonly', true).val('0');
		}

		$('select[name=category]').on('change', function(){
			var item = 'input[name=item]';
			if($(this).val()==1){
				$(item).prop('readonly', false).val($(item).attr('rel'));
			}else{
				$(item).prop('readonly', true).attr('rel', $(item).val()).val('0');
			}
		});
	});
</script>
@stop