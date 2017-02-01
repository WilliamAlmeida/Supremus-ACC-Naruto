@extends('layouts.admin')

@section('title', 'Registros')
@section('sub_title', '<i class="fa fa-picture-o fa-1x"></i> Registros')

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
		Lista de Registros
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Tipo</th>
						<th>IP</th>
						<th>Assunto</th>
						<th>Registrado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Tipo</th>
						<th>IP</th>
						<th>Assunto</th>
						<th>Registrado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($registros as $registro)
					<tr>
						<td>{{{ $tipos[$registro->type] }}}</td>
						<td>{{{ $registro->ip }}}</td>
						<td>{{{ $registro->subject }}}</td>
						<td>{{{ $registro->created_at }}}</td>
						<td>
							<a href="{{ action('RegistrosController@getRegistro', $registro->id) }}" title="Visualizar Registro" alt="Visualizar Registro"><span class="glyphicon glyphicon-eye-open"></span></a>
							<!-- <a href="{{-- action('RegistrosController@getDeletar', $registro->id) --}}" title="Deletar" alt="Deletar" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a> -->
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhum Registro foi encontrado!</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($registros))
			<p>
				{{ $registros->links() }}
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