@extends('layouts.public')

@section('title', Lang::choice('content.account', 1))
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/plugins/dataTables/jquery.dataTables.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/dataTables.bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/dataTables/responsive.dataTables.min.css', array('async' => 'async')) }}
@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.in the account details') }} {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.in the account details') }} {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(count($usuario))
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z">
					@if($usuario->avatar)
					{{ HTML::image(($usuario->avatar) ? 'assets/img/avatares/'.$usuario->avatar.'.png' : 'assets/img/avatares/0.png', ($usuario->avatar) ? $avatares[$usuario->avatar] : 'assets/img/avatares/0.png', array('title' => ($usuario->avatar) ? $avatares[$usuario->avatar] : Lang::get('content.not selected'), 'name' => 'avatar','class' => 'img-responsive', 'style' => 'display:inline-block')) }}
					@else
					<i class="fa fa-user fa-3x"></i>
					@endif
					 <strong>{{ $usuario->nickname or Lang::get('content.unknown') }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<tbody>
								<tr>
									<th>{{ Lang::get('content.account status') }}</th>
									<td>{{ ($usuario->premdays>0) ? 'Vip' : 'Normal' }}</td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.group', 1) }}</th>
									<td>{{ $grupos[$usuario->group_id] }}</td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.email') }}</th>
									<td>{{ (!$privacy) ? $usuario->email : Lang::get('content.information not available to the public') }}</td>
								</tr>
								@if(Auth::user()->group_id == 5)
								<tr>
									<th>{{ Lang::get('content.last login in') }}</th>
									<td>{{{ Helpers::formataData(date('d/m/Y h:i:s', $usuario->lastday)).', '.Helpers::ago($usuario->lastday) }}}</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::choice('content.character', 1) }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					@if($usuario->player()->count()>0)
					<div class="table-responsive">
						<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ Lang::choice('content.name', 1) }}</th>
									<th>{{ Lang::choice('content.level', 1) }}</th>
									<th>{{ Lang::choice('content.city', 1) }}</th>
									<th>{{ Lang::choice('content.world', 1) }}</th>
									<th>{{ Lang::get('content.status') }}</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>#</th>
									<th>{{ Lang::choice('content.name', 1) }}</th>
									<th>{{ Lang::choice('content.level', 1) }}</th>
									<th>{{ Lang::choice('content.city', 1) }}</th>
									<th>{{ Lang::choice('content.world', 1) }}</th>
									<th>{{ Lang::get('content.status') }}</th>
								</tr>
							</tfoot>
							<tbody>
								<?php $i=1; ?>
								@foreach($usuario->player()->with('City')->get() as $personagem)
								<tr>
									<td>{{ $i++ }}</td>
									<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $personagem->id)) }}" class="" alt="{{ Lang::get('content.show character') }} {{ $personagem->name }}" title="{{ Lang::get('content.show character') }} {{ $personagem->name }}">{{ $personagem->name }}</a></td>
									<td>{{ $personagem->level }}</td>
									<td>{{ $personagem->city->name or Lang::get('content.unknown') }}</td>
									<td>{{ $mundos[$personagem->world_id] or Lang::get('content.unknown') }}</td>
									<td><span class="{{ ($personagem->online) ? 'text-success' : 'text-danger' }}"><strong>{{ ($personagem->online) ? 'Online' : 'Off-line' }}</strong></span></td>
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
			@else
			{{ Lang::get('content.account not found') }}!
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

	});
</script>
@stop