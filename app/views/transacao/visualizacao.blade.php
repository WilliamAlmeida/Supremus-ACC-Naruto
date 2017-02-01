@extends('layouts.admin')

@section('title', 'Transação')
@section('sub_title', '<i class="fa fa-users fa-1x"></i> Transação')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('TransacoesController@getIndex') }}" alt="Voltar para lista de Transações" title="Voltar para lista de Transações"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#transacao" aria-controls="transacao" role="tab" data-toggle="tab">Transação</a></li>
	<li role="presentation"><a href="#user" aria-controls="user" role="tab" data-toggle="tab">Conta</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active" id="transacao">
		<div class="panel panel-default">
			<div class="panel-body">
				@if(!empty($transacao))
				<div class="table-responsive">
					<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
						<tbody>
							<tr>
								<th>Código da Transação</th>
								<td>{{{ $transacao->TransacaoID }}}</td>
							</tr>
							<tr>
								<th>Status</th>
								<td>{{{ $status[$transacao->status]['status'] or 'Desconhecido' }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status[$transacao->status]['descricao'] or 'Desconhecido' }}}"></i></td>
							</tr>
							<tr>
								<th>Valor</th>
								<td>R$ {{{ $transacao->NumItens*$configuracoes->cost_points }}}</td>
							</tr>
							<tr>
								<th>Pontos</th>
								<td>{{{ $transacao->NumItens }}} pontos</td>
							</tr>
							<tr>
								<th>Criado</th>
								<td>{{{ $transacao->Data }}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="table-responsive">
					<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
						<tbody>
							<tr>
								<th>Nome</th>
								<td>{{{ (!empty($transacao->CliNome)) ? $transacao->CliNome : 'Desconhecido' }}}</td>
							</tr>
							<tr>
								<th>E-mail</th>
								<td>{{{ $transacao->CliEmail }}}</td>
							</tr>
							<tr>
								<th>Telefone</th>
								<td><span class="telefone">{{{ (!empty($transacao->CliTelefone)) ? $transacao->CliTelefone : 'Desconhecido' }}}</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				@if($transacao->CliCEP)
				<div class="table-responsive">
					<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
						<tbody>
							<tr>
								<th>CEP</th>
								<td>{{{ $transacao->CliCEP }}}</td>
							</tr>
							<tr>
								<th>Endereço</th>
								<td>{{{ $transacao->CliEndereco }}}</td>
							</tr>
							<tr>
								<th>Bairro</th>
								<td>{{{ $transacao->CliBairro }}}</td>
							</tr>
							<tr>
								<th>Cidade</th>
								<td>{{{ $transacao->CliCidade }}}</td>
							</tr>
							<tr>
								<th>Estado</th>
								<td>{{{ $transacao->CliEstado }}}</td>
							</tr>
							<tr>
								<th>Número</th>
								<td>{{{ $transacao->CliNumero }}}</td>
							</tr>
							<tr>
								<th>Complemento</th>
								<td>{{{ $transacao->CliComplemento }}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				@endif
				@else
				Transação não encontrada!
				@endif
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="user">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($transacao->user)
				<div class="table-responsive">
					<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
						<tbody>
							<tr>
								<th>Usuário</th>
								<td><a href="{{ action('UsersController@getConta', $transacao->user->id) }}" title="Visualizar Usuário" alt="Visualizar Usuário" target="view_user">{{{ $transacao->user->name }}}</a></td>
							</tr>
							<tr>
								<th>Nickname</th>
								<td>{{{ $transacao->user->nickname }}}</td>
							</tr>
							<tr>
								<th>E-mail</th>
								<td>{{{ $transacao->user->email }}}</td>
							</tr>
							<tr>
								<th>Status da Conta</th>
								<td>{{ ($transacao->user->premdays>0) ? 'Vip' : 'Normal' }}</td>
							</tr>
							<tr>
								<th>Grupo</th>
								<td>{{ $grupos[$transacao->user->type] }}</td>
							</tr>
						</tbody>
					</table>
				</div>
				@else
				Usuário não encontrado!
				@endif
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/js/jquery.mask.min.js', array('async' => 'async')) }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(window).load(function(){
		if($('span.telefone').text() != "Desconhecido"){
			$('span.telefone').mask('(00) 000000000');
		}
	});
</script>
@stop