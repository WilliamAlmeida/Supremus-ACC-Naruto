@extends('layouts.admin')

@section('title', 'Usuários')
@section('sub_title', '<i class="fa fa-pencil-square-o fa-1x"></i> Editar')

@section('styles')

@stop

@section('content')
<a href="{{ action('UsersController@getIndex') }}" alt="Voltar para lista de Usuários" title="Voltar para lista de Usuários"><i class="fa fa-arrow-left fa-2x"></i></a>
<hr>
@if(isset($errors) && count($errors->usuario))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Aviso!</strong>
	@foreach ($errors->usuario->all('<li>:message</li>') as $message)
	{{$message}}
	@endforeach
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
		Informações do Usuário
	</div>
	<div class="panel-body">

		{{ Form::model(array('action' => 'UsersController@postEditar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Usuário</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Usuário', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::text('name', $usuario->name, array('placeholder' => 'Usuário', 'class' => 'form-control'))--}}
					{{{ $usuario->name }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::email('email', $usuario->email, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control'))--}}
					{{{ $usuario->email }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('password', 'Senha', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::password('newPassword', array('placeholder' => '******', 'class' => 'form-control'))--}}
					******
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('premdays', 'Status da Conta', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{{ ($usuario->premdays>0) ? 'Vip' : 'Normal' }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('premdays', 'Dias Vip', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::number('premdays', $usuario->premdays, array('placeholder' => 'Dias Vip', 'class' => 'form-control', 'min' => 0)) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('nickname', 'Nickname', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::text('nickname', $usuario->nickname, array('placeholder' => 'Nickname', 'class' => 'form-control'))--}}
					{{{ $usuario->nickname or 'Campo Nickname não preenchido.' }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('about_me', 'Sobre mim', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::textarea('about_me', $usuario->about_me, array('placeholder' => 'Sobre mim', 'class' => 'form-control ckeditor'))--}}
					{{{ $usuario->about_me or 'Campo sobre min não foi preenchido.' }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('lastday', 'Último Login', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::text('lastday', $usuario->about_me, array('placeholder' => 'Último Login', 'class' => 'form-control ckeditor'))--}}
					{{{ Helpers::formataData($usuario->created).', '.Helpers::ago($usuario->lastday) }}}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('created', 'Registrado em', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{--Form::text('created', $usuario->created, array('placeholder' => 'Registrado em', 'class' => 'form-control ckeditor'))--}}
					{{{ Helpers::formataData($usuario->created).', '.Helpers::ago($usuario->created) }}}
				</div>
			</div>
		</fieldset>

		<fieldset class="form-group">
			<legend class="text-info h4">Nível de Acesso</legend>
			<div class="form-group row">
				{{ Form::label('group_id', 'Nível de Acesso', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('group_id', $grupos, $usuario->group_id, ['class' => 'form-control']) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Atualizar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('ckeditor/ckeditor.js', array('async' => 'async')) }}
@stop

@section('script-execute')

@stop