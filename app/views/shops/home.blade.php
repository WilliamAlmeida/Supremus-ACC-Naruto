@extends('layouts.public')

@section('title', Lang::get('content.shop'))
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/plugins/select2-3.5.4/select2.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/select2-3.5.4/select2-bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/paymentFont/css/paymentfont.min.css', array('async' => 'async')) }}
@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.welcome to the shop') }} {{{ $configuracoes->title }}}</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.welcome to the shop') }} {{{ $configuracoes->title }}}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="row m-b">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
						<h3 class="m-z p-z"><strong>{{ Lang::get('content.account status') }}</strong></h3>
					</div>
					<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
						{{ HTML::image('assets/img/empty.png', Lang::get('content.account status'), array('class' => 'center-block img-responsive simbolo')) }}
					</div>
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
						<h4><strong>{{ Lang::choice('content.account', 1) }} {{ ($usuario->premdays>0) ? 'Vip' : 'Normal' }}</strong></h4>
						{{ Lang::choice('content.point', 2) }} : {{ $usuario->premium_points or '0' }}
						<br/>
						{{ Lang::get('content.points spent') }} : {{ $usuario->premium_points_lost or '0' }}
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-t p-t">
						<button type="button" class="btn btn-danger btn-sm" id="btn_hoW_to_donate" alt="{{ Lang::get('content.how to buy points') }}" rel="como_donatar">
							<i class="fa fa-book fa-3x"></i> {{ Lang::get('content.how to buy points') }}
						</button>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
						<h3 class="m-z p-z"><strong>{{ Lang::choice('content.operation', 2) }}</strong></h3>
					</div>
					<div class="col-lg-3 col-md-3 text-primary text-center hidden-sm hidden-xs">
						<i class="fa fa-diamond fa-5x"></i>
					</div>
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
						@if(isset($errors) && count($errors->cupom))
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>{{ Lang::choice('content.notice', 2) }}!</strong>
							@foreach ($errors->cupom->all('<li>:message</li>') as $message)
							{{$message}}
							@endforeach
						</div>
						@endif
						@if(Session::get('message'))
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>{{ Lang::choice('content.notice', 2) }}!</strong>
							{{ Session::get('message') }}
						</div>
						@endif
						{{ Form::open(array('action' => 'PagseguroTransacoesController@postEfetuarTransacao', 'class' => 'form', 'name' => 'buy_points')) }}

						{{ Form::hidden('item', 'Pontos', array('id' => 'id', 'class' => 'form-control')) }}
						<div class="row">

							<div class="col-lg-6 col-xs-12">
								<div class="form-group has-feedback" id="points">
									{{ Form::label('points', Lang::choice('content.point', 2)) }}
									{{ Form::number('points', 0, array('id' => 'points', 'placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
									<span class="form-control-feedback glyphicon" aria-hidden="true"></span>
								</div>
							</div>

							<div class="col-lg-6 col-xs-12">
								<div class="form-group">
									{{ Form::label('code', Lang::choice('content.coupon', 1)) }}
									{{ Form::text('code', null, array('placeholder' => 'Zs25DA7SF', 'class' => 'form-control')) }}
								</div>
							</div>

						</div>

						<div class="form-group">
							{{ Form::label('preco', Lang::choice('content.price', 2).':', array('class' => '')) }}
							<span class="preco-real">R$ 0,00</span>
						</div>

						<div class="form-group" id="payment">
							{{ Form::label('tipo_pagamento', Lang::choice('content.form of payment', 2).':', array('class' => '')) }}

							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#brl" aria-controls="brl" role="tab" data-toggle="tab"><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-br" alt="BRL" title="BRL" /></a></li>
								<li role="presentation" class="disabled"><a href="javascript:void(0)" aria-controls="us" role="tab" data-toggle="tab"><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-us" alt="US" title="US" /></a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="brl">
									<div class="panel panel-default">
										<div class="panel-body">
											<ul class="list-unstyled list-inline">
												<li><button type="button" class="btn btn-default m-z active" rel="{{ action('efetuar-transacao-pagseguro') }}" {{ ($payments['pagseguro']) ? null : 'disabled' }}><span class="pf pf-pagseguro payment-3x" style="color:#009C5D"></span></button></li>
												<li><button type="button" class="btn btn-default m-z" rel="{{ action('efetuar-transacao-moip') }}" {{ ($payments['moip']) ? null : 'disabled' }}><span class="pf pf-moip payment-3x text-info"></span></button></li>
												<li><button type="button" class="btn btn-default m-z" rel="{{ action('efetuar-transacao-paypal') }}" {{ ($payments['paypal']) ? null : 'disabled' }}><span class="pf pf-paypal payment-3x text-info"></span></button></li>
											</ul>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="us">
									<div class="panel panel-default">
										<div class="panel-body">
											<ul class="list-unstyled list-inline">
												<li><button type="button" class="btn btn-default m-z" disabled><span class="pf pf-paypal payment-3x text-primary"></span></button></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							{{ Form::submit(Lang::get('content.buy'), ['class' => 'btn btn-primary btn-block', ($configuracoes->pagseguro_email && $configuracoes->pagseguro_token) ? null : 'disabled']) }}
						</div>

						{{ Form::close() }}
					</div>
				</div>
			</div>

			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#shop" aria-controls="shop" role="tab" data-toggle="tab">{{ Lang::get('content.shop') }}</a></li>
						<li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">{{ Lang::choice('content.history', 1) }}</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="shop">
							<div class="panel panel-default">
								<div class="panel-body">
									@if(Session::get('message_item'))
									<div class="alert alert-warning alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong>{{ Lang::choice('content.notice', 2) }}!</strong>
										{{ Session::get('message_item') }}
									</div>
									@endif
									<div class="row m-b">
										@forelse($itens as $item)
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
											<div class="thumbnail">
												@if(!$item->midiashopoffer->isEmpty())
												{{ HTML::image(str_replace('-original', '-banner', $item->midiashopoffer->first()->path), $item->midiashopoffer->first()->name, array('title' => $item->midiashopoffer->first()->name, 'class' => 'center-block img-responsive')) }}
												@endif
												<div class="caption">
													<h5 name="name"><strong>{{{ $item->name }}}</strong></h5>
													<p name="description">{{{ $item->description }}}</p>
													@if($item->points_off)
													<p><s><strong>DE:</strong>  <span name="points">{{{ $item->points }}}</span> Pts</s></p>
													<p><strong>POR:</strong> <span name="points_off">{{{ $item->points_off }}}</span> Pts</p>
													@else
													<p><strong>POR:</strong> <span name="points">{{{ $item->points }}}</span> Pts</p>
													@endif
												</div>
												{{ Form::button(Lang::get('content.buy'), ['rel' => $item->id, 'class' => 'btn btn-primary btn-xs btn-block', ($item->points_off) ? (($usuario->premium_points >= $item->points_off) ? null : 'disabled') : (($usuario->premium_points >= $item->points) ? null : 'disabled')] ) }}
											</div>
										</div>
										@empty
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											{{ Lang::get('content.any registered item') }}.
										</div>
										@endforelse
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="history">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="row m-b">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
											<h3 class="m-z p-z"><strong>{{ Lang::get('content.purchase history') }}</strong></h3>
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
														@forelse($history as $key => $compra)
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

					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="finalizar_compra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				{{ Lang::get('content.confirmation of your purchase') }}
			</div>
			<div class="modal-body">
				{{ Form::open(array('action' => array('ShopsController@postComprar', null), 'class' => 'form', 'name' => 'buy_item')) }}

				{{ Form::hidden('item', 'Pontos', array('id' => 'id', 'class' => 'form-control')) }}

				<fieldset class="form-group">
					<legend class="text-info h4">{{ Lang::get('content.information about the item') }}.</legend>
					<div class="col-lg-12 row">
						{{ HTML::image('', 'Item', array('title' => 'Item', 'class' => 'hidden center-block img-responsive')) }}
						<div class="caption">
							<h5 name="name"></h5>
							<p name="description"></p>
						</div>
					</div>
				</fieldset>

				<fieldset class="form-group">
					<legend class="text-info h4">{{ Lang::get('content.choose whom will receive the item') }}.</legend>
					<div class="form-group row">
						{{ Form::label('my_player', Lang::get('content.my characters').':', array('class' => 'col-lg-4 form-control-label')) }}
						<div class="col-lg-8">
							{{ Form::select('my_player', $lista_players, null, array('single', 'class' => 'form-control')) }}
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('present', Lang::get('content.present').'?', array('class' => 'col-lg-4 form-control-label')) }}
						<div class="col-lg-8">
							<label class="c-input c-checkbox">
								{{ Form::checkbox('present', '1', false) }}
								<span class="c-indicator"></span>
								{{ Lang::get('content.yes') }}
							</label>
						</div>
					</div>
					<div class="form-group row">
						{{ Form::label('friend_player', Lang::get('content.characters in general').':', array('class' => 'col-lg-4 form-control-label')) }}
						<div class="col-lg-8">
							{{ Form::select('friend_player', $lista_friends, null, array('single', 'class' => 'form-control', 'disabled' => 'disabled')) }}
						</div>
					</div>
				</fieldset>

				<fieldset>
					<legend class="text-info h4">{{ Lang::get('content.choose the amount you want to buy') }}.</legend>
					<div class="form-group row has-feedback" id="count">
						{{ Form::label('quantidade', Lang::get('content.quantity').':', array('class' => 'col-lg-2 form-control-label')) }}
						<div class="col-lg-10">
							{{ Form::number('quantidade', 0, array('placeholder' => '0', 'class' => 'form-control', 'min' => 0)) }}
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							{{ Form::label('my_points', Lang::get('content.my points').':', array('class' => '')) }}
							<span name="my_points">0</span>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							{{ Form::label('points', Lang::choice('content.value', 1).':', array('class' => '')) }}
							<span name="points">0</span>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							{{ Form::label('points_total', Lang::get('content.final value').':', array('class' => '')) }}
							<span name="points_total">0</span>
						</div>
					</div>
				</fieldset>

				<div class="form-group">
					{{ Form::submit(Lang::get('content.finalise purchase'), ['class' => 'btn btn-primary btn-block']) }}
				</div>

				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="hoW_to_donate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">

				<div class="tab-content">
					<h4 class="text-center"><strong>{{ Lang::get('content.how to buy points') }}</strong></h4>

					<div class="panel panel-primary">
						<div class="panel-body">

							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#guide_brl" aria-controls="guide_brl" role="tab" data-toggle="tab"><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-br" alt="BRL" title="BRL" /></a></li>
								<li role="presentation"><a href="#guide_us" aria-controls="guide_us" role="tab" data-toggle="tab"><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-us" alt="US" title="US" /></a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="guide_brl">
									<div class="panel panel-default">
										<div class="panel-body">

											<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingOne">
														<h4 class="panel-title">
															<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																Passo 1
															</a>
														</h4>
													</div>
													<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
														<div class="panel-body">
															Estando na Loja do Site, você deverá digitar quantos pontos deseja comprar no campo informado na imagem abaixo.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/part1.jpg', 'part1', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingTwo">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
																Passo 2
															</a>
														</h4>
													</div>
													<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
														<div class="panel-body">
															Enquanto é digitado a quantia de pontos que deseja comprar, logo abaixo será informado o valor total de sua compra.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/part2.jpg', 'part1', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingThree">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
																Passo 3
															</a>
														</h4>
													</div>
													<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
														<div class="panel-body">
															Este passo é opcional, você poderá digitar seu cupom de desconto no campo a seguir.
															<br/>
															<strong>Obs.:</strong> Você não é obrigado a digitar o cupom.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/part3.jpg', 'part1', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingFour">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
																Passo 4
															</a>
														</h4>
													</div>
													<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
														<div class="panel-body">
															Neste passo você irá selecionar a forma de pagamento que deseja efetuar sua compra e através de qual moeda deseja pagar.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/part4.jpg', 'part1', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading" role="tab" id="headingFive">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
																Passo 5
															</a>
														</h4>
													</div>
													<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
														<div class="panel-body">
															Após os 4 passos anterior, você deverá clicar no botão Comprar para iniciar a sua compra que será realizada na página empresa ao qual você selecionou como forma de pagamento.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/part5.jpg', 'part1', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-success">
													<div class="panel-heading" role="tab" id="headingPagSix">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePagSix" aria-expanded="false" aria-controls="collapsePagSix">
																Pagseguro - Passo 6
															</a>
														</h4>
													</div>
													<div id="collapsePagSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPagSix">
														<div class="panel-body">
															Caso você selecione a forma de pagamento do Pagseguro.
															<br/>
															Se você não estiver efetuado o Login em sua conta do Pagseguro você será redirecionado para esta página para que possa efetuar o Login e inicie o processo de pagamento de seus pontos.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag1.jpg', 'pag1', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
															Agora se você já tiver efetuado o Login você verá a página da seguinte forma.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag1-2.jpg', 'pag2', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-success">
													<div class="panel-heading" role="tab" id="headingPagSeven">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePagSeven" aria-expanded="false" aria-controls="collapsePagSeven">
																Pagseguro - Passo 7
															</a>
														</h4>
													</div>
													<div id="collapsePagSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPagSeven">
														<div class="panel-body">
															Nesta etapa você irá selecionar como você irá pagar seus pontos.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag2.jpg', 'pag2', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag3.jpg', 'pag3', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
															Assim que selecionar a forma de pagamento e preencher todos os campos corretamente clique no botão "Confirmar Pagamento" ou "Gerar Boleto" dependendo do que você selecionou.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag3-2.jpg', 'pag3-2', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag2-2.jpg', 'pag2-2', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-danger">
													<div class="panel-heading" role="tab" id="headingPagEight">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePagEight" aria-expanded="false" aria-controls="collapsePagEight">
																Pagseguro - Passo 8
															</a>
														</h4>
													</div>
													<div id="collapsePagEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPagEight">
														<div class="panel-body">
															<h4><strong>Agora vamos ao passo mais importante após o pagamento.</strong></h4>
															Assim que efetuar o pagamento ou gerar o boleto o Pagseguro ire lhe retorna para nosso Website em 60 segundos e ao mesmo tempo ele te dará a opção de “Voltar para a Loja” caso não queira esperar.
															<br/><br/>
															<strong>Aviso:</strong> É necessário que você retorna ao Website escolhendo uma das duas formas citadas acima, caso isso não aconteça seu pagamento não será concluído com sucesso e você terá que entrar em contato através do e-mail "sales@dworpg.com”.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag4.jpg', 'pag4', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
															Caso tenha escolhido forma de pagamento por Boleto, logo após clicar em Gerar Boleto irá abrir uma janela com o boleto e a opção para escolher em qual banco irá paga-lo usando Internet Bank ou Imprimir o Boleto e até mesmo baixa-lo.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/pag4-2.jpg', 'pag4-2', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-info">
													<div class="panel-heading" role="tab" id="headingPagNine">
														<h4 class="panel-title">
															<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePagNine" aria-expanded="false" aria-controls="collapsePagNine">
																Passo 9
															</a>
														</h4>
													</div>
													<div id="collapsePagNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPagNine">
														<div class="panel-body">
															Quando retorna para o Website você será informado se seu pagamento foi concluído com sucesso da mesma forma que ilustra a imagem abaixo.
															<div class="text-center m-t m-b">
																{{ HTML::image('assets/img/tutorial_donate/brl/part6.jpg', 'part6', array('class' => 'img-responsive center-block table-bordered')) }}
																<span class="help-block"><small>Imagem meramente illustrativa.</small></span>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="guide_us">
									<div class="panel panel-default">
										<div class="panel-body">

										</div>
									</div>
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
{{ HTML::script('assets/js/jquery.mask.min.js', array('async' => 'async')) }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){
		$('select[name="my_player"], select[name="friend_player"]').select2({
			theme: "bootstrap",
			placeholder: "{{ Lang::get('content.select a character') }}",
			maximumSelectionLength: 1,
			allowClear: true
		});

		var preco = "{{{ $configuracoes->cost_points }}}";
		$('form[name=buy_points]').submit(function(e){
			if($('form[name=buy_points] input[id=points]').val()<1){
				$('form[name=buy_points] div[id=points]').removeClass("has-success").addClass("has-warning"); $('form[name=buy_points] div[id=points] span').removeClass("glyphicon-ok").addClass("glyphicon-remove"); e.preventDefault();
			}else{
				$('form[name=buy_points] div[id=points]').addClass("has-success").removeClass("has-warning"); $('form[name=buy_points] div[id=points] span').addClass("glyphicon-ok").removeClass("glyphicon-remove");
				if(!confirm('Você leu o guia de como "{{ Lang::get("content.how to buy points") }}"?\nPorque o Passo 8 é muito importante que seja seguido, se não seu pagamento não será concluido.')){
					e.preventDefault();
				}
			}
		});
		$('form[name=buy_points] input[id=points]').on('input', function(){
			if($('form[name=buy_points] input[id=points]').val()>0){ $('form[name=buy_points] div[id=points]').addClass("has-success").removeClass("has-warning"); $('form[name=buy_points] div[id=points] span').addClass("glyphicon-ok").removeClass("glyphicon-remove"); }else{ $('form[name=buy_points] div[id=points]').removeClass("has-success").addClass("has-warning"); $('form[name=buy_points] div[id=points] span').removeClass("glyphicon-ok").addClass("glyphicon-remove"); }
			$('span.preco-real').text("R$ "+ numeroParaMoeda($(this).val()*preco) );
		});

		var shop = $('div[id=finalizar_compra]').find('form[name=buy_item]').attr('action');
		var meus_pontos = "{{{ $usuario->premium_points }}}";
		var pontos = 0;
		$('div[id=shop] div[class=thumbnail] button').on('click', function(){
			var item = $(this).parents('div[class=thumbnail]');
			var modal = $('div[id=finalizar_compra]');
			modal.modal('show');
			modal.find('form[name=buy_item]').attr('action', shop+'/'+$(this).attr('rel'));
			modal.find('div[class=caption] h5[name=name]').html(item.find('h5[name=name]').html());
			modal.find('div[class=caption] p[name=description]').html(item.find('p[name=description]').html());
			modal.find('span[name=my_points]').text(meus_pontos);
			if(item.find('span[name=points_off]').text()!=""){
				modal.find('span[name=points]').text(item.find('span[name=points_off]').text()+' Pts');
				pontos = item.find('span[name=points_off]').text();
			}else{
				modal.find('span[name=points]').text(item.find('span[name=points]').text()+' Pts');
				pontos = item.find('span[name=points]').text();
			}
		});

		$('form[name=buy_item]').submit(function(e){
			if($('form[name=buy_item] input[id=quantidade]').val()<1 || $('form[name=buy_item] input[id=quantidade]').val()*pontos > meus_pontos){ $('form[name=buy_item] div[id=count]').removeClass("has-success").addClass("has-warning"); e.preventDefault(); }else{ $('form[name=buy_item] div[id=count]').addClass("has-success").removeClass("has-warning"); }
		});
		$('form[name=buy_item] input[id=quantidade]').on('input', function(){
			if($('form[name=buy_item] input[id=quantidade]').val()>0 && $('form[name=buy_item] input[id=quantidade]').val()*pontos <= meus_pontos){ $('form[name=buy_item] div[id=count]').addClass("has-success").removeClass("has-warning"); }else{ $('form[name=buy_item] div[id=count]').removeClass("has-success").addClass("has-warning"); }
			$('form[name=buy_item] span[name=points_total]').text($(this).val()*pontos+' Pts');
		});

		var form = 'form[name=buy_item]';
		$(form+' input:checkbox[name=present]').on('click', function(){
			if($(form+' input:checkbox[name=present]').prop('checked')){
				$(form+' select[name=friend_player]').prop('disabled', false);
				$(form+' select[name=my_player]').prop('disabled', true);
			}else{
				$(form+' select[name=friend_player]').prop('disabled', true);
				$(form+' select[name=my_player]').prop('disabled', false);
			}
		});

		$('div[id=payment] button').on('click', function(){
			if($(this).prop('disabled')==false){
				$('div[id=payment] button').removeClass('active');
				$(this).addClass('active');
				$('form[name=buy_points]').attr('action', $(this).attr('rel'));
			}
		});

		$('button[id=btn_hoW_to_donate]').on('click', function(){
			var btn = $(this);
			var modal = $('div[id=hoW_to_donate]');
			modal.modal('show');
			modal.on('shown.bs.modal', function () {
			});
		});

	});

function numeroParaMoeda(n, c, d, t) { c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0; return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : ""); }
</script>
@stop