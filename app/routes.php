<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

View::composers(array(
	'ConfiguracaoComposer' => array('layouts.public','layouts.admin','home.*','paginas.*','shops.*','houses.*','guilds.*','usuarios.*','players.*'),
	'ConfiguracaoComposer@painelTS' => array('home.*','paginas.*')
	));

Route::get('p/{slug}', array('as' => 'paginas', 'uses' => 'PaginasController@getPagina'));

/*Rota de definição da linguagem*/
Route::get('/language/{lang?}', function($lang = "pt-br"){ Session::set('language', $lang); return Redirect::to(URL::previous()); });
// setcookie("language", $lang, time()+3600*24*30*12*5);
/*Fim da rota de definição da linguagem*/

/*Route::when('*', 'csrf', array('POST'));*/

/*Rotas referente a integração do sistema*/
Route::group(array('prefix' => 'sistema'), function()
{
	Route::controller('integracao', 'IntegracoesController');
});
/*Fim das rotas referente a integração do sistema*/

/*Rotas referente a usuário deslogado*/
Route::group(['before' => 'guest'], function()
{
	Route::get('/login', array('as' => 'tela-login', 'uses' => 'HomeController@getLogin'));
	Route::post('/login', array('as' => 'logar', 'uses' => 'HomeController@postLogin'));
	
	Route::get('/registrar', array('as' => 'tela-registrar-usuario', 'uses' => 'HomeController@getRegister'));
	Route::post('/registrar', array('as' => 'registrar-usuario', 'uses' => 'HomeController@postRegister'));

	Route::get('/recuperar-conta', array('as' => 'tela-recuperar-conta', 'uses' => 'UsersController@getRecuperarConta'));
	Route::post('/recuperar-conta', array('as' => 'recuperar-conta', 'uses' => 'UsersController@postRecuperarConta'));
});
/*Fim das rotas referente a usuário deslogado*/

/*Rotas referentes a usuarios logados*/
Route::group(['before' => 'auth'], function()
{

	Route::group(array('prefix' => 'personagem'), function()
	{
		Route::get('/online', array('as' => 'online-player', 'uses' => 'PlayersController@getOnline'));
		Route::get('/ranking', array('as' => 'ranking-player', 'uses' => 'PlayersController@getRanking'));
		Route::get('/busca', array('as' => 'busca-player', 'uses' => 'PlayersController@getBusca'));
		Route::get('/ultimas-mortes', array('as' => 'ultimas-mortes', 'uses' => 'PlayersController@getUltimasMortes'));
		Route::get('/{id}', array('as' => 'personagem-player', 'uses' => 'PlayersController@getPersonagem'));
	});
	
	Route::get('/logout', array('as' => 'deslogar', 'uses' => 'HomeController@getLogout'));
	Route::get('/rate/{pontuacao?}/{usuario?}/{id?}/{tipo?}', 'RatesController@getRate');

	Route::group(array('prefix' => 'cupom'), function()
	{
		Route::post('/resgatar', array('as' => 'resgatar-cupom', 'uses' => 'CouponsController@postResgatar'));
		Route::get('/', array('as' => 'tela-resgate-cupom', 'uses' => 'CouponsController@getHome'));
	});


	Route::group(array('prefix' => 'shop'), function()
	{
		Route::post('/comprar/{item}', array('as' => 'comprar-item', 'uses' => 'ShopsController@postComprar'));
		Route::get('/', array('as' => 'shop', 'uses' => 'ShopsController@getHome'));
	});

	Route::group(array('prefix' => 'pagseguro'), function()
	{
		Route::get('/transacao/concluir', array('as' => 'concluir-transacao-pagseguro', 'uses' => 'PagseguroTransacoesController@getConcluirTransacao'));
		Route::post('/transacao', array('as' => 'efetuar-transacao-pagseguro', 'uses' => 'PagseguroTransacoesController@postEfetuarTransacao'));
	});

	Route::group(array('prefix' => 'moip'), function()
	{
		Route::get('/transacao/concluir', array('as' => 'concluir-transacao-moip', 'uses' => 'MoipTransacoesController@getConcluirTransacao'));
		Route::post('/transacao', array('as' => 'efetuar-transacao-moip', 'uses' => 'MoipTransacoesController@postEfetuarTransacao'));
	});

	Route::group(array('prefix' => 'paypal'), function()
	{
		Route::get('/transacao/concluir', array('as' => 'concluir-transacao-paypal', 'uses' => 'PaypalTransacoesController@getConcluirTransacao'));
		Route::post('/transacao', array('as' => 'efetuar-transacao-paypal', 'uses' => 'PaypalTransacoesController@postEfetuarTransacao'));
	});

	Route::group(array('prefix' => 'conta'), function()
	{
		Route::group(array('prefix' => 'personagem'), function()
		{
			Route::get('/desbugar/{id}', array('as' => 'desbugar-player', 'uses' => 'PlayersController@getDesbugar'));

			Route::get('/registrar', array('as' => 'tela-registrar-player', 'uses' => 'PlayersController@getRegister'));
			Route::post('/registrar', array('as' => 'registrar-player', 'uses' => 'PlayersController@postRegister'));
		});

		Route::get('/senha', array('as' => 'tela-alterar-senha', 'uses' => 'UsersController@getSenha'));
		Route::post('/senha', array('as' => 'alterar-senha', 'uses' => 'UsersController@postSenha'));
		
		Route::get('/email', array('as' => 'tela-alterar-email', 'uses' => 'UsersController@getEmail'));
		Route::post('/email', array('as' => 'alterar-email', 'uses' => 'UsersController@postEmail'));
		
		Route::get('/nickname', array('as' => 'tela-alterar-nickname', 'uses' => 'UsersController@getNickname'));
		Route::post('/nickname', array('as' => 'alterar-nickname', 'uses' => 'UsersController@postNickname'));

		Route::post('/avatar', array('as' => 'alterar-avatar', 'uses' => 'UsersController@postAvatar'));
		
		Route::post('/privacy', array('as' => 'alterar-privacidade', 'uses' => 'UsersController@postPrivacy'));

		Route::post('/recovery-key', array('as' => 'gerar-recovery-key', 'uses' => 'UsersController@postRecoveryKey'));

		Route::get('/award/{codigo?}', array('as' => 'regatar-premiacao', 'uses' => 'ReferenciasController@getResgatar'));

		Route::get('/{id}', array('as' => 'conta-player', 'uses' => 'UsersController@getConta'));
		Route::get('/', array('as' => 'minha-conta', 'uses' => 'UsersController@getHome'));
	});
});
/*Fim das rotas referente a usuarios logados*/

Route::group(array('prefix' => 'pagseguro'), function()
{
	Route::post('/notificacao', array('as' => 'receber-notificacao-pagseguro', 'uses' => 'PagseguroTransacoesController@getNotificacao'));
});
Route::group(array('prefix' => 'moip'), function()
{
	Route::post('/notificacao', array('as' => 'receber-notificacao-moip', 'uses' => 'MoipTransacoesController@getNotificacao'));
});
Route::group(array('prefix' => 'paypal'), function()
{
	Route::post('/notificacao', array('as' => 'receber-notificacao-paypal', 'uses' => 'PaypalTransacoesController@getNotificacao'));
});

Route::group(array('prefix' => 'launcher'), function()
{
	Route::get('/noticias', array('as' => 'launcher-noticias', 'uses' => 'NoticiasController@getLauncher'));
});

Route::get('/imoveis', array('as' => 'casas', 'uses' => 'HousesController@getCasas'));
Route::get('/imovel/{id}', array('as' => 'casa', 'uses' => 'HousesController@getCasa'));

Route::get('/guildas', array('as' => 'guildas', 'uses' => 'GuildsController@getGuildas'));
Route::get('/guilda/{id}', array('as' => 'guilda', 'uses' => 'GuildsController@getGuilda'));

Route::get('/categoria/{name?}', array('as' => 'categoria-noticias', 'uses' => 'NoticiasController@getNoticiaCategoria'));
/*Route::post('/categoria/{name?}', array('as' => 'filtro-categoria-post', 'uses' => 'NoticiasController@postNoticiaCategoria'));*/

Route::get('/noticias/{name?}', array('as' => 'busca-noticia', 'uses' => 'NoticiasController@getNoticiaPesquisa'));
Route::get('/noticia/{name?}', array('as' => 'noticia', 'uses' => 'NoticiasController@getNoticia'));

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::group(array('prefix' => 'painel', 'before' => 'auth.admin:2'), function()
{
	Route::get('/', array('as' => 'painel', 'uses' => 'HomeController@getDashboard'));

	Route::group(array('before' => 'auth.admin:3'), function()
	{
		Route::controller('midias', 'MidiasController');
		Route::controller('paginas', 'PaginasController');
		Route::controller('categorias-noticias', 'CategoriasNoticiasController');
		Route::controller('noticias', 'NoticiasController');
	});

	Route::group(array('before' => 'auth.admin:5'), function()
	{
		Route::controller('itens', 'ShopsController');
		Route::controller('personagens', 'PlayersController');
		Route::controller('usuarios', 'UsersController');
		Route::controller('cidades', 'CitiesController');
		Route::controller('cupons', 'CouponsController');
		Route::controller('punicoes', 'BansController');
	});

	Route::group(array('before' => 'auth.admin:6'), function()
	{
		Route::controller('transacoes', 'TransacoesController');

		Route::controller('pagseguro', 'PagseguroTransacoesController');
		Route::controller('moip', 'MoipTransacoesController');
		Route::controller('paypal', 'PaypalTransacoesController');
		
		Route::controller('configuracoes', 'ConfiguracoesController');
		Route::controller('registros', 'RegistrosController');
	});
});

/*Fim das rotas referente a usuarios logados*/