<?php

class UsersController extends BaseController {

	public function getHome(){
		$usuario = User::with('Player', 'AccountPrivacy', 'AccountVipList', 'AccountReferal')->findOrfail(Auth::user()->id);

		$awards = Helpers::verificarReferencias($usuario->id);

		$history = ShopHistory::with('Player', 'ShopOffer');
		
		$history = $history->where('from', '=', $usuario->name);

		if(!$usuario->player()->get()->isEmpty()){
			foreach ($usuario->player() as $key => $player) {
				if($key){
					$history = $history->where('from', '=', $player->name);
				}else{
					$history = $history->orWhere('name', '=', $player->name);
				}
			}
		}
		
		$history = $history->orderBy('date', 'desc')->take(10)->get();

		$donations = ShopDonationHistory::with('User', 'PagseguroTransacao', 'MoipTransacao', 'PaypalTransacao')->whereAccount($usuario->id)->take(10)->orderBy('date','desc')->get();
		
		$status = array(
			'PagSeguro' => Pagseguro::arStatusTransacao(),
			'Moip' => MoipHelper::arStatusTransacao(),
			'Paypal' => PaypalHelper::arStatusTransacao()
			);

		if(empty($usuario->nickname)){
			Session::flash('notificacoes', Lang::get('content.update your nickname, please').'!');
		}elseif(empty($usuario->email)){
			Session::flash('notificacoes', Lang::get('content.update your email, please').'!');
		}

		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$avatares = array_fetch(Helpers::arAvatares(), 'name');

		return View::make('usuarios.home', compact('usuario', 'mundos', 'vocacoes', 'avatares', 'donations', 'status', 'history', 'awards'));
	}

	public function getSenha()
	{
		return View::make('usuarios.senha');
	}

	public function postSenha()
	{
		$rules = array(
			'password' => array('required','min:6','max:20','alpha_dash')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('tela-alterar-senha')->withErrors($validator, 'usuario')->withInput();
		}

		$usuario = User::findOrFail(Auth::user()->id);
		$senha = $data['password'];
		$usuario->password = sha1($senha);
		$resultado = $usuario->save();

		if($resultado){
			$mensagem = '
			Ola '.($usuario->nickname) ? $usuario->nickname : $usuario->name.'<,br/>
			Foi realizado uma troca de senha na conta <strong>'.$usuario->name.'</strong>, agora sua senha é <strong>'.$senha.'</strong>, recomendamos que nunca passe ela a ninguem.
			';
			$dados = array(
				'to' => $usuario->email, 'toName' => ($usuario->nickname) ? $usuario->nickname : $usuario->name,
				'subject' => 'Troca de Senha',
				'mensagem' => $mensagem
				);
			Helpers::emailNotificacao($dados);

			Helpers::registrarLog($dados = array(
				'subject' => 'Troca de Senha.',
				'text' => ('Usuário '.$usuario->name.' efetuou uma troca de senha em sua conta.'),
				'type' => 2, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));

			Session::flash('notificacoes', 'Senha alterada com sucesso!');
			Auth::login($usuario);
			return Redirect::route('minha-conta');
		}else{
			return Redirect::route('tela-alterar-senha')->withErrors(Lang::get('content.cannot change for your account', ['attribute' => Lang::get('content.password')]).'!', 'usuario');
		}
	}

	public function getEmail()
	{
		return View::make('usuarios.email');
	}

	public function postEmail()
	{
		$rules = array(
			'email' => array('unique:accounts','required','min:6','max:255','email')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('tela-alterar-email')->withErrors($validator, 'usuario')->withInput();
		}

		$usuario = User::findOrFail(Auth::user()->id);

		Helpers::registrarLog($dados = array(
			'subject' => 'Troca de E-mail.',
			'text' => ('Usuário '.$usuario->name.' efetuou a troca do e-mail, de '.$usuario->email.' para '.$data["email"].'.'),
			'type' => 2, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));

		$usuario->email = $data['email'];
		$resultado = $usuario->save();

		if($resultado){
			Session::flash('notificacoes', Lang::get('content.changed successfully', ['attribute' => Lang::get('content.email')]).'!');
			Auth::login($usuario);
			return Redirect::route('minha-conta');
		}else{
			return Redirect::route('tela-alterar-email')->withErrors(Lang::get('content.cannot change for your account', ['attribute' => Lang::get('content.email')]).'!', 'usuario');
		}
	}

	public function getNickname()
	{
		if(!empty(Auth::user()->nickname)){
			return Redirect::route('minha-conta');
		}
		return View::make('usuarios.nickname');
	}

	public function postNickname()
	{
		$rules = array(
			'nickname' => array('unique:accounts','required','min:3','max:48')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('tela-alterar-nickname')->withErrors($validator, 'usuario')->withInput();
		}

		$usuario = User::findOrFail(Auth::user()->id);

		Helpers::registrarLog($dados = array(
			'subject' => 'Troca de Nickname.',
			'text' => ('Usuário '.$usuario->name.' efetuou a troca do nickname, de '.(($usuario->nickname) ? $usuario->nickname : 'Nulo' ).' para '.trim($data['nickname']).'.'),
			'type' => 2, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));

		$usuario->nickname = trim($data['nickname']);
		$resultado = $usuario->save();

		if($resultado){
			Session::flash('notificacoes', Lang::get('content.changed successfully', ['attribute' => Lang::get('content.nickname')]).'!');
			Auth::login($usuario);
			return Redirect::route('minha-conta');
		}else{
			return Redirect::route('tela-alterar-nickname')->withErrors(Lang::get('content.cannot change for your account', ['attribute' => Lang::get('content.nickname')]).'!', 'usuario');
		}
	}

	public function postAvatar(){
		$rules = array('avatares' => array('required','min:0','max:255','numeric'));
		$validator = Validator::make($data = Input::all(), $rules);
		if ($validator->fails())
		{
			$response = array('status' => 'erro', 'msg' => 'Avatar informado não existe!');
			return Response::json($response);
		}

		$usuario = User::findOrFail(Auth::user()->id);

		if(empty($usuario->avatar)){
			$avatares = Helpers::arAvatares();
			$usuario->update(['avatar' => $avatares[$data['avatares']]['img']]);

			Helpers::registrarLog($dados = array(
				'subject' => 'Seleção do Avatar.',
				'text' => ('Usuário '.Auth::user()->name.' selecionou o avatar '.$avatares[$data['avatares']]['name'].'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));
			
			$response = array('status' => 'sucesso', 'msg' => Lang::get('content.changed successfully', ['attribute' => Lang::choice('content.avatar', 1)]).'!');
		}else{
			$response = array('status' => 'erro', 'msg' => Lang::get('content.you already possess an avatar selected').'!');
		}

		return Response::json($response);
	}

	public function postPrivacy(){
		$validator = Validator::make($data = Input::all(), AccountPrivacy::$rules);
		if ($validator->fails())
		{
			return Redirect::route('minha-conta')->with('privacy', Lang::get('content.configure properly your privacy').'!');
		}

		$usuario = User::with('AccountPrivacy')->findOrFail(Auth::user()->id);
		if($usuario->accountprivacy()->exists()){
			unset($data['_token']);
			$resultado = AccountPrivacy::where('account_id', '=', $usuario->id)->update($data);
		}else{
			$privacy = new AccountPrivacy($data);
			$privacy->account_id = $usuario->id;
			$resultado = $privacy->save();
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Configuração de Privacidade.',
			'text' => ('Usuário '.Auth::user()->name.' configurou sua própria privacidade.'),
			'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		Session::flash('notificacoes', Lang::get('content.privacy configured successfully').'!');

		return Redirect::route('minha-conta');
	}

	public function postRecoveryKey(){
		$usuario = User::findOrFail(Auth::user()->id);
		if($usuario->key!=""){
			$response = array('status' => 'erro', 'msg' => Lang::get('content.recovery Key has been generated').'!');
		}else{
			$key = str_random(15);
			$usuario->update(['key' => $key]);
			$response = array('status' => 'sucesso', 'msg' => Lang::get('content.recovery Key successfully generated and sent to your email').'!', 'key' => $key);

			$mensagem = Lang::get('content.hi, your recovery key is, we recommend never pass anyone. obs: your username is', ['name' => (($usuario->nickname) ? $usuario->nickname : $usuario->name), 'key' => $key, 'account' => $usuario->name]);

			$dados = array(
				'to' => $usuario->email, 'toName' => ($usuario->nickname) ? $usuario->nickname : $usuario->name,
				'subject' => Lang::get('content.account recovery key'),
				'mensagem' => $mensagem
				);
			Helpers::emailNotificacao($dados);

			Helpers::registrarLog($dados = array(
				'subject' => 'Chave de Recuperação.',
				'text' => ('Usuário '.$usuario->name.' solicitou a criação da chave de recuperação.'),
				'type' => 3, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));
		}

		return Response::json($response);
	}

	public function getConta($id = null){
		$usuario = User::with('Player', 'AccountPrivacy')->findOrFail($id);

		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$grupos = Helpers::arGrupo();
		$avatares = array_fetch(Helpers::arAvatares(), 'name');

		$privacy = $usuario->accountprivacy;
		if($privacy){
			$privacy = $privacy->email;
		}
		if(Auth::user()->type == 5 || $usuario->id == Auth::user()->id){
			$privacy = 0;
		}

		return View::make('usuarios.conta', compact('usuario', 'mundos', 'vocacoes', 'avatares', 'grupos', 'privacy'));
	}

	public function getRecuperarConta()
	{
		return View::make('usuarios.recuperar_conta');
	}

	public function postRecuperarConta()
	{
		$rules = array('email' => array('required','min:6','max:255','email'));
		if(Input::has('type') && Input::get('type')=="key"){
			$rules = array_add($rules, 'key', array('required','min:5','max:255'));
			$rules = array_add($rules, 'password', array('required','min:6','max:20','alpha_dash'));
		}

		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('tela-recuperar-conta')->withErrors($validator, 'recuperacao')->withInput();
		}

		if(Input::has('type') && Input::get('type')=="key"){
			$usuario = User::whereEmail($data['email'])->whereKey($data['key'])->first();
			if(!isset($usuario)){
				return Redirect::route('tela-recuperar-conta')->withErrors(Lang::get('content.email and/or recover key is incorrect').'!', 'recuperacao');
			}
			$senha = $data['senha'];
			$usuario->password = sha1($senha);
			$resultado = $usuario->save();
		}else{
			$usuario = User::whereEmail($data['email'])->first();
			if(!isset($usuario)){
				return Redirect::route('tela-recuperar-conta')->withErrors(Lang::get('content.email is not registered in the game').'!', 'recuperacao');
			}
			$senha = str_random(10);
			$usuario->password = sha1($senha);
			$resultado = $usuario->save();
		}

		if(Isset($resultado) && $resultado){
			$mensagem = Lang::get('content.hi, your password is, we recommend that you never pass anyone. note: your username is', ['name' => (($usuario->nickname) ? $usuario->nickname : $usuario->name), 'password' => $senha, 'account' => $usuario->name]);

			$dados = array(
				'to' => $usuario->email, 'toName' => ($usuario->nickname) ? $usuario->nickname : $usuario->name,
				'subject' => Lang::get('content.account recovery'),
				'mensagem' => $mensagem
				);
			Helpers::emailNotificacao($dados);

			Helpers::registrarLog($dados = array(
				'subject' => 'Recuperação de Conta.',
				'text' => ('Usuário '.$usuario->name.' solicitou a recuperação de sua conta.'),
				'type' => 2, 'ip' => null, 'account_id' => $usuario->id, 'player_id' => null));

			Session::flash('notificacoes', Lang::get('content.account retrieved successfully').'!');
			if(Input::has('type') && Input::get('type')=="key"){
				Auth::login($usuario);
				return Redirect::route('home');
			}
			return Redirect::route('tela-recuperar-conta')->withErrors(Lang::get('content.successfully recovered account, check your email box').'!', 'recuperacao');
		}else{
			return Redirect::route('tela-recuperar-conta')->withErrors(Lang::get('content.it was not possible to recover your account').'!', 'recuperacao');
		}
	}

	public function getIndex()
	{
		$usuarios = User::orderBy('group_id', 'desc')->orderBy('created', 'desc')->paginate(50);
		$grupos = Helpers::arGrupo();

		return View::make('usuarios.index', compact('usuarios', 'grupos'));
	}

	public function getEditar($id = null)
	{
		$usuario = User::findOrFail($id);

		$grupos = Helpers::arGrupo();

		return View::make('usuarios.edit', compact('usuario', 'grupos'));
	}

	public function postEditar($id)
	{
		$usuario = User::with('Player')->findOrFail($id);

		$rules = array(
			'newPassword' => array('min:6','max:20','alpha_dash')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'usuario')->withInput();
		}

		$usuario = User::find($id);
		if (!empty(Input::has('newPassword'))) { $usuario->password = sha1(Input::get('newPassword')); }
		if($usuario->player()->count() > 0 && $usuario->group_id < $data['group_id']){
			foreach ($usuario->player()->get() as $personagem) {
				$personagem->update(['group_id' => $data['group_id']]);
			}
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Usuário.',
			'text' => ('Usuário '.Auth::user()->name.' editou o usuário '.$usuario->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$usuario->update($data);

		return Redirect::to('painel/usuarios')->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id = null)
	{
		$usuario = User::findOrfail($id);

		Helpers::registrarLog($dados = array(
			'subject' => 'Remoção de Usuário.',
			'text' => ('Usuário '.Auth::user()->name.' deletou a conta '.$usuario->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		User::destroy($id);

		return Redirect::to('painel/usuarios')->with('message', 'Deletado com sucesso!');
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}
