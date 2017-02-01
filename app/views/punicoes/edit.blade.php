@extends('layouts.admin')

@section('title', 'Punições')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')

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
					{{ $tipos[$punicao->type] }}
				</div>
			</div>
			<div class="form-group row">
				@if($punicao->type == 2)
				{{ Form::label('player', 'Personagem', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ $punicao->player->name or 'Desconhecido' }}
				</div>
				@elseif($punicao->type == 3)
				{{ Form::label('account', 'Usuário', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ $punicao->user->name or 'Desconhecido' }}
				</div>
				@elseif($punicao->type == 1)
				{{ Form::label('ip', 'IP', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					<span class="ip_address">{{{ $punicao->value or '000000000' }}}</span>
				</div>
				@else
				Não há informações para esse tipo de Ban.
				@endif
			</div>
			<div class="form-group row">
				{{ Form::label('permanent', 'Marcação', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					<label class="c-input c-checkbox" style="font-weight:normal">
						{{ Form::checkbox('permanent', '1', ($punicao->expires < 0) ? true : false) }}
						<span class="c-indicator"></span>
						Permanente
					</label>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('added', 'Punido em', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Helpers::formataData(date('Y-m-d h:i:s', $punicao->added)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('expires', 'Expira em', array('class' => 'col-lg-2 col-md-2 col-sm-12 col-xs-12 form-control-label')) }}
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
					<input type="time" placeholder="00:00" class="form-control" name="time" value="{{{ date('h:i', $punicao->expires) }}}" id="time" data-mask="00:00" {{{ ($punicao->expires < 0) ? 'readonly' : null }}}>
				</div>
				<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
					<input type="date" placeholder="2015-01-01" class="form-control" name="expires" value="{{{ date('Y-m-d', $punicao->expires) }}}" id="expires" data-mask="0000-00-00" {{{ ($punicao->expires < 0) ? 'readonly' : null }}}>
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('comment', 'Comentário', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::textarea('comment', $punicao->comment, array('placeholder' => 'Digite aqui algum comentário.', 'class' => 'form-control')) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Atualizar', ['class' => 'btn btn-primary']) }}

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
		if($("div[class='form-group row']").find('span[class=ip_address]').text()!=""){ $('.ip_address').mask('099.099.099.099'); }

		if($('input:checkbox[name=permanent]').prop('checked')){
			$('input[name=time]').prop('readonly', true);
			$('input[name=expires]').prop('readonly', true);
		}else{
			$('input[name=time]').prop('readonly', false);
			$('input[name=expires]').prop('readonly', false);
		}

		$('input:checkbox[name=permanent]').on('click', function(){
			if($(this).prop('checked')){
				$('input[name=time]').prop('readonly', true);
				$('input[name=expires]').prop('readonly', true);
			}else{
				$('input[name=time]').prop('readonly', false);
				$('input[name=expires]').prop('readonly', false);
			}
		});
	});
</script>
@stop