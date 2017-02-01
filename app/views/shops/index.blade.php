@extends('layouts.admin')

@section('title', 'Itens')
@section('sub_title', '<i class="fa fa-list fa-1x"></i> Itens')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('ShopsController@getAdicionar') }}" alt="Adicionar Item" title="Adicionar Item"><i class="fa fa-plus fa-2x"></i></a>
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
		Lista de Itens
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Nome <i class="fa fa-info-circle" title="Nome a ser exibido na loja"></i></th>
						<th>Item ID <i class="fa fa-info-circle" title="ID do item dentro do jogo"></i></th>
						<th>Pontos <i class="fa fa-info-circle" title="Valor do Item na loja"></i></th>
						<th>Destaque</th>
						<th>Status</th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Nome <i class="fa fa-info-circle" title="Nome a ser exibido na loja"></i></th>
						<th>Item ID <i class="fa fa-info-circle" title="ID do item dentro do jogo"></i></th>
						<th>Pontos <i class="fa fa-info-circle" title="Valor do Item na loja"></i></th>
						<th>Destaque</th>
						<th>Status</th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($itens as $item)
					<tr>
						<td>{{{str_limit($item->name, 25)}}}</td>
						<td>{{{ $item->item }}}</td>
						<td>{{{ $item->points }}}</td>
						<td>{{ @($item->featured) ? 'Sim' : 'Não'}}</td>
						<td>{{{ @($item->trashed()) ? 'Desativado' : 'Ativado' }}}</td>
						<td>
							@if($item->trashed())
							<a href="{{ action('ShopsController@getDeletar', $item->id) }}" title="Ativar" alt="Ativar" class="text-success"><span class="glyphicon glyphicon-ok-sign"></span></a>
							@else
							<a href="{{ action('ShopsController@getDeletar', $item->id) }}" title="Desativar" alt="Desativar" class="text-danger" onclick="return confirm('Deseja mesmo Desativar?')"><span class="glyphicon glyphicon-info-sign"></span></a>
							@endif
							<a href="{{ action('ShopsController@getEditar', $item->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('ShopsController@getDeletar', $item->id) }}" title="Deletar" alt="Deletar" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhum item foi encontrado!</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($itens))
			<p>
				{{ $itens->links() }}
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