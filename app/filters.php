<?php

/* "pqb/filemanager-laravel": "2.*",
|--------------------------------------------------------------------------
| Application & Route Filters ----------- TOKEN PAGSEGURO - 532947552CF8461F921AC61010A2E89A
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	if(!Auth::check() && isset($_COOKIE['account'])){
		$valor = base64_decode($_COOKIE['account']);
		$valores = explode(',', $valor);

		$check = User::whereName($valores[0])->where('remember_token', '=', $valores[1])->first();
		if($check){
			Auth::login($check);
			$usuario = Auth::user(); $usuario->update(['lastday' => time(), 'remember_token' => str_random(60)]);

			$valores[1] = $usuario->remember_token;
			$resultado = implode(',', $valores);
			setcookie("account", base64_encode($resultado), time()+3600*24*30*12*5);

			Helpers::registrarLog($dados = array(
				'subject' => ('Usuario '.$usuario->name.' logou no sistema.'),
				'text' => null,
				'type' => 2, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));
		}
	}
	
	if(Session::get('language')){
		$lingua = Session::get('language');
	}elseif(Input::has('lang') && Input::get('lang')){
		$lingua = Input::get('lang');
		Session::put('language', Input::get('lang'));
	}
	if(isset($lingua)){
		if($lingua == "pt-br"){
			Lang::setLocale('pt-br');
		}else{
			Lang::setLocale('en');
		}
	}else{
		Lang::setLocale('en');
	}
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
0 = usuário comum
1 = usuário vip
2 = funcionário
3 = moderador
4 = administrador
5 = desenvolvedor
*/

Route::filter('auth.admin', function()
{
	if(!Auth::check()){
		return Redirect::route('tela-login');
	}

	$usuario = Auth::user();
	if($usuario->group_id < (int)Route::current()->beforeFilters()['auth.admin'][0])
	{
		return Redirect::to('painel')->with('message', 'Acesso negado a área '.Route::current()->getUri().'.');
	}
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if(Request::header('host') == "sandbox.pagseguro.uol.com.br" || Request::header('host') == "pagseguro.uol.com.br"){
		if(Session::token() !== csrf_token()){
			throw new Illuminate\Session\TokenMismatchException;
		}
	}
	elseif (Request::ajax()) 
	{
		if (Session::token() !== Request::header('csrftoken')) 
		{
            // Change this to return something your JavaScript can read...
			throw new Illuminate\Session\TokenMismatchException;
		}
	} 
	elseif (Session::token() !== Input::get('_token')) 
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
