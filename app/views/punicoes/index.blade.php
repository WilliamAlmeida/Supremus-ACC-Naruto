@extends('layouts.admin')

@section('title', 'Punições')
@section('sub_title', '<i class="fa fa-list fa-1x"></i> Punições')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('BansController@getAdicionar') }}" alt="Adicionar Punição" title="Adicionar Punição"><i class="fa fa-plus fa-2x"></i></a>
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
		Lista de Punições
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>A/P/I <i class="fa fa-info-circle" title="O que ou quem foi banido (Conta/Personagem/IP)"></i></th>
						<th>Tipo</th>
						<th>Status</th>
						<th>Banido por <i class="fa fa-info-circle" title="Qual usuário que efetuou a punição"></i></th>
						<th>Expira em <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Banido em <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>A/P/I <i class="fa fa-info-circle" title="O que ou quem foi banido (Conta/Personagem/IP)"></i></th>
						<th>Tipo</th>
						<th>Status</th>
						<th>Banido por <i class="fa fa-info-circle" title="Qual usuário que efetuou a punição"></i></th>
						<th>Expira em <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Banido em <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($punicoes as $punicao)
					<tr>
						<td>
							@if($punicao->type==3)
							{{{ $punicao->user->name or 'Desconhecido' }}}
							@elseif($punicao->type==2)
							{{{ $punicao->player->name or 'Desconhecido' }}}
							@else
							<span class="ip_address">{{{ $punicao->value or 'Desconhecido' }}}</span>
							@endif
						</td>
						<td>{{{ $tipos[$punicao->type] }}}</td>
						<td>{{{ ($punicao->active) ? 'Ativado' : 'Desativado' }}}</td>
						<td>{{{ $punicao->admin->nickname or $punicao->admin->name }}}</td>
						<td>{{{ date('Y/m/d h:i:s', $punicao->added) }}}</td>
						<td>{{{ date('Y/m/d h:i:s', $punicao->expires) }}}</td>
						<td>
							<a href="{{ action('BansController@getEditar', $punicao->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('BansController@getDeletar', $punicao->id) }}" title="Deletar" alt="Deletar" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhuma punição foi encontrada!</td>
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

			@if(isset($punicoes))
			<p>
				{{ $punicoes->links() }}
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
{{ HTML::script('assets/plugins/dataTables/dataTables.bootstrap.js') }}

{{ HTML::script('assets/js/dashboard/scriptDataTable.js', array('async' => 'async')) }}
{{ HTML::script('assets/js/jquery.mask.min.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		if($("tbody tr td").find('span[class=ip_address]').text()!="Desconhecido"){ $('.ip_address').mask('099.099.099.099'); }
	});
</script>
@stop