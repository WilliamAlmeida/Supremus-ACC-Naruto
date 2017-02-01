@extends('layouts.admin')

@section('title', 'Registro')
@section('sub_title', '<i class="fa fa-list-alt fa-1x"></i> Registro')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<a href="{{ action('RegistrosController@getIndex') }}" alt="Voltar para lista de Registros" title="Voltar para lista de Registros"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>

<!-- Advanced Tables -->
<div class="panel panel-default">
	<div class="panel-heading">
		Registro #{{{ $registro->id }}}
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table display table-bordered table-hover responsive nowrap" width="100%" name="dataTables-example">
				<tbody>
					<tr>
						<th>Tipo</th>
						<td>{{{ $tipos[$registro->type] }}}</td>
					</tr>
					<tr>
						<th>IP</th>
						<td><span class="ip_address">{{{ $registro->ip or 'Desconhecido' }}}</span></td>
					</tr>
					@if($registro->user()->exists())
					<tr>
						<th>Usuário</th>
						<td>{{{ $registro->user->nickname or $registro->user->name }}}</td>
					</tr>
					@endif
					@if($registro->player()->exists())
					<tr>
						<th>Personagem</th>
						<td>{{{ $registro->player->name }}}</td>
					</tr>
					@endif
					<tr>
						<th>Registrado <i class="fa fa-info-circle" title="Ano/Mês/Dia Hora-Minuto-Segundo"></i></th>
						<td>{{{ $registro->created_at }}}</td>
					</tr>
					<tr>
						<th>Assunto</th>
						<td>{{{ $registro->subject }}}</td>
					</tr>
					<tr>
						<th>Descrição</th>
						<td>{{{ $registro->text }}}</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>
<!--End Advanced Tables -->
@stop

@section('scripts')
{{ HTML::script('assets/js/jquery.mask.min.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		if($("tbody tr td").find('span[class=ip_address]').text()!="Desconhecido"){ $('.ip_address').mask('099.099.099.099'); }
	});
</script>
@stop