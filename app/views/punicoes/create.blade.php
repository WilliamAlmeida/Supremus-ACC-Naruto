	@extends('layouts.admin')

	@section('title', 'Punições')
	@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

	@section('styles')
	{{ HTML::style('assets/plugins/select2-3.5.4/select2.css', array('async' => 'async')) }}
	{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css', array('async' => 'async')) }}
	@stop

	@section('content')
	<a href="{{ action('BansController@getIndex') }}" alt="Voltar para lista de Punições" title="Voltar para lista de Punições"><i class="fa fa-arrow-left fa-2x"></i></a>
	<hr>
	@if(Session::get('message'))
	<div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Aviso!</strong>
		{{ Session::get('message') }}
	</div>
	@endif
	@if(isset($errors) && count($errors->punicao))
	<div class="alert alert-warning alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Aviso!</strong>
		@foreach ($errors->punicao->all('<li>:message</li>') as $message)
		{{$message}}
		@endforeach
	</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">
			Formulário de Punições
		</div>
		<div class="panel-body">

			{{ Form::model(array('action' => 'BansController@postEditar')) }}

			<fieldset class="form-group">
				<legend class="text-info h4">Punição</legend>
				<div class="form-group row">
					{{ Form::label('type', 'Tipo', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						{{ Form::select('type', $tipos, null, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="form-group row" name="accounts">
					{{ Form::label('account', 'Contas', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						{{ Form::select('account', $lista_contas, null, array('single', 'class' => 'form-control')) }}
					</div>
				</div>
				<div class="form-group row" name="players">
					{{ Form::label('player', 'Personagens', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						{{ Form::select('player', $lista_personagens, null, array('single', 'class' => 'form-control')) }}
					</div>
				</div>
				<div class="form-group row">
					{{ Form::label('permanet', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						<label class="c-input c-checkbox" style="font-weight:normal">
							{{ Form::checkbox('permanent', '1', false) }}
							<span class="c-indicator"></span>
							Permanente
						</label>
					</div>
				</div>
				<div class="form-group row">
					{{ Form::label('expires', 'Expira em', array('class' => 'col-lg-2 col-md-2 col-sm-12 col-xs-12 form-control-label')) }}
					<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
						<input type="time" placeholder="00:00" class="form-control" name="time" value="" id="time" data-mask="00:00">
					</div>
					<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
						<input type="date" placeholder="2015-01-01" class="form-control" name="expires" value="" id="expires" data-mask="0000-00-00">
					</div>
				</div>
				<div class="form-group row">
					{{ Form::label('comment', 'Comentário', array('class' => 'col-lg-2 form-control-label')) }}
					<div class="col-lg-10">
						{{ Form::textarea('comment', null, array('placeholder' => 'Digite aqui algum comentário.', 'class' => 'form-control')) }}
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
	{{ HTML::script('assets/js/jquery.mask.min.js') }}
	@stop

	@section('script-execute')
	<script type="text/javascript" async="async">
		$(document).ready(function(){
			$('select[name="type"]').select2({
				theme: "bootstrap",
				placeholder: "Selecione um tipo",
				maximumSelectionLength: 1,
				allowClear: true
			});
			$('select[name="account"]').select2({
				theme: "bootstrap",
				placeholder: "Selecione uma conta",
				maximumSelectionLength: 1,
				allowClear: true
			});
			$('select[name="player"]').select2({
				theme: "bootstrap",
				placeholder: "Selecione um personagem",
				maximumSelectionLength: 1,
				allowClear: true
			});

			if($('select[name=type]').val()==2){
				$('div[name=accounts]').addClass('hidden'); $('div[name=players]').removeClass('hidden');
				$('select[name=account]').prop('disabled', true);
				$('select[name=player]').prop('disabled', false);
			}else{
				$('div[name=accounts]').removeClass('hidden'); $('div[name=players]').addClass('hidden');
				$('select[name=account]').prop('disabled', false);
				$('select[name=player]').prop('disabled', true);
			}

			$('select[name=type]').on('change', function(){
				if($(this).val()==2){
					$('div[name=accounts]').addClass('hidden'); $('div[name=players]').removeClass('hidden');
					$('select[name=account]').prop('disabled', true);
					$('select[name=player]').prop('disabled', false);
				}else{
					$('div[name=accounts]').removeClass('hidden'); $('div[name=players]').addClass('hidden');
					$('select[name=account]').prop('disabled', false);
					$('select[name=player]').prop('disabled', true);
				}
			});
			
			if($('input:checkbox[name=permanent]').prop('checked')){
				$('input[name=time]').prop('readonly', true);
				$('input[name=expires]').prop('readonly', true);
			}else{
				$('input[name=time]').prop('readonly', false);
				$('input[name=expires]').prop('readonly', false);
			}

			$('input:checkbox[name=permanent]').on('click', function(){
				if($(this).prop('checked')){
					$('input[name=time]').prop('disabled', true);
					$('input[name=expires]').prop('disabled', true);
				}else{
					$('input[name=time]').prop('disabled', false);
					$('input[name=expires]').prop('disabled', false);
				}
			});
		});
</script>
@stop