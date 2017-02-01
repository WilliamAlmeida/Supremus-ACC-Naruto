@extends('layouts.admin')

@section('title', 'Configurações')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

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
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong> {{ Session::get('message') }}
</div>
@endif

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Informações</a></li>
	<li role="presentation"><a href="#galeria" aria-controls="galeria" role="tab" data-toggle="tab">Imagens</a></li>
	<li role="presentation"><a href="#acoes" aria-controls="acoes" role="tab" data-toggle="tab">Ações</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="info">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Formulário de Configurações
			</div>
			<div class="panel-body">

				{{ Form::model(array('action' => 'ConfiguracoesController@postEditar')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">Web Site</legend>
					<div class="form-group row">
						{{ Form::label('title', 'Titulo', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('title', $configuracao->title, array('placeholder' => 'Titulo', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('description', 'Descrição', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::textarea('description', $configuracao->description, array('placeholder' => 'Descrição', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('keywords', 'Palavras Chave', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('keywords', $configuracao->keywords, array('placeholder' => 'esporte,futebol,times,...', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('founded', 'Data de Criação do Servidor', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							<input type="date" placeholder="1900-01-31" class="form-control" name="founded" value="{{{ date_format(date_create($configuracao->founded), 'Y-m-d') }}}" id="founded" data-mask="0000-00-00">
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('cost_points', 'Preço de cada Diamante (Reais)', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('cost_points', $configuracao->cost_points, array('placeholder' => '0,00', 'class' => 'form-control', 'min' => 0,  'data-mask' => '0,00')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Jogo</legend>
					<div class="form-group row">
						{{ Form::label('level', 'Level Inicial', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('level', $configuracao->level, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Contatos</legend>
					<div class="form-group row">
						{{ Form::label('email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::email('email', $configuracao->email, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('facebook', 'Facebook', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('facebook', $configuracao->facebook, array('type' => 'href', 'placeholder' => 'https://www.facebook.com/fan-page', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('twitter', 'Twitter', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('twitter', $configuracao->twitter, array('type' => 'href', 'placeholder' => 'https://twitter.com/Loren__Art', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">PagSeguro</legend>
					<div class="form-group row">
						{{ Form::label('pagseguro_email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::email('pagseguro_email', $configuracao->pagseguro_email, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('pagseguro_token', 'Token', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('pagseguro_token', $configuracao->pagseguro_token, array('placeholder' => '3294083ADFS6F7512ADDA2', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Moip</legend>
					<div class="form-group row">
						{{ Form::label('moip_email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::email('moip_email', $moip->receiver, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('moip_key', 'Key', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('moip_key', $moip->key, array('placeholder' => '3294083ADFS6F7512ADDA2', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('moip_token', 'Token', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('moip_token', $moip->token, array('placeholder' => '2H3G42JH3G5K1G2J3K', 'class' => 'form-control')) }}
						</div>
					</div>
				</fieldset>
				<fieldset class="form-group">
					<legend class="text-info h4">Paypal</legend>
					<div class="form-group row">
						{{ Form::label('paypal_client_id', 'Cliente ID', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('paypal_client_id', $configuracao->paypal_client_id, array('placeholder' => '3294083ADFS6F7512ADDA2', 'class' => 'form-control', 'disabled')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('paypal_secret', 'Secret', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::text('paypal_secret', $configuracao->paypal_secret, array('placeholder' => '2H3G42JH3G5K1G2J3K', 'class' => 'form-control', 'disabled')) }}
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
				Formulário de Configurações
			</div>
			<div class="panel-body">
				@if($background==null)
				{{ Form::open(array('action' => array('MidiasController@getAdicionar'), 'files' => true)) }}

				{{ Form::hidden('id', $configuracao->id, array('id' => 'id', 'class' => 'form-control')) }}
				{{ Form::hidden('name', 'Background', array('id' => 'name', 'class' => 'form-control')) }}

				{{ Form::hidden('type', 'configuracoes', array('id' => 'type', 'class' => 'form-control')) }}
				<fieldset class="form-group">
					<legend class="text-info h4">Background</legend>
					<div class="form-group row">
						{{ Form::label('path', 'Background', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::file('path[]', array('single', 'accept' => 'image/*', 'class' => 'form-control')) }}
							<span class="center-block text-info"><small>Tamanho recomendado: 1366 x 768 pixels</small></span>
						</div>
					</div>
				</fieldset>
				{{ Form::submit('Inserir', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}
				@else
				<p>Background já foi setado, para subir outro é necessário deleta-lo antes.</p>
				@endif

				<hr>
				@if($banner==null)
				{{ Form::open(array('action' => array('MidiasController@getAdicionar'), 'files' => true)) }}

				{{ Form::hidden('id', $configuracao->id, array('id' => 'id', 'class' => 'form-control')) }}
				{{ Form::hidden('name', 'Banner', array('id' => 'name', 'class' => 'form-control')) }}

				{{ Form::hidden('type', 'configuracoes', array('id' => 'type', 'class' => 'form-control')) }}
				<fieldset class="form-group">
					<legend class="text-info h4">Banner</legend>
					<div class="form-group row">
						{{ Form::label('path', 'Banner', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::file('path[]', array('single', 'accept' => 'image/*', 'class' => 'form-control')) }}
							<span class="center-block text-info"><small>Tamanho recomendado: 1024 x 300 pixels</small></span>
						</div>
					</div>
				</fieldset>
				{{ Form::submit('Inserir', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}
				@else
				<p>Banner já foi setado, para subir outro é necessário deleta-lo antes.</p>
				@endif

				<hr>

				@if($favicon==null)
				{{ Form::open(array('action' => array('MidiasController@getAdicionar'), 'files' => true)) }}

				{{ Form::hidden('id', $configuracao->id, array('id' => 'id', 'class' => 'form-control')) }}
				{{ Form::hidden('name', 'Favicon', array('id' => 'name', 'class' => 'form-control')) }}

				{{ Form::hidden('type', 'configuracoes', array('id' => 'type', 'class' => 'form-control')) }}
				<fieldset class="form-group">
					<legend class="text-info h4">Favicon</legend>
					<div class="form-group row">
						{{ Form::label('path', 'Favicon', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::file('path[]', array('single', 'accept' => 'image/*', 'class' => 'form-control')) }}
							<span class="center-block text-info"><small>Tamanho recomendado: 310 x 310 pixels</small></span>
						</div>
					</div>
				</fieldset>
				{{ Form::submit('Inserir', ['class' => 'btn btn-primary']) }}

				{{ Form::close() }}
				@else
				<p>Favicon já foi setado, para subir outro é necessário deleta-lo antes.</p>
				@endif
				
				<hr>

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-primary">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="{{ (count($configuracao->midiaconfiguracao)) ? 'true' : 'false' }}" aria-controls="collapseOne">
									Imagens
								</a>
							</h4>
						</div>

						<div id="collapseOne" class="panel-collapse collapse {{ (count($configuracao->midiaconfiguracao)) ? 'in' : null }}" role="tabpanel" aria-labelledby="headingOne">
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
								@forelse($configuracao->midiaconfiguracao as $midia)
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="thumbnail">
										{{ HTML::image(str_replace('-original', '-thumbnail', $midia->path), $midia->name, array('title' => $midia->name, 'class' => 'img-responsive thumbnail')) }}
										<div class="caption {{ ($midia->capa) ? 'bg-warning' : null }}">
											<h5>{{{ $midia->name }}}</h5>
											<div class="center-block">
												<a href="{{ action('MidiasController@getDeletar', array($midia->id)) }}" title="Deletar" alt="Deletar" class="btn btn-danger btn-xs" role="button" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
											</div>
										</div>
									</div>
								</div>
								@empty
								Nenhuma imagem inserada no site.
								@endforelse
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>

	<div role="tabpanel" class="tab-pane fade" id="acoes">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Ações do Jogo
			</div>
			<div class="panel-body">
				<fieldset class="form-group">
					<legend class="text-info h4">Resetar Conta/Servidor</legend>
					{{ Form::open(array('action' => array('ConfiguracoesController@postResetar'), 'class' => 'form', 'name' => 'reset_what')) }}

					<div class="form-group row">
						{{ Form::label('type', 'Resetar o que?', array('class' => 'col-lg-4 form-control-label')) }}
						<div class="col-lg-8">
							<label style="font-weight:normal">{{ Form::radio('type', '1', true) }} Conta</label>
							<label style="font-weight:normal">{{ Form::radio('type', '2') }} Servidor</label>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('contas', 'Conta Registradas:', array('class' => 'col-lg-4 form-control-label')) }}
						<div class="col-lg-8">
							{{ Form::select('contas', $contas, null, array('single', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('recover', 'Deseja devolver os Pontos gastos pelos jogadores?', array('class' => 'col-lg-4 form-control-label')) }}
						<div class="col-lg-8">
							<label style="font-weight:normal">{{ Form::radio('recover', '1', true) }} Sim</label>
							<label style="font-weight:normal">{{ Form::radio('recover', '2') }} Não</label>
						</div>
					</div>
					{{ Form::submit('Resetar', ['class' => 'btn btn-primary']) }}

					{{ Form::close() }}
				</fieldset>
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
		$('select[name="contas"]').select2({
			theme: "bootstrap",
			placeholder: "Selecione um personagem",
			maximumSelectionLength: 1,
			allowClear: true
		});

		var form = "form[name='reset_what']";
		$(form+" input:radio[name=type]").on('click', function(){
			if($(this).val()==1){
				$(form+' select[name=contas]').prop('disabled', false);
			}else{
				$(form+' select[name=contas]').prop('disabled', true);
			}
		});

		$(form).submit(function(e){
			if(!confirm('Deseja mesmo resetar?')){
				e.preventDefault();

			}
		});

	});
</script>
@stop