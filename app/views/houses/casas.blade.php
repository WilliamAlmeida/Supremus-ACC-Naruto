@extends('layouts.public')

@section('title', 'Imóveis')
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
			{{ Form::open(array('action' => 'HousesController@getCasas', 'class' => 'form', 'name' => 'filtro_imoveis', 'method' => 'get')) }}

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-z p-r">
				<div class="form-group">
					{{ Form::label('world_id', 'Mundos') }}
					{{ Form::select('world_id', $mundos = array_add($mundos, -1, 'Todos'), -1, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-z p-l">
				<div class="form-group">
					{{ Form::label('town_id', 'Cidade') }}
					{{ Form::select('town_id', $cidades = array_add($cidades, 0, 'Todas'), 0, ['class' => 'form-control']) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('ordem', 'Ordem') }}
				{{ Form::select('ordem', $filtros = array_add($filtros, 0, 'Nenhuma'), 0, ['class' => 'form-control']) }}
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
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">Adiquira ja seu Imóvel no {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">Adiquira ja seu Imóvel no {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($houses->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Camas</th>
							<th>Proprietário</th>
							<th>Preço</th>
							<th>Cidade</th>
							<th>Mundo</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Camas</th>
							<th>Proprietário</th>
							<th>Preço</th>
							<th>Cidade</th>
							<th>Mundo</th>
						</tr>
					</tfoot>
					<tbody>
						<?php $i=1; ?>
						@foreach($houses as $imovel)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ link_to_action('HousesController@getCasa',  (!empty($imovel->name) ? $imovel->name : 'Desconhecido'), $parameters = array('id' => $imovel->id), $attributes = array('title' => 'Visualize este imóvel.')) }}</td>
							<td>{{ $imovel->beds }}</td>
							<td>{{ ($imovel->owner) ? $imovel->player->name : 'Nenhum' }} </td>
							<td>{{ $imovel->price }} dollar(s)</td>
							<td>{{ $imovel->city->name or 'Desconhecida' }}</td>
							<td>{{ $mundos[$imovel->world_id] or 'Desconhecido' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="center-block">
				{{ $houses->appends($filtro)->links() }}
			</div>
			@else
			Nenhum imóvel foi encontrado!
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
		$('form[name=filtro_imoveis] input[name=name]').val('{{ (Input::has("name")) ? Input::get("name") : "" }}');
		$('select[name=world_id] option[value={{ (Input::has("world_id")) ? Input::get("world_id") : -1 }}]').prop("selected", true);
		$('select[name=town_id] option[value={{ (Input::has("town_id")) ? Input::get("town_id") : 0 }}]').prop("selected", true);
		$('select[name=ordem] option[value={{ (Input::has("ordem")) ? Input::get("ordem") : 0 }}]').prop("selected", true);
	});
</script>
@stop