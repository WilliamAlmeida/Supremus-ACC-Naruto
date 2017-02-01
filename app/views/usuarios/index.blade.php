@extends('layouts.admin')

@section('title', 'Usuários')
@section('sub_title', '<i class="fa fa-users fa-1x"></i> Usuários')

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
		Lista de Usuários
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome <i class="fa fa-info-circle" title="Usuário ou Nickname"></i></th>
						<th>Email</th>
						<th>Nível de Acesso</th>
						<th>Status da Conta</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultimo Login <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>#</th>
						<th>Nome <i class="fa fa-info-circle" title="Usuário ou Nickname"></i></th>
						<th>Email</th>
						<th>Nível de Acesso</th>
						<th>Status da Conta</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultimo Login <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($usuarios as $key => $usuario)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{{ $usuario->nickname or $usuario->name }}}</td>
						<td>{{{ $usuario->email }}}</td>
						<td>{{{ $grupos[$usuario->group_id] }}}</td>
						<td>{{ ($usuario->premdays>0) ? 'Vip' : 'Normal' }}</td>
						<td>{{{ date('Y/m/d h:i:s', $usuario->created) }}}</td>
						<td>{{{ date('Y/m/d h:i:s', $usuario->lastday) }}}</td>
						<td>
							<a href="{{ action('UsersController@getConta', $usuario->id) }}" title="Visualizar Usuário" alt="Visualizar Usuário" target="view_user"><span class="glyphicon glyphicon-eye-open"></span></a>
							<a href="{{ action('UsersController@getEditar', $usuario->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
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
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($usuarios))
			<p>
				{{ $usuarios->links() }}
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