@extends('layouts.admin')

@section('title', 'Configuracões')
@section('sub_title', '<i class="fa fa-users fa-1x"></i> Configuracões')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
@if(!count($configuracoes))
<a href="{{ action('ConfiguracoesController@getAdicionar') }}" alt="Adicionar Configurações" title="Adicionar Configurações"><i class="fa fa-plus fa-2x"></i></a>
@endif
<hr>
@if(Session::get('message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong> {{ Session::get('message') }}
</div>
@endif

<!-- Advanced Tables -->
<div class="panel panel-default">
	<div class="panel-heading">
		Lista de Perfís
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Palavras Chave</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Palavras Chave</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($configuracoes as $configuracao)
					<tr>
						<td>{{{$configuracao->title}}}</td>
						<td>{{{$configuracao->email}}}</td>
						<td>{{{$configuracao->keywords}}}</td>
						<td>{{{$configuracao->created_at}}}</td>
						<td>{{{$configuracao->updated_at}}}</td>
						<td>
							<a href="{{ action('ConfiguracoesController@getEditar', $configuracao->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
							@if(!count($configuracoes))
							<a href="{{ action('ConfiguracoesController@getDeletar', $configuracao->id) }}" title="Deletar" alt="Deletar"><span class="glyphicon glyphicon-trash"></span></a>
							@endif
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhuma configuração foi encontrada!</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($configuracoes))
			<p>
				{{ $configuracoes->links() }}
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
@stop

@section('script-execute')

@stop