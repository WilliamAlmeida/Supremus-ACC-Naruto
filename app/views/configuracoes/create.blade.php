@extends('layouts.admin')

@section('title', 'Configurações')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ url('painel/configuracoes') }}" alt="Voltar para lista de Configurações" title="Voltar para lista de Configurações"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->configuracao))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->configuracao->all('<li>:message</li>') as $message)
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
				Formulário de Configurações
			</div>
			<div class="panel-body">

				{{ Form::open(array('action' => 'ConfiguracoesController@getAdicionar')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Web Site</legend>
					<div class="form-group row">
						{{ Form::label('title', 'Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('title', null, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('description', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('description', null, array('placeholder' => 'Descrição', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('keywords', 'Palavras Chave', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('keywords', null, array('placeholder' => 'esporte,futebol,times,...', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('founded', 'Data de Criação do Servidor', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<input type="date" placeholder="1900-01-31" class="form-control" name="founded" value="" id="founded" data-mask="0000-00-00">
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('cost_points', 'Preço de cada Diamante (Reais)', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('cost_points', null, array('placeholder' => '0,00', 'class' => 'form-control', 'min' => 0,  'data-mask' => '0,00')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Jogo</legend>
					<div class="form-group row">
						{{ Form::label('level', 'Level Inicial', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('level', 0, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Contatos</legend>
					<div class="form-group row">
						{{ Form::label('email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::email('email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('facebook', 'Facebook', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('facebook', null, array('type' => 'href', 'placeholder' => 'https://www.facebook.com/fan-page', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('twitter', 'Twitter', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('twitter', null, array('type' => 'href', 'placeholder' => 'https://twitter.com/Loren__Art', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">PagSeguro</legend>
					<div class="form-group row">
						{{ Form::label('pagseguro_email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::email('pagseguro_email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('pagseguro_token', 'Token', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('pagseguro_token', null, array('placeholder' => '3294083ADFS6F7512ADDA2', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Moip</legend>
					<div class="form-group row">
						{{ Form::label('moip_email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::email('moip_email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('moip_key', 'Key', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('moip_key', null, array('placeholder' => '3294083ADFS6F7512ADDA2', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('moip_token', 'Token', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('moip_token', null, array('placeholder' => '2H3G42JH3G5K1G2J3K', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Paypal</legend>
					<div class="form-group row">
						{{ Form::label('paypal_client_id', 'Cliente ID', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('paypal_client_id', null, array('placeholder' => '3294083ADFS6F7512ADDA2', 'class' => 'form-control', 'disabled')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('paypal_secret', 'Secret', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('paypal_secret', null, array('placeholder' => '2H3G42JH3G5K1G2J3K', 'class' => 'form-control', 'disabled')) }}
						</div>
					</div>
				</fieldset>

				{{ Form::submit('Cadastrar', ['class' => 'btn btn-default']) }}

				{{ Form::close() }}
			</div>
		</div>
	</div>

	<div role="tabpanel" class="tab-pane fade" id="galeria">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Formulário de Configurações
			</div>
			<div class="panel-body">
				<div class="alert alert-warning" role="alert">
					<strong>Aviso!</strong> O Banner e o Icone do site poderam ser inseridas após o registro das informações desta página.
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
{{ HTML::script('assets/js/jquery.mask.min.js') }}
{{ HTML::script('assets/plugins/select2-3.5.4/select2.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/select2-3.5.4/select2_locale_pt-BR.js', array('async' => 'async')) }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(window).load(function(){
		$('input[id=keywords]').select2({
			theme: "bootstrap",
			tags: [],
			tokenSeparators: [','],
			maximumSelectionLength: 4
		});
	});
</script>
@stop