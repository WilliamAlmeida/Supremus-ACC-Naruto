@extends('layouts.public')

@section('title', Lang::choice('content.account', 1))
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css', array('async' => 'async')) }}
@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.welcome to your account') }}!</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.welcome to your account') }}!</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					@if(Session::get('message'))
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
						{{ Session::get('message') }}
					</div>
					@endif
					<h3 class="m-z p-z"><strong>{{ Lang::get('content.account status') }}</strong></h3>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
					{{ HTML::image('assets/img/empty.png', Lang::get('content.account status'), array('class' => 'center-block img-responsive simbolo')) }}
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<h4><strong>{{ Lang::choice('content.account', 1) }} {{ ($usuario->premdays>0) ? 'Vip' : 'Normal' }}</strong></h4>
					{{ Lang::get('content.enjoy incredible benefits, purchase your already') }} <a href="{{{ route('shop') }}}" class="text-muted" alt="{{ Lang::get('content.buy points') }}!" title="{{ Lang::get('content.buy points in our shop') }}.">{{ Lang::choice('content.point', 2) }}</a>!
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::get('content.share') }}</strong></h3>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b">
					<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
						<i class="fa fa-facebook fa-3x text-primary"></i>
					</div>
					<div class="row col-lg-9 col-md-9 col-sm-9 col-xs-12">
						<a href="javascript:void(0)" class="text-muted" alt="Compartilhe!" title="Função desativada!">{{ Lang::get('content.click here') }}</a> {{ Lang::get('content.to share the') }} {{ $configuracoes->title or 'App Name' }} {{ Lang::get('content.on facebook and compete for points') }}.
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
						<i class="fa fa-share-alt fa-3x text-warning"></i>
					</div>
					<div class="row col-lg-9 col-md-9 col-sm-9 col-xs-12">
						{{ Lang::get('content.the more references in your account more prizes you can win') }}.<br/>
						{{ Lang::get('content.to be referenced pass this link to a friend to register and start playing') }}.<br/>
						{{ Lang::get('content.to get the link') }} <a href="javascript:void(0)" alt="Obter Link!" title="Obter Link!" name="referal_link" data-clipboard-text="{{ route('tela-registrar-usuario', array('referal' => base64_encode(Auth::user()->id))) }}">{{ Lang::get('content.click here') }}</a>.
					</div>
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::get('content.main information') }} - {{ $configuracoes->title or 'App Name' }}</strong></h3>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<tbody>
								<tr>
									<th width="150px">{{ Lang::choice('content.avatar', 1) }}</th>
									<td>
										{{ HTML::image(($usuario->avatar) ? 'assets/img/avatares/'.$usuario->avatar.'.png' : 'assets/img/avatares/0.png', ($usuario->avatar) ? $avatares[$usuario->avatar] : 'assets/img/avatares/0.png', array('title' => ($usuario->avatar) ? $avatares[$usuario->avatar] : Lang::get('content.not selected').'.', 'name' => 'avatar','class' => 'img-responsive')) }}
										@if($usuario->avatar < 1)
										<button class="btn btn-primary btn-xs" id="btn_change_avatar" alt="{{ Lang::get('content.change avatar') }}" title="{{ Lang::get('content.change your avatar') }}!">{{ Lang::get('content.change avatar') }}</button>
										@endif
									</td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.email') }}</th>
									<td>{{ $usuario->email }}</td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.registered in') }}</th>
									<td>{{{ Helpers::formataData(date('d/m/Y h:i:s', $usuario->created)).', '.Helpers::ago($usuario->created) }}}</td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.last login in') }}</th>
									<td>{{{ Helpers::formataData(date('d/m/Y h:i:s', $usuario->lastday)).', '.Helpers::ago($usuario->lastday) }}}</td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.referenced by') }}</th>
									<td>{{{ ($usuario->referalaccount) ? ($usuario->referalaccount->referal()->first()->nickname) ? $usuario->referalaccount->referal()->first()->nickname : $usuario->referalaccount->referal()->first()->name : Lang::get('content.unknown') }}}</td>
								</tr>
								<tr>
									<th>{{ Lang::choice('content.point', 2) }}</th>
									<td>{{ $usuario->premium_points or '0' }} <a href="{{{ route('shop') }}}" class="btn btn-success btn-xs" name="btn_buy_points" alt="{{ Lang::get('content.buy points') }}" title="{{ Lang::get('content.buy points in our shop') }}.">{{ Lang::get('content.buy') }}</a></td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.points spent') }}</th>
									<td>{{ $usuario->premium_points_lost or '0' }}</td>
								</tr>
								<tr>
									<th>{{ Lang::get('content.recovery key') }}</th>
									<td name="recovery_key">
										@if($usuario->key)
										<span name="span_key">*************</span> <button type="button" class="btn btn-primary btn-xs" name="btn_key" rel="{{{ base64_encode($usuario->key) }}}">{{ Lang::get('content.show key') }}</button>
										@else
										{{ Lang::get('content.the recovery key has not yet been generated') }}, <button class="btn-link p-z" alt="{{ Lang::get('content.generate key') }}!" title="{{ Lang::get('content.generate key') }}!" name="btn_recovery_key">{{ strtolower(Lang::get('content.click here')) }}</button> {{ Lang::get('content.to generate a') }}!
										@endif
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::choice('content.operation', 2) }}</strong></h3>
					@if(Session::get('privacy'))
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
						{{ Session::get('privacy') }}
					</div>
					@endif
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
					<i class="fa fa-gear fa-3x"></i>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" id="operacoes">
					<button type="button" class="btn btn-primary btn-xs" id="btn_criar_personagem" alt="{{ Lang::get('menu.create character') }}" rel="{{ route('registrar-player') }}">{{ Lang::get('menu.create character') }}</button>
					<button type="button" class="btn btn-primary btn-xs" id="btn_senha" alt="{{ Lang::get('menu.change password') }}" rel="senha">{{ Lang::get('menu.change password') }}</button>
					<button type="button" class="btn btn-primary btn-xs" id="btn_email" alt="{{ Lang::get('menu.change email') }}" rel="email">{{ Lang::get('menu.change email') }}</button>
					<button type="button" class="btn btn-primary btn-xs" id="btn_change_privacy" alt="{{ Lang::get('content.configure privacy') }}" rel="privacy">{{ Lang::get('content.configure privacy') }}</button>
					<button type="button" class="btn btn-primary btn-xs" id="btn_list_friends" alt="{{ Lang::get('content.list of friends') }}" rel="lista_amigos">{{ Lang::get('content.list of friends') }}</button>
					<button type="button" class="btn btn-primary btn-xs" id="btn_list_references" alt="{{ Lang::get('content.list of references') }}" rel="lista_rerefencias">{{ Lang::get('content.list of references') }}</button>
					@if(empty($usuario->nickname))
					<button type="button" class="btn btn-primary btn-xs" id="btn_nickname" alt="{{ Lang::get('content.change nickname') }}" rel="nickname">{{ Lang::get('content.change nickname') }}</button>
					@endif
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::choice('content.character', 2) }}</strong></h3>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<th>{{ Lang::choice('content.name', 1) }}</th>
								<th>{{ Lang::choice('content.gender', 1) }}</th>
								<th>{{ Lang::choice('content.vocation', 1) }}</th>
								<th>{{ Lang::choice('content.level', 1) }}</th>
								<th>{{ Lang::choice('content.city', 1) }}</th>
								<th>{{ Lang::choice('content.world', 1) }}</th>
								<th>{{ Lang::choice('content.action', 2) }}</th>
							</thead>
							<tbody>
								@forelse($usuario->player()->with('City')->get() as $personagem)
								<tr>
									<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $personagem->id)) }}" class="" alt="Visualizar Personagem {{ $personagem->name }}" title="Visualizar Personagem {{ $personagem->name }}">{{ $personagem->name }}</a></td>
									<td>{{ ($personagem->sex) ? Lang::get('content.male') : Lang::get('content.female') }}</td>
									<td>{{ $vocacoes[$personagem->vocation] or Lang::get('content.unknown') }}</td>
									<td>{{ $personagem->level }}</td>
									<td>{{ $personagem->city->name or Lang::get('content.unknown') }}</td>
									<td>{{ $mundos[$personagem->world_id] or Lang::get('content.unknown') }}</td>
									<td>
										<a href="javascript:void(0)" class="text-muted hidden" alt="Função desativada!" title="Função desativada!"><i class="fa fa-edit fa-fw"></i></a>
										@if($personagem->online)
										<a href="javascript:void(0)" class="text-muted" alt="{{ Lang::get('content.release the character') }} {{{ $personagem->name }}} {{ Lang::get('content.so I can fix it') }}." title="{{ Lang::get('content.release the character') }} {{{ $personagem->name }}} {{ Lang::get('content.so I can fix it') }}."><i class="fa fa-wrench fa-fw"></i></a>
										@else
										<a href="{{ action('PlayersController@getDesbugar', array('id' => $personagem->id)) }}" class="" alt="{{ Lang::get('content.fix character') }} {{{ $personagem->name }}}" title="{{ Lang::get('content.fix character') }} {{{ $personagem->name }}}"><i class="fa fa-wrench fa-fw"></i></a>
										@endif
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="7">{{ Lang::get('content.any character created') }}!</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::get('content.purchase history') }}</strong></h3>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<th>Item</th>
								<th>{{ Lang::get('content.from') }} <i class="fa fa-info-circle" title="{{ Lang::get('content.account') }}"></i></th>
								<th>{{ Lang::get('content.to') }} <i class="fa fa-info-circle" title="{{ Lang::choice('content.character', 1).' ('.Lang::choice('content.player', 1).')' }}"></i></th>
								<th>{{ Lang::get('content.cost') }}</th>
								<th>{{ Lang::get('content.date') }}</th>
								<th>{{ Lang::get('content.status') }}</th>
							</thead>
							<tbody>
								@forelse($history as $compra)
								<tr>
									<td>{{{ $compra->shopoffer()->withTrashed()->first()->name or Lang::get('content.unknown') }}}</td>
									<td>{{{ $compra->from }}}</td>
									<td>{{{ $compra->player }}}</td>
									<td>{{{ $compra->points }}}</td>
									<td>{{{ Helpers::ago($compra->date) }}}</td>
									<td>{{{ ($compra->processed) ? 'Entregue' : 'Ainda não entregue' }}}</td>
								</tr>
								@empty
								<tr>
									<td colspan="6">{{ Lang::get('content.no purchase') }}!</td>
								</tr>
								@endforelse
							</tbody>
							<tfoot>
								<th colspan="6">*{{ Lang::get('content.displaying the latest 10 purchases') }}.</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><strong>{{ Lang::get('content.history of donations') }}</strong></h3>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center hidden-xs">
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<th>{{ Lang::choice('content.method', 1) }}</th>
								<th>{{ Lang::get('content.transaction code') }}</th>
								<th>{{ Lang::get('content.status') }}</th>
								<th>{{ Lang::choice('content.value', 1) }}</th>
								<th>{{ Lang::choice('content.point', 2) }}</th>
								<th>{{ Lang::get('content.date') }}</th>
							</thead>
							<tbody>
								@forelse($donations as $donation)
								<tr>
									<td>{{{ $donation->method }}}</td>
									<td>{{{ $donation->transacaoID or Lang::get('content.unknown') }}}</td>
									@if($donation->method == "PagSeguro")
									<td>{{{ $status['PagSeguro'][$donation->pagsegurotransacao->status]['status'] or Lang::get('content.unknown') }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status['PagSeguro'][$donation->pagsegurotransacao->status]['descricao'] or Lang::get('content.unknown') }}}"></i></td>
									@elseif($donation->method == "Moip")
									<td>{{{ $status['Moip'][$donation->moiptransacao->status]['status'] or Lang::get('content.unknown') }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status['Moip'][$donation->moiptransacao->status]['descricao'] or Lang::get('content.unknown') }}}"></i></td>
									@else
									<td>{{{ $status['Paypal'][$donation->paypaltransacao->status]['status'] or Lang::get('content.unknown') }}} <i class="fa fa-info-circle fa-fw" title="{{{ $status['Paypal'][$donation->paypaltransacao->status]['descricao'] or Lang::get('content.unknown') }}}"></i></td>
									@endif
									<td>R$ {{{ $donation->points*$configuracoes->cost_points }}}</td>
									<td>{{{ $donation->points or '0' }}}</td>
									<td>{{{ Helpers::ago($donation->date) }}}</td>
								</tr>
								@empty
								<tr>
									<td colspan="6">{{ Lang::get('content.no donation held') }}!</td>
								</tr>
								@endforelse
							</tbody>
							<tfoot>
								<th colspan="6">*{{ Lang::get('content.displaying the latest 10 donations') }}.</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="change_avatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				{{ Lang::get('content.choose an').' '.Lang::choice('content.avatar', 1) }}
			</div>
			<div class="modal-body">
				{{ Form::open(array('action' => 'UsersController@postAvatar', 'class' => 'form', 'name' => 'change_avatar')) }}

				<div class="form-group">
					{{ Form::label('avatares', Lang::choice('content.preview', 1)) }}
					{{ HTML::image('assets/img/avatares/0.png', Lang::choice('content.preview', 1), array('class' => 'img-responsive')) }}
				</div>
				<div class="form-group">
					{{ Form::label('avatares', Lang::choice('content.avatar', 2)) }}
					{{ Form::select('avatares', $avatares, null, array('single', 'class' => 'form-control')) }}
				</div>

				<div class="form-group">
					{{ Form::submit(Lang::get('content.change'), ['class' => 'btn btn-primary btn-block']) }}
				</div>

				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="change_privacy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<div class="tab-content">
					<h4 class="text-center"><strong>{{ Lang::get('content.configure privacy') }}</strong></h4>

					<div class="panel panel-primary">
						<div class="panel-body">

							{{ Form::open(array('action' => 'UsersController@postPrivacy', 'class' => 'form', 'name' => 'change_privacy')) }}

							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									{{ Form::label('email', Lang::get('content.email')) }}
									<div class="center-block">
										<label style="font-weight:normal">{{ Form::radio('email', '0', true) }} {{ Lang::get('content.show') }}</label>
										<label style="font-weight:normal">{{ Form::radio('email', '1') }} {{ Lang::get('content.hidden') }}</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::submit(Lang::get('content.change'), ['class' => 'btn btn-primary btn-block']) }}
							</div>

							{{ Form::close() }}
						</div>
					</div>
					
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="list_friends" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<div class="tab-content">
					<h4 class="text-center"><strong>{{ Lang::choice('content.friend', 2) }}</strong></h4>

					<div class="panel panel-primary">
						<div class="panel-body">
							@if($usuario->accountviplist()->exists())
							<ol>
								@foreach($usuario->accountviplist()->with('User', 'Player')->get() as $player)
								<li><a href="{{ action('PlayersController@getPersonagem', array('id' => $player->player->id)) }}" class="{{{ ($player->player->online) ? 'text-success' : 'text-danger' }}}" alt="{{ Lang::get('content.show character').' '.$player->player->name }}" title="{{ Lang::get('content.show character').' '.$player->player->name }}" target="my_friends">{{ $player->player->name }}</a></li>
								@endforeach
							</ol>
							@else
							{{ Lang::get('content.no character was found') }}!
							@endif
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="list_references" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<!-- Nav tabs -->
				<ul class="nav nav-pills nav-justified" role="tablist">
					<li role="presentation" class="active"><a href="#referencias" aria-controls="referencias" role="tab" data-toggle="tab">{{ Lang::get('content.referenced by') }}</a></li>
					<li role="presentation" class=""><a href="#premicoes" aria-controls="premicoes" role="tab" data-toggle="tab">{{ Lang::choice('content.award', 2) }}</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

					<div role="tabpanel" class="tab-pane fade in active" id="referencias">
						<div class="panel panel-primary">
							<div class="panel-body">
								@if($usuario->accountreferal()->exists())
								<ol class="row">
									@foreach($usuario->accountreferal()->with('User', 'Referal')->orderBy('date', 'asc')->get() as $conta)
									<li>
										{{ link_to_action('UsersController@getConta', ((!empty($conta->user->nickname) ? $conta->user->nickname : $conta->user->name)), $parameters = array('id' => $conta->user->id), $attributes = array('title' => 'Visualize a Conta de '.((!empty($conta->user->nickname) ? $conta->user->nickname : $conta->user->name)))) }}
									</li>
									@endforeach
								</ol>
								@else
								{{ Lang::get('content.any reference to you were found') }}!
								@endif
							</div>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="premicoes">
						<div class="panel panel-success">
							<div class="panel-body">

								<div class="table-responsive">
									<table class="table">
										<thead>
											<th>{{ Lang::choice('content.award', 2) }}</th>
											<th>{{ Lang::choice('content.reference', 2) }}</th>
											<th></th>
										</thead>
										<tbody>
											<tr>
												<th>{{ '1 '.Lang::choice('content.day', 1).' Vip' }}</th>
												<td>
													{{ ($awards['status'][1]) ? Lang::get('content.rescued') : (($awards['atual'][1]>=$awards['req'][1]) ? Lang::get('content.completed') : $awards['atual'][1].'/'.$awards['req'][1]) }}
													<i class="fa fa-info-circle" title="{{ Lang::get('content.ref1') }}"></i>
												</td>
												<td>
													{{ link_to_action('ReferenciasController@getResgatar', (!$awards['status'][1]) ? Lang::get('content.redeem') : Lang::get('content.rescued'), $parameters = array('c' => base64_encode(1)), $attributes = array( 'title' => (Lang::get('content.redeem').' '.Lang::choice('content.award', 1)), 'class' => 'btn btn-primary btn-xs btn-block', ((isset($awards['atual'][1]) && $awards['atual'][1]>=$awards['req'][1] && !$awards['status'][1]) ? null : 'disabled'))) }}
												</td>
											</tr>
											<tr>
												<th>{{ '3 '.Lang::choice('content.day', 2).' Vip' }}</th>
												<td>
													{{ ($awards['status'][2]) ? Lang::get('content.rescued') : (($awards['atual'][2]>=$awards['req'][2]) ? Lang::get('content.completed') : $awards['atual'][2].'/'.$awards['req'][2]) }}
													<i class="fa fa-info-circle" title="{{ Lang::get('content.ref2') }}"></i>
												</td>
												<td>
													{{ link_to_action('ReferenciasController@getResgatar', (!$awards['status'][2]) ? Lang::get('content.redeem') : Lang::get('content.rescued'), $parameters = array('c' => base64_encode(2)), $attributes = array( 'title' => (Lang::get('content.redeem').' '.Lang::choice('content.award', 1)), 'class' => 'btn btn-primary btn-xs btn-block', ((isset($awards['atual'][2]) && $awards['atual'][2]>=$awards['req'][2] && !$awards['status'][2]) ? null : 'disabled'))) }}
												</td>
											</tr>
											<tr>
												<th>{{ '30 '.Lang::choice('content.day', 2).' Vip' }}</th>
												<td>
													{{ ($awards['status'][3]) ? Lang::get('content.rescued') : (($awards['atual'][3]>=$awards['req'][3]) ? Lang::get('content.completed') : $awards['atual'][3].'/'.$awards['req'][3]) }}
													<i class="fa fa-info-circle" title="{{ Lang::get('content.ref3') }}"></i>
												</td>
												<td>
													{{ link_to_action('ReferenciasController@getResgatar', (!$awards['status'][3]) ? Lang::get('content.redeem') : Lang::get('content.rescued'), $parameters = array('c' => base64_encode(3)), $attributes = array( 'title' => (Lang::get('content.redeem').' '.Lang::choice('content.award', 1)), 'class' => 'btn btn-primary btn-xs btn-block', ((isset($awards['atual'][3]) && $awards['atual'][3]>=$awards['req'][3] && !$awards['status'][3]) ? null : 'disabled'))) }}
												</td>
											</tr>
											<tr>
												<th>{{ '1 '.Lang::choice('content.outfit', 1) }}</th>
												<td>
													{{ ($awards['status'][4]) ? Lang::get('content.rescued') : (($awards['atual'][4]>=$awards['req'][4]) ? Lang::get('content.completed') : $awards['atual'][4].'/'.$awards['req'][4]) }}
													<i class="fa fa-info-circle" title="{{ Lang::get('content.ref4') }}"></i>
												</td>
												<td>
													{{ link_to_action('ReferenciasController@getResgatar', (!$awards['status'][4]) ? Lang::get('content.redeem') : Lang::get('content.rescued'), $parameters = array('c' => base64_encode(4)), $attributes = array( 'title' => (Lang::get('content.redeem').' '.Lang::choice('content.award', 1)), 'class' => 'btn btn-primary btn-xs btn-block', ((isset($awards['atual'][4]) && $awards['atual'][4]>=$awards['req'][4] && !$awards['status'][4]) ? null : 'disabled'))) }}
												</td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/select2-3.5.4/select2.js') }}
{{ HTML::script('assets/plugins/select2-3.5.4/select2_locale_pt-BR.js') }}
{{ HTML::script('assets/plugins/clipboard/clipboard.min.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		var privacy = "{{ Session::has('privacy') }}";
		if(privacy){
			$('div[id=change_privacy]').modal('show');
		}

		var clipboard = new Clipboard('a[name="referal_link"]');
		clipboard.on('success', function(e) { alert("{{ Lang::get('content.link copied').'? '.Lang::get('content.yes') }}"); e.clearSelection(); });
		clipboard.on('error', function(e) { alert("{{ Lang::get('content.link copied').'? '.Lang::get('content.no') }}"); });

		var has_privacy = "{{ $usuario->accountprivacy()->exists() }}";
		if(has_privacy=="1"){
			$('form[name="change_privacy"] input[name="email"][value={{ (isset($usuario->accountprivacy->email)) ? $usuario->accountprivacy->email : 0 }}]').prop("checked", true);
		}

		$('select[name="avatares"]').select2({
			theme: "bootstrap",
			placeholder: "Selecione um avatar",
			maximumSelectionLength: 1,
			allowClear: true
		});

		$('button[id=btn_list_references]').on('click', function(){
			var btn = $(this);
			var modal = $('div[id=list_references]');
			modal.modal('show');
			modal.on('shown.bs.modal', function () {
			});
		});

		$('button[id=btn_list_friends]').on('click', function(){
			var btn = $(this);
			var modal = $('div[id=list_friends]');
			modal.modal('show');
			modal.on('shown.bs.modal', function () {
			});
		});

		$('button[id=btn_change_avatar]').on('click', function(){
			var btn = $(this);
			var modal = $('div[id=change_avatar]');
			modal.modal('show');
			modal.on('shown.bs.modal', function () {
			});
		});

		$('button[id=btn_change_privacy]').on('click', function(){
			var btn = $(this);
			var modal = $('div[id=change_privacy]');
			modal.modal('show');
			modal.on('shown.bs.modal', function () {
			});
		});

		$('form[name=change_avatar] select[name=avatares]').on('change', function(){
			var caminho = "{{ asset('assets/img/avatares') }}";
			$('form[name=change_avatar] img').attr('src', caminho+'/'+$(this).val().toLowerCase()+'.png');
		});

		$('form[name=change_avatar]').submit(function(e){
			var dado = $('form[name=change_avatar] select[name=avatares]').val();
			if(dado<1){ return false; }
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: "{{ route('alterar-avatar') }}",
				data: {
					avatares: dado
				},
				cache: false,
				beforeSend: function(){
				},
				success: function(retorno){
					if(retorno.status=="erro"){
						var html = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Aviso!</strong>'+retorno.msg+'</div>';
						$('form[name="change_avatar"').prepend(html);
					}else{
						showNotificacao("{{ $configuracoes->title or 'App Name' }}", retorno.msg, "{{ @(isset($favicon)) ? asset($favicon->path) : '' }}");
						$('button[id=btn_change_avatar]').remove();
						$('img[name=avatar]').attr('src', $('form[name="change_avatar"] img').attr('src'));
						$('div[id=change_avatar]').modal('hide');
						/*window.location.reload();*/
					}
				},
				error: function(){
				}
			});
		});

		$('button[name=btn_recovery_key]').on('click', function(){
			$.ajax({
				type: 'POST',
				url: "{{ route('gerar-recovery-key') }}",
				cache: false,
				beforeSend: function(){
				},
				success: function(retorno){
					if(retorno.status=="erro"){
						var html = '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Aviso!</strong>'+retorno.msg+'</div>';
						$('form[name="change_avatar"').prepend(html);
					}else{
						showNotificacao("{{ $configuracoes->title or 'App Name' }}", retorno.msg, "{{ @(isset($favicon)) ? asset($favicon->path) : '' }}");
						var html = '<span name="span_key">*************</span> <button type="button" class="btn btn-primary btn-xs" name="btn_key" rel="'+btoa(retorno.key)+'">Mostrar Key</button>';
						$('td[name=recovery_key]').html(html);
					}
				},
				error: function(){
				}
			});
		});

		$('button[name=btn_key]').on('click', function(){
			$('span[name=span_key]').text(atob($(this).attr('rel')));
			$(this).remove();
		});
	});
</script>
@stop