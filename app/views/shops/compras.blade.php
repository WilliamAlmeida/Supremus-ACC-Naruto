@extends('layouts.admin')

@section('title', 'Histórico de Compras')
@section('sub_title', '<i class="fa fa-list fa-1x"></i> Histórico de Compras')

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
		Histórico de Compras
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Item</th>
						<th>De <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Para <i class="fa fa-info-circle" title="Personagem (Jogador)"></i></th>
						<th>Custo <i class="fa fa-info-circle" title="Pontos"></i></th>
						<th>Data <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Status</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Item</th>
						<th>De <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Para <i class="fa fa-info-circle" title="Personagem (Jogador)"></i></th>
						<th>Custo <i class="fa fa-info-circle" title="Pontos"></i></th>
						<th>Data <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Status</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($compras as $compra)
					<tr>
						<td>{{{ $compra->shopoffer()->withTrashed()->first()->name }}}</td>
						<td>{{{ $compra->from }}}</td>
						<td>{{{ $compra->player }}}</td>
						<td>{{{ $compra->points }}}</td>
						<td>{{{ date('Y/m/d h:i:s', $compra->date) }}}</td>
						<td>{{{ ($compra->processed) ? 'Entregue' : 'Ainda não entregue' }}}</td>
					</tr>
					@empty
					<tr>
						<td>Nenhuma foi encontrada!</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($compras))
			<p>
				{{ $compras->links() }}
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