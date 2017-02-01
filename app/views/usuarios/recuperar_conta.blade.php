@extends('layouts.public')

@section('title', Lang::get('content.account recovery'))
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h4 class="foDi foDS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.we recommend that you always place a valid email') }}.</h4>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.we recommend that you always place a valid email') }}.</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@if(isset($errors) && count($errors->recuperacao))
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>{{ Lang::choice('content.notice', 1) }}!</strong>
				@foreach ($errors->recuperacao->all('<li>:message</li>') as $message)
				{{$message}}
				@endforeach
			</div>
			@endif

			<!-- Nav tabs -->
			<ul class="nav nav-pills nav-justified" role="tablist" id="key_email">
			<li role="presentation" class="active"><a href="#keyR" aria-controls="keyR" role="tab" data-toggle="tab">Recover Key</a></li>
				<li role="presentation" class=""><a href="#emailR" aria-controls="emailR" role="tab" data-toggle="tab">E-mail</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">

				<div role="tabpanel" class="tab-pane fade in active" id="keyR">
					<div class="panel panel-default">
						<div class="panel-heading">
							{{ Lang::get('content.to recover your account, your password will be changed as the filled in form below and sent to the email registered to the account') }}.
						</div>
						<div class="panel-body">
							{{ Form::open(array('action' => array('UsersController@postRecuperarConta'), 'class' => 'form', 'name' => 'recover_key')) }}

							{{ Form::hidden('type', 'key', array('id' => 'type', 'class' => 'form-control')) }}

							<div class="form-group">
								{{ Form::label('email', Lang::get('content.email')) }}
								{{ Form::email('email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('repeat_email', Lang::get('content.repeat email')) }}
								{{ Form::email('repeat_email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('key', Lang::get('content.recovery key')) }}
								{{ Form::text('key', null, array('placeholder' => 'a24kshASDGa1sfd12f', 'class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('password', Lang::get('content.password')) }}
								{{ Form::password('password', array('placeholder' => '******', 'class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('repeat_password', Lang::get('content.password')) }}
								{{ Form::password('repeat_password', array('placeholder' => '******', 'class' => 'form-control')) }}
							</div>

							<div class="form-group">
								{{ Form::submit(Lang::get('content.recover'), ['class' => 'btn btn-primary btn-block']) }}
							</div>

							{{ Form::close() }}
						</div>
					</div>
				</div>

				<div role="tabpanel" class="tab-pane fade" id="emailR">
					<div class="panel panel-default">
						<div class="panel-heading">
							{{ Lang::get('content.to recover your account, your password will be changed and sent to the email registered to the account') }}.
						</div>
						<div class="panel-body">
							{{ Form::open(array('action' => 'UsersController@postRecuperarConta', 'class' => 'form', 'name' => 'recover_email')) }}

							<div class="form-group">
								{{ Form::label('email', Lang::get('content.email')) }}
								{{ Form::email('email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('repeat_email', Lang::get('content.repeat email')) }}
								{{ Form::email('repeat_email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
							</div>

							<div class="form-group">
								{{ Form::submit(Lang::get('content.recover'), ['class' => 'btn btn-primary btn-block']) }}
							</div>

							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>


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