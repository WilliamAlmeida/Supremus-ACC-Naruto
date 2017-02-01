@extends('layouts.admin')

@section('title', 'Itens')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')

@stop

@section('content')
<a href="{{ action('ShopsController@getIndex') }}" alt="Voltar para lista de Itens" title="Voltar para lista de Itens"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
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

				{{ Form::open(array('action' => 'ShopsController@getAdicionar')) }}

				{{ Form::hidden('type', 5, array('class' => 'form-control')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Item</legend>
					<div class="form-group row">
						{{ Form::label('category', 'Categoria', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::select('category', $categorias, 1, ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('item', 'ID', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('item', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>ID do item no jogo.</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('name', null, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('description', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('description', null, array('placeholder' => 'Digite aqui algo sobre o item.', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('points', 'Pontos', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('points', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('points_off', 'Pontos Off', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('points_off', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>Isso informara no item (Este item custava "Pontos", agora custa "Pontos Off".</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('count', 'Quantidade', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('count', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>Quantidade de itens que será dado ao jogador quando for comprado.</small></span>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('stock', 'Estoque', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('stock', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
							<span class="text-muted"><small>Quantos itens poderam ser vendidos na loja.</small></span>
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
				Formulário de Itens
			</div>
			<div class="panel-body">
				<div class="alert alert-warning" role="alert">
					<strong>Aviso!</strong> O Banner podera ser inserido após o registro das informações desta deste item.
				</div>
			</div>
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