@extends('layouts.admin')

@section('title', 'Cupons')
@section('sub_title', '<i class="fa fa-list fa-1x"></i> Cupons')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('CouponsController@getAdicionar') }}" alt="Adicionar Cupom" title="Adicionar Cupom"><i class="fa fa-plus fa-2x"></i></a>
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
		Lista de Cupons
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Código</th>
						<th>Status</th>
						<th>Limitado? <i class="fa fa-info-circle" title="Se este cupom possui limite de uso"></i></th>
						<th>Uso <i class="fa fa-info-circle" title="Quantas vezes este cupom foi utilizado"></i></th>
						<th>Registrado por <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Nome</th>
						<th>Código</th>
						<th>Status</th>
						<th>Limitado? <i class="fa fa-info-circle" title="Se este cupom possui limite de uso"></i></th>
						<th>Uso <i class="fa fa-info-circle" title="Quantas vezes este cupom foi utilizado"></i></th>
						<th>Registrado por <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($cupons as $cupom)
					<tr>
						<td>{{{ $cupom->name }}}</td>
						<td>{{{ $cupom->code }}}</td>
						<td>{{{ @($cupom->trashed()) ? 'Desativado' : 'Ativado' }}}</td>
						<td>{{{ ($cupom->limit) ? 'Sim, '.$cupom->limit.' usos' : 'Não' }}}</td>
						<td>{{{$cupom->users()->count()}}}</td>
						<td>{{{$cupom->user->name}}}</td>
						<td>{{{$cupom->created_at}}}</td>
						<td>{{{$cupom->updated_at}}}</td>
						<td>
							@if($cupom->trashed())
							<a href="{{ action('CouponsController@getDeletar', $cupom->id) }}" title="Ativar" alt="Ativar" class="text-success"><span class="glyphicon glyphicon-ok-sign"></span></a>
							@else
							<a href="{{ action('CouponsController@getDeletar', $cupom->id) }}" title="Desativar" alt="Desativar" class="text-danger" onclick="return confirm('Deseja mesmo Desativar?')"><span class="glyphicon glyphicon-info-sign"></span></a>
							@endif
							<a href="{{ action('CouponsController@getEditar', $cupom->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('CouponsController@getDeletar', array('id' => $cupom->id, 'soft' => 'false')) }}" title="Deletar" alt="Deletar" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhuma cupom foi encontrado!</td>
						<td></td>
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

			@if(isset($cupons))
			<p>
				{{ $cupons->links() }}
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