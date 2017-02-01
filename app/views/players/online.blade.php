@extends('layouts.public')

@section('title', Lang::get('content.players online'))
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="row m-b conteudo">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h4 class="foDi foDS m-z p-z hidden-sm hidden-xs">{{ Lang::choice('content.filter', 2) }}</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::choice('content.filter', 2) }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
			{{ Form::open(array('action' => 'PlayersController@getOnline', 'class' => 'form', 'name' => 'filtro_online', 'method' => 'get')) }}

			<div class="row">
				<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						{{ Form::label('sex', Lang::choice('content.gender', 1)) }}
						<div class="center-block">
							<label style="font-weight:normal">{{ Form::radio('sex', '2', true) }} {{ Lang::choice('content.all', 1) }}</label>
							<label style="font-weight:normal">{{ Form::radio('sex', '1') }} {{ Lang::get('content.male') }}</label>
							<label style="font-weight:normal">{{ Form::radio('sex', '0') }} {{ Lang::get('content.female') }}</label>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group">
						{{ Form::label('world_id', Lang::choice('content.world', 2)) }}
						{{ Form::select('world_id', $mundos = array_add($mundos, -1, Lang::choice('content.all', 1)), -1, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group">
						{{ Form::label('town_id', Lang::choice('content.city', 1)) }}
						{{ Form::select('town_id', $cidades = array_add($cidades, 0, Lang::choice('content.all', 2)), 0, ['class' => 'form-control']) }}
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group">
						{{ Form::label('vocation', Lang::choice('content.vocation', 2)) }}
						{{ Form::select('vocation', $vocacoes = array_add($vocacoes, 0, Lang::choice('content.all', 2)), 0, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
					<div class="form-group">
						{{ Form::label('ordem', Lang::choice('content.order', 1)) }}
						{{ Form::select('ordem', $filtros = array_add($filtros, 0, Lang::get('content.no')), 0, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-r">
					<div class="form-group">
						{{ Form::reset(Lang::get('content.clean'), ['class' => 'btn btn-primary btn-block']) }}
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-l">
					<div class="form-group">
						{{ Form::submit(Lang::get('content.filterV'), ['class' => 'btn btn-primary btn-block']) }}
					</div>
				</div>
			</div>

			{{ Form::close() }}
		</div>
	</div>
</div>

<!-- <div class="col-lg-1 col-md-1 hidden-sm hidden-xs"></div> -->

<!-- <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 conteudo m-b"> -->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.players logged in') }} {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.players logged in') }} {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($players->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ Lang::choice('content.name', 1) }}</th>
							<th>{{ Lang::choice('content.level', 1) }}</th>
							<th>{{ Lang::get('content.fishing') }}</th>
							<th>{{ Lang::choice('content.gender', 1) }}</th>
							<th>{{ Lang::choice('content.city', 1) }}</th>
							<th>{{ Lang::choice('content.world', 1) }}</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>{{ Lang::choice('content.name', 1) }}</th>
							<th>{{ Lang::choice('content.level', 1) }}</th>
							<th>{{ Lang::get('content.fishing') }}</th>
							<th>{{ Lang::choice('content.gender', 1) }}</th>
							<th>{{ Lang::choice('content.city', 1) }}</th>
							<th>{{ Lang::choice('content.world', 1) }}</th>
						</tr>
					</tfoot>
					<tbody>
						<?php $i=1; ?>
						@foreach($players as $personagem)
						<tr>
							<td>{{ $i++ }}</td>
							<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $personagem->id)) }}" class="{{{ ($personagem->online) ? 'text-success' : 'text-danger' }}}" alt="{{ Lang::get('content.show character').' '.$personagem->name }}" title="{{ Lang::get('content.show character').' '.$personagem->name }}">{{ $personagem->name }}</a></td>
							<td>{{ $personagem->level }}</td>
							<td>{{ ($personagem->playerskill()->exists()) ? $personagem->playerskill()->where('skillid', '=', 1)->first()->value : '0' }}</td>
							<td>{{ ($personagem->sex) ? Lang::get('content.male') : Lang::get('content.female') }}</td>
							<td>{{ $personagem->city->name or Lang::get('content.unknown') }}</td>
							<td>{{ $mundos[$personagem->world_id] or Lang::get('content.unknown') }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			{{ Lang::get('content.no character was found') }}!
			@endif
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/dataTables/jquery.dataTables.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.responsive.min.js') }}
{{ HTML::script('assets/plugins/dataTables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/scriptDataTable.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('select[name=world_id] option[value={{ (Input::has("world_id")) ? Input::get("world_id") : -1 }}]').prop("selected", true);
		$('select[name=town_id] option[value={{ (Input::has("town_id")) ? Input::get("town_id") : 0 }}]').prop("selected", true);
		$('select[name=vocation] option[value={{ (Input::has("vocation")) ? Input::get("vocation") : 0 }}]').prop("selected", true);
		$('select[name=ordem] option[value={{ (Input::has("ordem")) ? Input::get("ordem") : 0 }}]').prop("selected", true);
	});
</script>
@stop