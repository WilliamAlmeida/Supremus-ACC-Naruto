@extends('layouts.public')

@section('title', Lang::get('content.register'))
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h4 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.register and venture into the world of') }} {{ $configuracoes->title or 'App Name' }}</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.register and venture into the world of') }} {{ $configuracoes->title or 'App Name' }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(isset($errors) && count($errors->usuario))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				@foreach ($errors->usuario->all('<li>:message</li>') as $message)
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

			{{ Form::model(array('action' => 'HomeController@postRegister', 'class' => 'form')) }}

			<div class="form-group">
				{{ Form::label('name', Lang::choice('content.account', 1)) }}
				<i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
				{{ Form::text('name', null, array('placeholder' => 'William.', 'class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('nickname', Lang::get('content.nickname')) }}
				<i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
				{{ Form::text('nickname', null, array('placeholder' => 'Dragon Slayer.', 'class' => 'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('email', Lang::get('content.email')) }}
				<i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
				{{ Form::email('email', null, array('placeholder' => 'william@digimon.com', 'class' => 'form-control')) }}
			</div>
			<div class="col-lg-6 col-xs-6 p-z p-r">
				<div class="form-group">
					{{ Form::label('password', Lang::get('content.password')) }}
					<i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
					{{ Form::password('password', array('placeholder' => '******', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="col-lg-6 col-xs-6 p-z p-l">
				<div class="form-group">
					{{ Form::label('repeat_password', Lang::get('content.repeat password')) }}
					<i class="fa fa-info-circle" title="Campo Obrigatório"></i>
					{{ Form::password('repeat_password', array('placeholder' => '******', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="col-lg-6 col-xs-6 p-z p-r">
				<div class="form-group">
					{{ Form::label('code', Lang::choice('content.coupon', 1)) }}
					<i class="fa fa-info-circle" title="{{ Lang::choice('content.field optional', 1) }}"></i>
					{{ Form::text('code', null, array('placeholder' => 'AhmZm0W2', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="col-lg-6 col-xs-6 p-z p-l">
				<div class="form-group">
					{{ Form::label('referal', Lang::get('content.referral')) }}
					<i class="fa fa-info-circle" title="{{ Lang::choice('content.field optional', 1) }}"></i>
					{{ Form::text('referal', ($referal) ? $referal : null, array('placeholder' => '', 'class' => 'form-control', 'readonly')) }}
				</div>
			</div>

			<div class="form-group">
				{{ Form::submit(Lang::get('content.register'), ['class' => 'btn btn-primary btn-block']) }}
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