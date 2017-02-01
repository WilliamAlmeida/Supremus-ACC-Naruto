@extends('layouts.admin')

@section('title', 'Dashboard')
@section('sub_title', '<i class="fa fa-dashboard fa-1x"></i> Dashboard')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	{{ Session::get('message') }}
</div>
@endif

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			5 Ultimos Usuários Registrados
		</div>
		<div class="panel-body">
			@if($usuarios->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Criado <i class="fa fa-info-circle" title="Dia/Mês/Ano Hora-Minuto-Segundo"></i></th>
							<th>Último Login <i class="fa fa-info-circle" title="Dia/Mês/Ano Hora-Minuto-Segundo"></i></th>
						</tr>
					</thead>
					<tbody>
						@foreach($usuarios as $conta)
						<tr>
							<td><a href="{{ action('UsersController@getConta', array('id' => $conta->id)) }}" target="view_account" class="{{{ ($conta->online) ? 'text-success' : 'text-danger' }}}" alt="Visualizar Conta {{ $conta->name }}" title="Visualizar Conta {{ $conta->name }}">{{ $conta->nickname or $conta->name }}</a></td>
							<td>{{ date('d/m/Y h:i:s', $conta->created) }}</td>
							<td>{{ date('d/m/Y h:i:s', $conta->lastday) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			Nenhum conta foi encontrado!
			@endif
		</div>
	</div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			5 Ultimos Personagens Criados
		</div>
		<div class="panel-body">
			@if($players->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Criado <i class="fa fa-info-circle" title="Dia/Mês/Ano Hora-Minuto-Segundo"></i></th>
						</tr>
					</thead>
					<tbody>
						@foreach($players as $personagem)
						<tr>
							<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $personagem->id)) }}" target="view_player" class="{{{ ($personagem->online) ? 'text-success' : 'text-danger' }}}" alt="Visualizar Personagem {{ $personagem->name }}" title="Visualizar Personagem {{ $personagem->name }}">{{ $personagem->name }}</a></td>
							<td>{{ date('d/m/Y h:i:s', $personagem->created) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			Nenhum personagem foi encontrado!
			@endif
		</div>
	</div>
</div>

<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			Transações
		</div>
		<div class="panel-body">
			<p class="h4" style="margin-top:0;">Transações deste Mês</p>
			@if($transacoes['transacoes']->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="">
					<tr>
						<th>
							Quantidade:
						</th>
						<td>
							{{ ($transacoes['quant']) ? $transacoes['quant'] : 0 }}
						</td>
					</tr>
					<tr>
						<th>
							Valor Total:
						</th>
						<td>
							R$ {{ $transacoes['total'] }}
						</td>
					</tr>
				</table>
			</div>
			<p class="h4">10 Ultimas Transações</p>
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="">
					<thead>
						<tr>
							<th>Forma de Pagamento</th>
							<th>Nome</th>
							<th>Criado <i class="fa fa-info-circle" title="Dia/Mês/Ano Hora-Minuto-Segundo"></i></th>
							<th>Ação</th>
						</tr>
					</thead>
					<tbody>
						@foreach($transacoes['transacoes'] as $transacao)
						<tr>
							<td>{{ $transacao->method }}</td>
							<td><a href="{{ action('UsersController@getConta', array('id' => $transacao->user->id)) }}" target="view_account" class="{{{ ($transacao->user->online) ? 'text-success' : 'text-danger' }}}" alt="Visualizar Conta {{ $transacao->user->name }}" title="Visualizar Conta {{ $transacao->user->name }}">{{ $transacao->user->nickname or $transacao->user->name }}</a></td>
							<td>{{ date('d/m/Y h:i:s', $transacao->date) }}</td>
							@if($transacao->method == "PagSeguro")
							<td>
								<a href="{{ action('PagseguroTransacoesController@getTransacao', $transacao->pagsegurotransacao->TransacaoID) }}" target="view_transition" title="Visualizar Transação" alt="Visualizar Transação"><span class="glyphicon glyphicon-eye-open"></span></a>
							</td>
							@elseif($transacao->method == "Moip")
							<td>
								<a href="{{ action('MoipTransacoesController@getTransacao', $transacao->moiptransacao->TransacaoID) }}" target="view_transition" title="Visualizar Transação" alt="Visualizar Transação"><span class="glyphicon glyphicon-eye-open"></span></a>
							</td>
							@else
							<td>
								<a href="{{ action('PaypalTransacoesController@getTransacao', $transacao->paypaltransacao->TransacaoID) }}" target="view_transition" title="Visualizar Transação" alt="Visualizar Transação"><span class="glyphicon glyphicon-eye-open"></span></a>
							</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			Nenhuma transação foi encontrada!
			@endif
		</div>
	</div>
</div>

<!-- <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			
		</div>
		<div class="panel-body">
		</div>
	</div>
</div> -->
@stop

@section('scripts')
{{ HTML::script('assets/plugins/dataTables/jquery.dataTables.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.responsive.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.select.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.bootstrap.min.js', array('async' => 'async')) }}

{{ HTML::script('assets/js/scriptDataTable.js', array('async' => 'async')) }}
@stop

@section('script-execute')

@stop