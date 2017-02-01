@extends('layouts.admin')

@section('title', 'Mídias')
@section('sub_title', '<i class="fa fa-picture-o fa-1x"></i> Mídias')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/buttons.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/colReorder.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<!-- <a href="{{ action('MidiasController@getAdicionar') }}" alt="Adicionar Mídia" title="Adicionar Mídia"><i class="fa fa-plus fa-2x"></i></a> -->
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
		Lista de Mídias
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Capa/Banner</th>
						<th>Nome</th>
						<th>Caminho</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Tipo</th>
						<th>Capa/Banner</th>
						<th>Nome</th>
						<th>Caminho</th>
						<th>Criado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th>Ultima Modificação <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<th class="actions">Ações</th>
					</tr>
				</tfoot>
				<tbody>
					@forelse($midias as $midia)
					<tr>
						<td>{{{$midia->type}}}</td>
						<td>{{{ ($midia->capa) ? 'Sim' : 'Não' }}}</td>
						<td>{{{$midia->name}}}</td>
						<td>{{{$midia->path}}}</td>
						<td>{{{$midia->created_at}}}</td>
						<td>{{{$midia->updated_at}}}</td>
						<td>
							<a href="{{ action('MidiasController@getEditar', $midia->id) }}" title="Editar" alt="Editar"><span class="glyphicon glyphicon-edit"></span></a>
							<a href="{{ action('MidiasController@getDeletar', $midia->id) }}" title="Deletar" alt="Deletar" onclick="return confirm('Deseja mesmo deletar?')"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="6">Nenhuma Mídia foi encontrada!</td>
					</tr>
					@endforelse
				</tbody>
			</table>

			@if(isset($midias))
			<p>
				{{ $midias->links() }}
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