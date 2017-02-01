<?php

class ConfiguracoesController extends \BaseController {

	public function getIndex()
	{
		$configuracoes = Configuracao::paginate(15);

		return View::make('configuracoes.index', compact('configuracoes'));
	}

	public function getAdicionar()
	{
		$configuracoes = Configuracao::all();
		if(!$configuracoes->isEmpty()){
			return Redirect::to('painel/configuracoes');
		}
		return View::make('configuracoes.create');
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), Configuracao::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'configuracao')->withInput();
		}

		$data['cost_points'] = str_replace(',', '.', $data['cost_points']);

		Configuracao::create($data);
		
		if (!empty($data['moip_email']) && !empty($data['moip_key']) && !empty($data['moip_token']))
		{
			$moip = Moip::first();
			$moip->receiver = $data['moip_email']; $moip->key = $data['moip_key']; $moip->token = $data['moip_token'];
			$moip->update();
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Nova Configração do Sistema.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu as configurações do sistema.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/configuracoes');
	}

	public function getEditar($id = null)
	{
		$configuracao = Configuracao::with('MidiaConfiguracao')->findOrFail($id);

		$moip = Moip::first();

		$background = $configuracao->midiaconfiguracao()->whereName('Background')->first();
		$banner = $configuracao->midiaconfiguracao()->whereName('Banner')->first();
		$favicon = $configuracao->midiaconfiguracao()->whereName('Favicon')->first();

		$contas = User::lists('name', 'id');

		return View::make('configuracoes.edit', compact('configuracao', 'moip', 'background', 'banner', 'favicon', 'contas'));
	}

	public function postEditar($id)
	{
		$configuracao = Configuracao::findOrFail($id);

		$rules = array(
			'title' => array('required','max:63'),
			'description' => array('required','max:160'),
			'keywords' => array('required','max:200'),
			'email' => array('required','min:4','max:255','email'),
			'facebook' => array('min:4','url'),
			'twitter' => array('min:4','url'),
			'founded' => array('min:9','max:11'),
			'level' => array('required','min:0','numeric'),
			'pagseguro_email' => array('min:0','max:255','email'),
			'pagseguro_token' => array('min:0','max:255'),
			'moip_email' => array('min:0','max:50','email'),
			'moip_key' => array('min:0','max:40'),
			'moip_token' => array('min:0','max:32'),
			'paypal_client_id' => array('min:0','max:255'),
			'paypal_secret' => array('min:0','max:255')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'configuracao')->withInput();
		}

		$data['cost_points'] = str_replace(',', '.', $data['cost_points']);

		Helpers::registrarLog($dados = array(
			'subject' => 'Configração do Sistema.',
			'text' => ('Usuário '.Auth::user()->name.' editou as configurações do sistema.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$moip = Moip::first();
		$moip->receiver = $data['moip_email']; $moip->key = $data['moip_key']; $moip->token = $data['moip_token'];
		$moip->update();

		$configuracao->update($data);

		return Redirect::to('painel/configuracoes')->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id = null)
	{
		Configuracao::destroy($id);

		Helpers::registrarLog($dados = array(
			'subject' => 'Remoção da Configração do Sistema.',
			'text' => ('Usuário '.Auth::user()->name.' deletou as configurações do sistema.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/configuracoes')->with('message', 'Deletado com sucesso!');
	}

	public function postResetar()
	{
		$data = Input::all();

		if($data['type']==1){
			if(!empty($data['contas'])){
				$usuario = User::with('Player', 'UserVipList')->findOrFail($data['contas']);
				$players = $usuario->player()->with('PlayerSkill', 'PlayerStorage', 'ShopHistory')->get();

				if(!$players->isEmpty()){
					foreach ($players as $personagem) {
						/*Removendo a Casa pertencente ao personagem*/
						if(!$personagem->houseauction()->get()->isEmpty()){
							$lista_houses = $personagem->houseauction()->lists('house_id');

							foreach ($lista_houses as $key => $house) {
								$info = array('owner' => 0, 'paid' => 0, 'warnings' => 0, 'lastwarning' => 0, 'clear' => 0);
								House::where('id', '=', $house)->update($info);
							}
							$personagem->houseauction()->delete();
						}

						/*Limpa histórico de compras na loja feitas por este personagem*/
						$personagem->shophistory()->delete();

						/*Removendo os itens do personagem*/
						$personagem->playerdepotitem()->delete();
						$personagem->playerstorage()->delete();
						$personagem->playeritem()->delete();

						/*Removendo as skills e spells do personagem*/
						$personagem->playerskill()->delete();
						$personagem->playerspell()->delete();

						/*Removendo todos report e bug informados pelo personagem*/
						$personagem->serverreport()->delete();
						$personagem->bugtracker()->delete();

						/*Limpando o registro de mortes relacionado ao personagem*/
						if(!$personagem->playerdeath()->get()->isEmpty()){
							$lista_death = $personagem->playerdeath()->lists('id');

							$lista_killer = array();
							foreach ($lista_death as $key => $death) {
								$lista_killer = array_add($lista_killer, $key, Killer::where('death_id', '=', $death)->first()->id);
								Killer::where('death_id', '=', $death)->delete();
							}

							foreach ($lista_killer as $key => $kill) {
								EnvironmentKiller::where('kill_id', '=', $kill)->delete();
								PlayerKiller::where('kill_id', '=', $kill)->delete();
							}
							$personagem->playerdeath()->delete();
						}

						/*Removendo a Guild do Personagem e Membros delas (Caso o Personagem seja o lider dela)*/
						if(!$personagem->guild()->get()->isEmpty()){
							$lista_guilds = $personagem->guild()->lists('id');

							foreach ($lista_guilds as $key => $guild) {

								$lista_membros = GuildInvite::where('guild_id', '=', $guild)->lists('player_id');

								foreach ($lista_membros as $key => $membro) {
									GuildInvite::where('player_id', '=', $membro)->where('guild_id', '=', $guild)->delete();
								}

								GuildRank::where('guild_id', '=', $guild)->delete();
								Guild::where('id', '=', $guild)->delete();
							}
						}

						/*Removendo o personagem da guild que pertence*/
						if(!$personagem->guildinvite()->get()->isEmpty()){
							GuildInvite::where('player_id', '=', $personagem->id)->delete();
						}

						$personagem->delete();
					}
				}
				/*return Redirect::back()->with('message', 'A conta "'.$usuario->name.'" não possuí nenhum personagem!');*/

				/*Limpa histórico de compras na loja feitas por esta conta*/
				ShopHistory::where('from', '=', $usuario->name)->delete();

				/*Devolve os Pontos gastos pelo usuário na loja do jogo*/
				if($data['recover']==1){
					$usuario->premium_points += $usuario->premium_points_lost;
					$usuario->premium_points_lost = 0;
					$usuario->save();
				}

				Helpers::registrarLog($dados = array(
					'subject' => 'Reset de Conta.',
					'text' => ('Usuário '.Auth::user()->name.' resetou a conta '.$usuario->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::back()->with('message', $usuario->name.' foi Resetado com sucesso!');
			}
		}else{
			if(!HouseAuction::all()->isEmpty()){
				foreach (HouseAuction::all() as $key => $houseauction) {
					$houseauction->delete();
				}
			}

			$lista_houses = House::where('owner', '=', 1)->get();
			if(!$lista_houses->isEmpty()){
				$info = array('owner' => 0, 'paid' => 0, 'warnings' => 0, 'lastwarning' => 0, 'clear' => 0);
				foreach ($lista_houses as $key => $house) {
					$house->update($info);
				}
			}

			ShopHistory::destroy(ShopHistory::lists('id'));

			if(!PlayerDepotitem::all()->isEmpty()){
				foreach (PlayerDepotitem::all() as $key => $playerdepotitem) {
					$playerdepotitem->delete();
				}
			}

			$lista_player_storage = PlayerStorage::lists('player_id');
			foreach ($lista_player_storage as $key => $player) {
				PlayerStorage::where('player_id', '=', $player)->delete();
			}

			$lista_player_item = PlayerItem::lists('player_id');
			foreach ($lista_player_item as $key => $player) {
				PlayerItem::where('player_id', '=', $player)->delete();
			}

			$lista_player_skill = PlayerSkill::lists('player_id');
			foreach ($lista_player_skill as $key => $player) {
				PlayerSkill::where('player_id', '=', $player)->delete();
			}

			$lista_player_spell = PlayerSpell::lists('player_id');
			foreach ($lista_player_spell as $key => $player) {
				PlayerSpell::where('player_id', '=', $player)->delete();
			}

			ServerReport::destroy(ServerReport::lists('id'));
			BugTracker::destroy(BugTracker::lists('id'));

			$lista_player_killer = PlayerKiller::lists('player_id');
			foreach ($lista_player_killer as $key => $player) {
				PlayerKiller::where('player_id', '=', $player)->delete();
			}

			$lista_player_killer = PlayerKiller::lists('player_id');
			foreach ($lista_player_killer as $key => $player) {
				PlayerKiller::where('player_id', '=', $player)->delete();
			}

			$lista_environment_killer = EnvironmentKiller::lists('kill_id');
			foreach ($lista_environment_killer as $key => $killer) {
				EnvironmentKiller::where('kill_id', '=', $killer)->delete();
			}

			Killer::destroy(Killer::lists('id'));
			PlayerDeath::destroy(PlayerDeath::lists('id'));

			if(!GuildInvite::all()->isEmpty()){
				foreach (GuildInvite::all() as $key => $guildinvite) {
					$guildinvite->delete();
				}
			}
			if(!GuildRank::all()->isEmpty()){
				foreach (GuildRank::all() as $key => $guildrank) {
					$guildrank->delete();
				}
			}
			Guild::destroy(Guild::lists('id'));

			Player::destroy(Player::lists('id'));

			if($data['recover']==1){
				$lista_usuarios = User::where('premium_points_lost', '>', 0)->get();

				if(!$lista_usuarios->isEmpty()){

					foreach ($lista_usuarios as $key => $usuario) {
						$info = array(
							'premium_points' => $usuario->premium_points += $usuario->premium_points_lost,
							'premium_points_lost' => 0
							);
						$usuario->update($info);
					}
				}
			}

			Helpers::registrarLog($dados = array(
				'subject' => 'Reset do Servidor.',
				'text' => ('Usuário '.Auth::user()->name.' resetou o servidor.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			return Redirect::back()->with('message', 'Servidor foi Resetado com sucesso!');
		}

		return Redirect::back();
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}