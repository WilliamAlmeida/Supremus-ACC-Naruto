@extends('layouts.integracao')

@section('title', 'Integração')
@section('sub_title', '<i class="fa fa-wrench fa-1x"></i> Integração')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<hr>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			Informações
		</div>
		<div class="panel-body">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Alerta!</strong>
				Só utilize estas ações se o seu servidor estiver desligado.
			</div>

			<hr>

			<p>
				A ação de <strong>"Configurar o Banco de Dados"</strong> servira para alterar e criar algumas tabelas necessárias para que o sistema funcione perfeitamente.
			</p>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<strong>Aviso!</strong>
				É necessário que tenha o banco de dados préviamente conectado ao sistema e com as seguintes tabelas já criadas para que utilize está ação sem que ocora nenhum erro durante a configuração.
				<br/><br/>
				<strong>Tabelas:</strong>
				<ul>
					<li>accounts (contas)</li>
					<li>players (personagens)</li>
				</ul>
			</div>

			<hr>

			<p>
				A ação de <strong>"Converte Senha para Sha1"</strong> servira para alterar todas as senhas dos usuários para sha1 caso elas estejam registradas como plain (sem criptografia ou codificação alguma);
			</p>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<strong>Aviso!</strong>
				Após o uso desta ação, altere em seu arquivo 'config.lua' na linha <kbd>encryptionType</kbd> para <kbd>encryptionType = "sha1"</kbd>.
			</div>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<strong>Alerta!</strong>
				Só use esta ação caso as senhas não estejam salvas com a utilização da criptografia sha1.
			</div>

		</div>
	</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			Ações
		</div>
		<div class="panel-body">
			<a href="{{ action('IntegracoesController@getDatabase') }}" type="button" class="btn btn-primary btn-xs btn-block" name="btn_database">Configurar o Banco de Dados</a>
			<a href="{{ action('IntegracoesController@getSenha') }}" type="button" class="btn btn-primary btn-xs btn-block" name="btn_database">Converte Senha para Sha1</a>
			<a href="{{ action('HomeController@index') }}" type="button" class="btn btn-primary btn-xs btn-block" name="btn_database">Acessar o Sistema</a>
		</div>
	</div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			Registro de Logs da Integração
		</div>
		<div class="panel-body">
			@if(Session::get('message'))
			<ol>
				@foreach(Session::get('message') as $msg)
				<li>{{ $msg }}</li>
				@endforeach
			</ol>
			@else
			Nenhum até o momento.
			@endif
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/dataTables/jquery.dataTables.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.responsive.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.select.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.bootstrap.js', array('async' => 'async')) }}

{{ HTML::script('assets/js/scriptDataTable.js', array('async' => 'async')) }}
@stop

@section('script-execute')

@stop