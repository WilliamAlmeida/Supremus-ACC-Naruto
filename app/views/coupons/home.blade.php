@extends('layouts.public')

@section('title', 'Cupom')
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.rescue your coupon before it expires') }}.</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.rescue your coupon before it expires') }}.</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(isset($errors) && count($errors->cupom))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				@foreach ($errors->cupom->all('<li>:message</li>') as $message)
				{{$message}}
				@endforeach
			</div>
			@endif
			@if(Session::get('message'))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				{{ Session::get('message') }}
			</div>
			@endif

			{{ Form::open(array('action' => 'CouponsController@postResgatar', 'class' => 'form')) }}

			<div class="form-group">
				{{ Form::label('code', Lang::choice('content.coupon', 1)) }}
				{{ Form::text('code', null, array('placeholder' => 'AhmZm0W2', 'class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::submit(Lang::get('content.redeem'), ['class' => 'btn btn-primary btn-block']) }}
			</div>

			{{ Form::close() }}
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