@extends('layouts.admin')

@section('title', 'Transações')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css') }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css') }}
@stop

@section('content')
<a href="{{ action('TransacoesController@getIndex') }}" alt="Voltar para lista de Transações" title="Voltar para lista de Transações"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->transacao))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->transacao->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-primary">
	<div class="panel-heading">
		Formulário de Transações
	</div>
	<div class="panel-body">

		{{ Form::open(array('action' => 'TransacoesController@getAdicionar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Transação</legend>
			{{ Form::hidden('status', null) }}
			<div class="form-group row">
				{{ Form::label('TransacaoID', 'Código da Transação', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('TransacaoID', null, array('placeholder' => 'SHFJ2304-DA3243FA-F234AHF', 'class' => 'form-control', 'maxlength' => '40')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('method', 'Método de Pagamento', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('method', $payments, null, array('id' => 'method', 'single', 'class' => 'form-control')) }}
				</div>
			</div>
			@forelse($status as $tipo => $estatus)
			<div class="form-group row hidden" name="payments" id="{{ $tipo }}">
				{{ Form::label('$tipo', 'Status do '.$tipo, array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select($tipo, $status[$tipo], null, array('id' => $tipo, 'single', 'class' => 'form-control')) }}
				</div>
			</div>
			@empty
			@endforelse
			<div class="form-group row">
				{{ Form::label('Anotacao', 'Usuário (Conta)', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('Anotacao', $lista_contas, null, array('id' => 'Anotacao', 'single', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('NumItens', 'Pontos', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::number('NumItens', null, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('Data', 'Data', array('class' => 'col-lg-2 col-md-2 col-sm-12 col-xs-12 form-control-label')) }}
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
					<input type="time" placeholder="00:00" class="form-control" name="time" value="" id="time" data-mask="00:00">
				</div>
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
					<input type="date" placeholder="2015-01-01" class="form-control" name="Data" value="" id="Data" data-mask="0000-00-00">
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Cadastrar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}

	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/select2-3.5.4/select2.js') }}
{{ HTML::script('assets/plugins/select2-3.5.4/select2_locale_pt-BR.js') }}
{{ HTML::script('assets/plugins/bootstrap/maxlength/bootstrap-maxlength.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('select[name="Anotacao"]').select2({
			theme: "bootstrap",
			placeholder: "Selecione um Usuário",
			maximumSelectionLength: 1,
			allowClear: true
		});
		$('input[name=TransacaoID]').maxlength();

		$('select[name="method"').on('change', function(){
			$('div[name="payments"]').addClass('hidden');
			$('div[id="'+$(this).val()+'"').removeClass('hidden');
		});
	});
	$(window).load(function(){
		$('div[name="payments"]').addClass('hidden');
		$('div[id="'+$('select[name="method"]').val()+'"').removeClass('hidden');
	});
</script>
@stop