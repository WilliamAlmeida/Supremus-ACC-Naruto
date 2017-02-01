<?php

class HomeController extends \BaseController {

	public function index()
	{
		$noticias = Noticia::with('User', 'CategoriaNoticia', 'MidiaNoticia')->orderBy('featured', 'desc')->get();

		$noticias_featured = Noticia::with('User', 'CategoriaNoticia', 'MidiaNoticia')->where('featured', '=', 1)
		->whereHas('MidiaNoticia', function($q)
		{
			$q->where('capa', '=', 1);
		})->get();

		$noticias_featured = $noticias_featured->sortByDesc('id');

		$noticias = $noticias->sortByDesc('id')->take(3);

		return View::make('home.index', compact('noticias', 'noticias_featured'));
	}

	public function getLogin()
	{
		return View::make('home.login');
	}

	public function postLogin()
	{
		$rules = array(
			'name' => array('required','min:1','max:32'),
			'password' => array('required','min:1','max:20','alpha_dash')
			);

		$validator = Validator::make($data = Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::route('tela-login')->withErrors($validator, 'usuario')->withInput();
		}

		$credentials = array();
		$credentials = array_add($credentials, 'name', $data['name']);
		$credentials = array_add($credentials, 'password', $data['password']);

		$usuario = User::with('Ban')->whereName($credentials['name'])->wherePassword(sha1($credentials['password']))->first();
		if($usuario){
			$banimento = $usuario->ban()->with('Admin')->whereType(3)->whereActive(1)->first();
			if($banimento){
				$msg = "A conta '".$credentials['name']."' foi banida por ".(($banimento->admin->nickname) ? $banimento->admin->nickname : $banimento->admin->name)." em ".Helpers::formataData(date('Y-m-d h:i:s', $banimento->added));
				return Redirect::route('tela-login')->withErrors($msg, 'usuario');
			}
		}

		if(Helpers::nAuth($credentials, (Input::get('remeber_me')) ? true : false)) {
			$usuario = Auth::user(); $usuario->update(['lastday' => time()]);

			Helpers::registrarLog($dados = array(
				'subject' => ('Usuario '.$usuario->name.' logou no sistema.'),
				'text' => null,
				'type' => 2, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));

			Session::flash('notificacoes', Lang::get('content.logged in successfully').'!');
			return Redirect::route('minha-conta');
			// return Redirect::intended('home');
		} else {
			return Redirect::route('tela-login')->withErrors(Lang::get('content.user and/or password invalid'), 'usuario');
		}
	}

	public function getRegister()
	{
		if(Input::has('referal')){
			$referal = User::with('Player')->findOrFail(base64_decode(Input::get('referal')))->name;
		}else{
			$referal = null;
		}

		return View::make('home.register', compact('referal'));
	}

	public function postRegister()
	{
		$rules = array(
			'name' => array('unique:accounts','required','min:4','max:32'),
			'email' => array('unique:accounts','required','min:6','max:255','email'),
			'password' => array('required','min:6','max:20','alpha_dash'),
			'nickname' => array('required','min:3','max:48'),
			'code' => array('min:1','max:255'),
			'referal' => array('min:2','max:32')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('tela-registrar-usuario')->withErrors($validator, 'usuario')->withInput();
		}

		if(Input::has('code')){
			$cupom = Coupon::whereCode($data['code']);
			if(!$cupom->exists())
			{
				return Redirect::route('tela-registrar-usuario')->with('message', Lang::get('content.sorry invalid coupon, enter an existing coupon').'.');
			}else{
				$cupom = $cupom->first();
				if(date('Y-m-d h:i:s') > $cupom->validate)
				{
					return Redirect::route('tela-registrar-usuario')->with('message', Lang::get('content.sorry, but the coupon expired in', ['name' =>$cupom->name, 'date' => Helpers::formataData($cupom->validate)]).'.');
				}
			}
		}

		$data['password'] = sha1($data['password']);
		$data = array_add($data, 'created', time());
		$data = array_add($data, 'lastday', time());
		$data['name'] = trim($data['name']);

		$resultado = User::create($data);

		if($resultado->count()>1){
			Auth::login($resultado);
			
			if(isset($cupom->count)){ Helpers::vip(Auth::user(), 1, $cupom->count); }

			if(Input::has('referal') && User::whereName(Input::get('referal'))->exists()) {
				$usuario = User::whereName(Input::get('referal'))->first();
				$referencia = new AccountReferal();
				$referencia->account_id = Auth::user()->id;
				$referencia->referal_account_id = $usuario->id;
				$referencia->date = time();
				$referencia->save();
			}

			Helpers::registrarLog($dados = array(
				'subject' => 'Novo usuário cadastrado no sistema.',
				'text' => ('Um novo usuário foi registrado no sistema sua conta é '.Auth::user()->name.'.'),
				'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$configuracao = Configuracao::first();
			Session::flash('notificacoes', Lang::get('content.welcome to').' '.($configuracao) ? $configuracao->title : 'App Name'.'!');
			return Redirect::route('minha-conta');
		}else{
			return Redirect::route('tela-registrar-usuario')->withErrors(Lang::get('content.it was not possible to register your user profile').'!', 'usuario');
		}
	}

	public function getLogout()
	{
		$name = Lang::choice('content.player', 1);
		if(Auth::check()){
			$usuario = Auth::user();
			$name = ($usuario->nickname) ? $usuario->nickname : $usuario->name;
		}

		Session::flash('notificacoes', Lang::get('content.check back often').' '.$name.'.');
		if(Auth::check()){
			if(isset($_COOKIE['account'])){ setcookie("account", '', time()-1); }
			Auth::logout();
		}
		return Redirect::back()->withErrors((Lang::get('content.logged out successfully').'!'), 'usuario');
	}

	public function getDashboard()
	{
		$mundos = Helpers::arMundos();
		
		$usuarios = User::with('Player')->orderBy('created', 'desc')->take(5)->get();
		$players = Player::with('User')->orderBy('created', 'desc')->take(5)->get();

		$configuracoes = Configuracao::first();
		if(isset($configuracoes) && !empty($configuracoes->cost_points)){ $valor = $configuracoes->cost_points; } else { $valor = 1; }
		$mes = date_sub(date_create(date("Y-m-d H:i:s")), date_interval_create_from_date_string("1 month"))->getTimestamp();

		$transacoes['lista'] = ShopDonationHistory::with('PagseguroTransacao', 'MoipTransacao', 'PaypalTransacao')->where('date', '>=', $mes)
		->whereHas('PagseguroTransacao', function($pg){ $pg->where('status', '=', 3); })
		->orWhereHas('MoipTransacao', function($mp){ $mp->where('status', '=', 4); })
		->orWhereHas('PaypalTransacao', function($pp){ $pp->where('status', '=', 4); })
		->groupBy('transacaoID')->orderBy('shop_donation_history.id', 'desc')->get();

		$transacoes['transacoes'] = ShopDonationHistory::with('User', 'PagseguroTransacao', 'MoipTransacao', 'PaypalTransacao')->groupBy('TransacaoID')->orderBy('date', 'desc')->take(10)->get();
		$transacoes['quant'] = $transacoes['lista']->count();
		$transacoes['total'] = number_format(($transacoes['lista']->sum('points') * $valor), 2, ',', '.');
		unset($transacoes['lista']);

		return View::make('home.dashboard', compact('mundos', 'usuarios', 'players', 'transacoes'));
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}
