@extends('layouts.public')

@section('title', 'Guilda')
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">Detalhes da Guilda no {{ $configuracoes->title or 'App Name' }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md">Detalhes da Guilda no {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if($guild->count()>0)
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t">
					<h3 class="m-z p-z"><i class="fa fa-home fa-3x"></i> <strong>{{ $guild->name }}</strong></h3>
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
									<th>Proprietário</th>
									<td></td>
								</tr>
								<tr>
									<th>Mundo</th>
									<td>{{ $mundos[$guild->world_id] }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@else
			Guilda não foi encontrada!
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