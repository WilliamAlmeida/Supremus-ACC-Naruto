@extends('layouts.public')

@section('title', 'Imóvel')
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">Detalhes do Imóvel no {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">Detalhes do Imóvel no {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($house->count()>0)
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><i class="fa fa-home fa-3x"></i> <strong>{{ $house->name }}</strong></h3>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<th>Imagem</th>
									<td>
										{{--HTML::image('assets/img/user.png', 'Status da Conta', array('class' => 'center-block img-responsive'))--}}
									</td>
								</tr>
								<tr>
									<th>Preço</th>
									<td>{{ $house->price }} dollar(s)</td>
								</tr>
								<tr>
									<th>Tipo de Imóvel</th>
									<td>{{ ($house->guild) ? 'Guild' : 'Comum' }}</td>
								</tr>
								<tr>
									<th>Possui Proprietário</th>
									<td>{{ ($house->owner) ? 'Sim, valor pago foi de '.$house->price.' dollar(s).' : 'Não, ela está livre para ser comprada.' }}</td>
								</tr>
								@if($house->owner)
								<tr>
									<th>Proprietário</th>
									<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $house->player->id)) }}" class="" alt="Visualizar Personagem {{ $house->player->name }}" title="Visualizar Personagem {{ $house->player->name }}">{{ $house->player->name }}</a></td>
								</tr>
								<tr>
									<th>Comprada em</th>
									<td>{{ Helpers::formataData(date('d/m/Y h:i:s', $house->paid)).', '.Helpers::ago($house->paid) }}</td>
								</tr>
								<tr>
									<th>Alugel</th>
									<td>{{ $house->rent }} dollar(s)</td>
								</tr>
								@endif
								<tr>
									<th>Cidade</th>
									<td>{{ $house->city->name or 'Desconhecida' }}</td>
								</tr>
								<tr>
									<th>Mundo</th>
									<td>{{ $mundos[$house->world_id] or 'Desconhecido' }}</td>
								</tr>
								<tr>
									<th>Dimensão</th>
									<td>{{ $house->size }} sqm <i class="fa fa-info-circle fa-fw" title="Metros Quadrados / Square Metres"></i></td>
								</tr>
								<tr>
									<th>Camas</th>
									<td>{{ $house->beds }}</td>
								</tr>
								<tr>
									<th>Portas</th>
									<td>{{ $house->doors }}</td>
								</tr>
								<tr>
									<th>Telhados</th>
									<td>{{ $house->tiles }}</td>
								</tr>
								<tr>
									<th></th>
									<td><button type="button" class="btn btn-primary btn-xs" id="btn_buy_house" alt="Comprar Imóvel" title="Função desativada!" rel="{{ route('home') }}" disabled>Comprar</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@else
			Imóvel não foi encontrado!
			@endif
		</div>
	</div>
</div>
@stop

@section('scripts')

@stop

@section('script-execute')
<script type="text/javascript" async="async">
	$(document).ready(function(){

	});
</script>
@stop