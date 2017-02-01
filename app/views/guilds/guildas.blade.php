@extends('layouts.public')

@section('title', 'Guildas')
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css') }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css') }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css') }}
@stop

@section('content')
<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
	<div class="row m-b conteudo">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">Filtros</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">Fltros</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
			{{ Form::open(array('action' => 'GuildsController@getGuildas', 'class' => 'form', 'name' => 'filtro_guildas', 'method' => 'get')) }}

			<div class="form-group">
				{{ Form::label('world_id', 'Mundos') }}
				{{ Form::select('world_id', $mundos = array_add($mundos, -1, 'Todos'), -1, ['class' => 'form-control']) }}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-z p-r">
				<div class="form-group">
					{{ Form::reset('Limpar', ['class' => 'btn btn-primary btn-block']) }}
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-z p-l">
				<div class="form-group">
					{{ Form::submit('Filtrar', ['class' => 'btn btn-primary btn-block']) }}
				</div>
			</div>

			{{ Form::close() }}
		</div>
	</div>
</div>

<div class="col-lg-1 col-md-1"></div>

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">Entre para uma Guilda no {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">Entre para uma Guilda no {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($guilds->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Mundo</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Mundo</th>
						</tr>
					</tfoot>
					<tbody>
						<?php $i=1; ?>
						@foreach($guilds as $guild)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ link_to_action('HousesController@getCasa',  $guild->name, $parameters = array('id' => $guild->id), $attributes = array('title' => 'Visualize está guilda.')) }}</td>
							<td>{{ $mundos[$guild->world_id] or 'Desconhecido' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="center-block">
				{{ $guilds->appends($filtro)->links() }}
			</div>
			@else
			Nenhuma guilda foi encontrada!
			@endif
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/dataTables/jquery.dataTables.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.responsive.min.js', array('async' => 'async')) }}
{{ HTML::script('assets/plugins/dataTables/dataTables.bootstrap.js', array('async' => 'async')) }}
{{ HTML::script('assets/js/scriptDataTable.js', array('async' => 'async')) }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('form[name=filtro_guildas] input[name=name]').val('{{ (Input::has("name")) ? Input::get("name") : "" }}');
		$('select[name=world_id] option[value={{ (Input::has("world_id")) ? Input::get("world_id") : -1 }}]').prop("selected", true);
	});
</script>
@stop