@extends('layouts.admin')

@section('title', 'Usuários')
@section('sub_title', '<i class="fa fa-plus fa-1x"></i> Adicionar')

@section('styles')

@stop

@section('content')
<a href="{{ url('usuarios') }}" alt="Voltar para lista de Usuários" title="Voltar para lista de Usuários"><i class="fa fa-arrow-left fa-2x"></i></a>
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
		Formulário de Usuários
	</div>
	<div class="panel-body">

		{{ Form::open(array('action' => 'UsersController@getAdicionar')) }}

		<fieldset class="form-group">
			<legend class="text-info h4">Usuário</legend>
			<div class="form-group row">
				{{ Form::label('name', 'Nome', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::text('name', null, array('placeholder' => 'Nome', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('email', 'E-mail', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::email('email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				{{ Form::label('password', 'Senha', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::password('password', array('placeholder' => '******', 'class' => 'form-control')) }}
				</div>
			</div>
		</fieldset>

		<fieldset class="form-group">
			<legend class="text-info h4">Nível de Acesso</legend>
			<div class="form-group row">
				{{ Form::label('nivel_users_id', 'Nível de Acesso', array('class' => 'col-lg-2 form-control-label')) }}
				<div class="col-lg-10">
					{{ Form::select('nivel_users_id', $niveis, null, array('id' => 'name', 'class' => 'form-control')) }}
				</div>
			</div>
		</fieldset>

		{{ Form::submit('Cadastrar', ['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
</div>
@stop

@section('scripts')

@stop

@section('script-execute')

@stop