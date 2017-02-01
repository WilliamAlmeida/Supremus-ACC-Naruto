@extends('layouts.admin')

@section('title', 'Cupons')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')

@stop

@section('content')
<a href="{{ action('CouponsController@getIndex') }}" alt="Voltar para lista de Cupons" title="Voltar para lista de Cupons"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->cupom))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->cupom->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		Formulário de Cupons
	</div>
	<div class="panel-body">

		{{ Form::open(array('action' => 'CouponsController@getAdicionar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Cupom</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('name', null, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('code', 'Cupom', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('code', null, array('placeholder' => 'Cupom', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('validate', 'Validade', array('class' => 'col-lg-2 col-md-2 col-sm-12 col-xs-12 form-control-label')) }}
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
					<input type="time" placeholder="00:00" class="form-control" name="time" value="" id="time" data-mask="00:00">
				</div>
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
					<input type="date" placeholder="2015-01-01" class="form-control" name="validate" value="" id="validate" data-mask="0000-00-00">
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('limit', 'Limite de Uso', array('class' => 'col-lg-2 form-control-label', 'name' => 'label_count')) }}
				<div class="col-lg-10">
					{{ Form::number('limit', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('type', 'Tipo', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('type', $tipos, null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('count', 'Quantidade', array('class' => 'col-lg-2 form-control-label', 'name' => 'label_count')) }}
				<div class="col-lg-10">
					{{ Form::number('count', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('item', 'Item ID', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::number('item', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0, 'disabled')) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Cadastrar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}

	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/js/jquery.mask.min.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('select[name=type]').on('change', function(){
			if($(this).val()==1){
				$('input[name=item]').prop('disabled', false);
			}else{
				$('input[name=item]').prop('disabled', true);
			}
		});
	});
</script>
@stop