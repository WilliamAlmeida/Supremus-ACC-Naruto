@extends('layouts.public')

@section('title', Lang::get('content.latest deaths'))
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	<div class="row m-b conteudo">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::choice('content.filter', 2) }}</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::choice('content.filter', 2) }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
			{{ Form::open(array('action' => 'PlayersController@getUltimasMortes', 'class' => 'form', 'name' => 'filtro_mortes', 'method' => 'get')) }}

			<div class="form-group">
				{{ Form::label('name', Lang::choice('content.victim', 1)) }}
				{{ Form::text('name', null, array('placeholder' => Lang::get('content.type the name of the victim').'.', 'class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('killer', Lang::choice('content.killer', 1)) }}
				{{ Form::text('killer', null, array('placeholder' => Lang::get('content.type the name of the killer').'.', 'class' => 'form-control')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('world_id', Lang::choice('content.world', 2)) }}
				{{ Form::select('world_id', $mundos = array_add($mundos, -1, Lang::choice('content.all', 2)), -1, ['class' => 'form-control']) }}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-z p-r">
				<div class="form-group">
					{{ Form::reset(Lang::get('content.clean'), ['class' => 'btn btn-primary btn-block']) }}
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 p-z p-l">
				<div class="form-group">
					{{ Form::submit(Lang::get('content.filterV'), ['class' => 'btn btn-primary btn-block']) }}
				</div>
			</div>

			{{ Form::close() }}
		</div>
	</div>
</div>

<div class="col-lg-1 col-md-1"></div>

<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.latest deaths on game') }} {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.latest deaths on game') }} {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(count($players)>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ Lang::get('content.date') }}</th>
							<th>{{ Lang::choice('content.victim', 1) }}</th>
							@if(!$privacy)
							<th>{{ Lang::choice('content.level', 1) }}</th>
							@endif
							<th>{{ Lang::choice('content.world', 1) }}</th>
							<th>{{ Lang::choice('content.killer', 1) }}</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>#</th>
							<th>{{ Lang::get('content.date') }}</th>
							<th>{{ Lang::choice('content.victim', 1) }}</th>
							@if(!$privacy)
							<th>{{ Lang::choice('content.level', 1) }}</th>
							@endif
							<th>{{ Lang::choice('content.world', 1) }}</th>
							<th>{{ Lang::choice('content.killer', 1) }}</th>
						</tr>
					</tfoot>
					<tbody>
						<?php $i=1; ?>
						@foreach($players as $personagem)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ Helpers::ago($personagem['date']) }}</td>
							<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $personagem['player_id'])) }}" class="" alt="{{ Lang::get('content.show character') }} {{ $personagem['name'] }}" title="{{ Lang::get('content.show character') }} {{ $personagem['name'] }}">{{ $personagem['name'] }}</a></td>
							@if(!$privacy)
							<td>{{ $morte->level }}</td>
							@endif
							<td>{{ $mundos[$personagem['world_id']] or Lang::get('content.unknown') }}</td>
							<td>{{ $personagem['killer'] or Lang::get('content.unknown') }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			{{ Lang::get('content.no death was recorded') }}!
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
		$('form[name=filtro_mortes] input[name=name]').val('{{ (Input::has("name")) ? Input::get("name") : "" }}');
		$('form[name=filtro_mortes] input[name=killer]').val('{{ (Input::has("killer")) ? Input::get("killer") : "" }}');
		$('select[name=world_id] option[value={{ (Input::has("world_id")) ? Input::get("world_id") : -1 }}]').prop("selected", true);
	});
</script>
@stop