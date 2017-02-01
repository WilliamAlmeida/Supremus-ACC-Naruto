@extends('layouts.admin')

@section('title', 'Categorias das Notícias')
@section('sub_title', '<i class="fa fa-list fa-1x"></i> Categorias das Notícias')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('CategoriasNoticiasController@getAdicionar') }}" alt="Adicionar Categoria" title="Adicionar Categoria"><i class="fa fa-plus fa-2x"></i></a>
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
		Lista de Categorias das Notícias
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Nome</th>
						<th>Status</th>
						<th>Criado por <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Nome</th>
						<th>Status</th>
						<th>Criado por <i class="fa fa-info-circle" title="Usuário"></i></th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($categoriasnoticias as $categoria)
					<tr>
						<td>{{{$categoria->name}}}</td>
						<td>{{{ @($categoria->trashed()) ? 'Desativado' : 'Ativado' }}}</td>
						<td>{{{$categoria->user->name or 'Desconhecido'}}}</td>
						<td>{{{$categoria->created_at}}}</td>
						<td>{{{$categoria->updated_at}}}</td>
						<td>
							@if($categoria->trashed())
							<a href="{{ action('CategoriasNoticiasController@getDeletar', $categoria->id) }}" title="Ativar" alt="Ativar" class="text-success"><span class="glyphicon glyphicon-ok-sign"></span></a>
							@else
							<a href="{{ action('CategoriasNoticiasController@getDeletar', $categoria->id) }}" title="Desativar" alt="Desativar" class="text-danger" onclick="return confirm('Deseja mesmo Desativar?')"><span class="glyphicon glyphicon-info-sign"></span></a>
							@endif
							<a href="{{ action('CategoriasNoticiasController@getEditar', $categoria->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('CategoriasNoticiasController@getDeletar', array('id' => $categoria->id, 'soft' => 'false')) }}" title="Deletar" alt="Deletar" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
					@empty
					<tr>
						<td>Nenhuma categoria foi encontrada!</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($categoriasnoticias))
			<p>
				{{ $categoriasnoticias->links() }}
			</p>
			@endif
		</div>
	</div>
	<!--End Advanced Tables -->
</div>
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