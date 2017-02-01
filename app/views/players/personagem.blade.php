@extends('layouts.public')

@section('title', (Lang::choice('content.character', 1).' '.(($player) ? $player->name : null)))
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
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.details of the character in the') }} {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.details of the character in the') }} {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($player->count()>0)
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><i class="fa fa-{{ ($player->sex) ? 'male' : 'female' }} fa-3x"></i> <strong>{{ $player->name }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<th>{{ Lang::choice('content.account', 1) }}</th>
									<td>
										{{ link_to_action('UsersController@getConta',  ((!empty($player->user->nickname) ? $player->user->nickname : 'Sem Nickname')), $parameters = array('id' => $player->account_id), $attributes = array('title' => 'Visualize a Conta de '.$player->user->nickname)) }}
									</td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.vocation', 1) }}</th>
									<td>
										{{ $vocacoes[$player->vocation] or Lang::get('content.unknown') }}
									</td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.gender', 1) }}</th>
									<td>{{ ($player->sex) ? Lang::get('content.male') : Lang::get('content.female') }}</td>
								</tr>
								@if(!$privacy)
								<tr>
									<th>{{ Lang::choice('content.level', 1) }}</th>
									<td>{{ $player->level }}</td>
								</tr>
								@endif
								<!-- <tr>
									<th>Status da Conta</th>
									<td>{{--($player->premdays>0) ? 'Vip' : 'Normal'--}}</td>
								</tr> -->
								<tr>
									<th>{{ Lang::get('content.status') }} {{ Lang::choice('content.character', 1) }}</th>
									<td><span class="{{ ($player->online) ? 'text-success' : 'text-danger' }}"><strong>{{ ($player->online) ? 'Online' : 'Off-line' }}</strong></span></td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.group', 1) }}</th>
									<td>{{ $grupos[$player->group_id] or Lang::get('content.unknown') }}</td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.city', 1) }}</th>
									<td>{{ $player->city->name or Lang::get('content.unknown') }}</td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.world', 1) }}</th>
									<td>{{ $mundos[$player->world_id] or Lang::get('content.unknown') }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::get('content.latest deaths') }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					@if(count($lista_mortes)>0)
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
								@foreach($lista_mortes as $personagem)
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
			<div class="row m-b hidden">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::choice('content.badge', 2) }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ Lang::choice('content.gym', 1) }}</th>
									<th>{{ Lang::choice('content.leader', 1) }}</th>
									<th>{{ Lang::choice('content.badge', 1) }}</th>
									<th>{{ Lang::get('content.status') }}</th>
								</tr>
							</thead>
							<tbody>
								@forelse($insignias as $insignia)
								<tr>
									<td>{{ HTML::image('assets/img/insignias/'.$insignia["img"].'.png', Lang::choice('content.badge', 1), array('class' => 'img-responsive', 'style' => 'max-height:32px')) }}</td>
									<td>{{ $insignia['gym'] or Lang::get('content.unknown') }}</td>
									<td>{{ $insignia['leader'] or Lang::get('content.unknown') }}</td>
									<td>{{ $insignia['badge'] or Lang::get('content.unknown') }}</td>
									<td><i class="fa fa-{{ (count($player->playerstorage)) ? (($player->playerstorage()->where('key', '=', $insignia['storage'])->first()) ? 'check-circle' : 'circle-o') : 'circle-o' }} fa-2x"></i></td>
								</tr>
								@empty
								<tr>
									<td colspan="2">{{ Lang::get('content.no badge found') }}!</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::choice('content.quest', 2) }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ Lang::choice('content.title', 1) }}</th>
									<th>{{ Lang::choice('content.description', 1) }}</th>
									<th>{{ Lang::choice('content.location', 1) }}</th>
									<th>{{ Lang::get('content.status') }}</th>
								</tr>
							</thead>
							<tbody>
								@forelse($quests as $quest)
								<tr>
									<td>@if($quest['img']!=null) {{ HTML::image('assets/img/insignias/'.$quest["img"].'.png', Lang::choice('content.quest', 1), array('class' => 'img-responsive', 'style' => 'max-height:32px')) }} @endif</td>
									<td>{{ $quest['name'] }}</td>
									<td>{{ ($quest['description']) ? $quest['description'] : Lang::get('content.unknown') }}</td>
									<td>{{ ($quest['localization']) ? $quest['localization'] : Lang::get('content.unknown') }}</td>
									<td><i class="fa fa-{{ (count($player->playerstorage)) ? (($player->playerstorage()->where('key', '=', $quest['storage'])->first()) ? 'check-circle' : 'circle-o') : 'circle-o' }} fa-2x"></i></td>
								</tr>
								@empty
								<tr>
									<td colspan="2">{{ Lang::get('content.no quest found') }}!</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
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

	});
</script>
@stop