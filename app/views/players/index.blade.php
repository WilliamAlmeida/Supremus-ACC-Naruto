@extends('layouts.admin')

@section('title', 'Personagens')
@section('sub_title', '<i class="fa fa-users fa-1x"></i> Personagens')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
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

<!-- Advanced Tables -->
<div class="panel panel-default">
	<div class="panel-heading">
		Lista de Personagens
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Nome <i class="fa fa-info-circle" title="Nome do Personagem"></i></th>
						<th>Level</th>
						<th>Status da Conta</th>
						<th>Cidades</th>
						<th>Mundos</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Nome <i class="fa fa-info-circle" title="Nome do Personagem"></i></th>
						<th>Level</th>
						<th>Status da Conta</th>
						<th>Cidades</th>
						<th>Mundos</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($players as $personagem)
					<tr>
						<td>{{{ $personagem->name }}}</td>
						<td>{{{ $personagem->level }}}</td>
						<td>{{ ($personagem->online) ? 'Online' : 'Off-line' }}</td>
						<td>{{{ $personagem->city->name or 'Desconhecido'  }}}</td>
						<td>{{{ $mundos[$personagem->world_id] or 'Desconhecido' }}}</td>
						<td>{{{ date('Y/m/d h:i:s', $personagem->created) }}}</td>
						<td>
							<a href="{{ action('PlayersController@getPersonagem', $personagem->id) }}" title="Visualizar Personagem" alt="Visualizar Personagem" target="view_user"><span class="glyphicon glyphicon-eye-open"></span></a>
							<a href="{{ action('PlayersController@getEditar', $personagem->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhum usuário foi encontrado!</td>
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

			@if(isset($players))
			<p>
				{{ $players->links() }}
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