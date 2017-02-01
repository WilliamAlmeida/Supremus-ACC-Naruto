@extends('layouts.admin')

@section('title', 'Transações')
@section('sub_title', '<i class="fa fa-users fa-1x"></i> Transações')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('TransacoesController@getAdicionar') }}" alt="Adicionar Transação" title="Adicionar Transação"><i class="fa fa-plus fa-2x"></i></a>
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	{{ Session::get('message') }}
</div>
@endif

<!-- Advanced Tables -->
<div class="panel panel-default">
	<div class="panel-heading">
		Histórico de Transações
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>#</th>
						<th>Código da Transação</th>
						<th>Nome <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Status</th>
						<th>Valor</th>
						<th>Pontos</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>#</th>
						<th>Código da Transação</th>
						<th>Nome <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Status</th>
						<th>Valor</th>
						<th>Pontos</th>
						<th>Criado <i class="fa fa-info-circle" title="Hora-Minuto-Segundo Dia/Mês/Ano"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($transacoes as $key => $transacao)
					<tr>
						<td>{{ ++$key }}</td>
						@if($transacao->method == "PagSeguro")
						<td>{{{ $transacao->pagsegurotransacao->TransacaoID }}}</td>
						<td>{{{ $transacao->pagsegurotransacao->user->nickname or $transacao->pagsegurotransacao->user->name }}}</td>
						<td>{{{ $status['PagSeguro'][$transacao->pagsegurotransacao->status]['status'] or 'Desconhecido' }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status['PagSeguro'][$transacao->pagsegurotransacao->status]['descricao'] or 'Desconhecido' }}}"></i></td>
						<td>R$ {{{ number_format($transacao->pagsegurotransacao->NumItens*$configuracoes->cost_points, 2, ',', '.') }}}</td>
						<td>{{{ $transacao->pagsegurotransacao->NumItens }}}</td>
						<td>{{{ date_format(date_create($transacao->pagsegurotransacao->Data), 'h:i:s d/m/Y') }}}</td>
						<td>
							<a href="{{ action('TransacoesController@getEditar', array('id' => $transacao->pagsegurotransacao->TransacaoID, 'method' => $transacao->method)) }}" title="Editar Transação" alt="Editar Transação"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('PagseguroTransacoesController@getTransacao', $transacao->pagsegurotransacao->TransacaoID) }}" title="Visualizar Transação" alt="Visualizar Transação"><span class="glyphicon glyphicon-eye-open"></span></a>
						</td>
						@elseif($transacao->method == "Moip")
						<td>{{{ $transacao->moiptransacao->TransacaoID }}}</td>
						<td>{{{ $transacao->moiptransacao->user->nickname or $transacao->moiptransacao->user->name }}}</td>
						<td>{{{ $status['Moip'][$transacao->moiptransacao->status]['status'] or 'Desconhecido' }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status['Moip'][$transacao->moiptransacao->status]['descricao'] or 'Desconhecido' }}}"></i></td>
						<td>R$ {{{ number_format($transacao->moiptransacao->NumItens*$configuracoes->cost_points, 2, ',', '.') }}}</td>
						<td>{{{ $transacao->moiptransacao->NumItens }}}</td>
						<td>{{{ date_format(date_create($transacao->moiptransacao->Data), 'h:i:s d/m/Y') }}}</td>
						<td>
							<a href="{{ action('TransacoesController@getEditar', array('id' => $transacao->moiptransacao->TransacaoID, 'method' => $transacao->method)) }}" title="Editar Transação" alt="Editar Transação"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('MoipTransacoesController@getTransacao', $transacao->moiptransacao->TransacaoID) }}" title="Visualizar Transação" alt="Visualizar Transação"><span class="glyphicon glyphicon-eye-open"></span></a>
						</td>
						@else
						<td>{{{ $transacao->paypaltransacao->TransacaoID }}}</td>
						<td>{{{ $transacao->paypaltransacao->user->nickname or $transacao->paypaltransacao->user->name }}}</td>
						<td>{{{ $status['Moip'][$transacao->paypaltransacao->status]['status'] or 'Desconhecido' }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status['Moip'][$transacao->paypaltransacao->status]['descricao'] or 'Desconhecido' }}}"></i></td>
						<td>R$ {{{ number_format($transacao->paypaltransacao->NumItens*$configuracoes->cost_points, 2, ',', '.') }}}</td>
						<td>{{{ $transacao->paypaltransacao->NumItens }}}</td>
						<td>{{{ date_format(date_create($transacao->paypaltransacao->Data), 'h:i:s d/m/Y') }}}</td>
						<td>
							<a href="{{ action('TransacoesController@getEditar', array('id' => $transacao->paypaltransacao->TransacaoID, 'method' => $transacao->method)) }}" title="Editar Transação" alt="Editar Transação"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('PaypalTransacoesController@getTransacao', $transacao->paypaltransacao->TransacaoID) }}" title="Visualizar Transação" alt="Visualizar Transação"><span class="glyphicon glyphicon-eye-open"></span></a>
						</td>
						@endif
					</tr>
					@empty
					<tr>
						<td>Nenhuma transação foi encontrada!</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($transacoes))
			<p>
				{{ $transacoes->links() }}
			</p>
			@endif
		</div>

	</div>
</div>
<!--End Advanced Tables -->
@stop

@section('scripts')
{{ HTML::script('assets/plugins/dataTables/jquery.dataTables.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.responsive.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.select.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.colReorder.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.buttons.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/buttons.colVis.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.bootstrap.min.js') }}

{{ HTML::script('assets/js/dashboard/scriptDataTable.js', array('async' => 'async')) }}
@stop

@section('script-execute')

@stop