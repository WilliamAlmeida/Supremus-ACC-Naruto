<?php

class PlayersController extends \BaseController {

	public function getRegister()
	{
		if(Auth::user()->player()->count()>=5)
		{
			return Redirect::route('minha-conta');
		}
		$cidades = City::lists('name', 'id');
		$mundos = Helpers::arMundos();

		$vocacoes = Helpers::arVocacoes();

		return View::make('players.register', compact('cidades', 'mundos', 'vocacoes'));
	}

	public function postRegister()
	{
		$validator = Validator::make($data = Input::all(), Player::$rules);

		if ($validator->fails())
		{
			return Redirect::route('tela-registrar-player')->withErrors($validator, 'player')->withInput();
		}

		$cidade = City::findOrFail($data['town_id']);
		$configuracao = Configuracao::first();

		$player = new Player($data);
		$player->name = trim($player->name);
		$player->group_id = Auth::user()->group_id;
		$player->account_id = Auth::user()->id;
		$player->town_id = $cidade->town_id;
		$player->posx = $cidade->posx;
		$player->posy = $cidade->posy;
		$player->posz = $cidade->posz;
		$player->level = $configuracao->level;
		$player->created = time();
		$resultado = $player->save();

		if($resultado){
			Helpers::registrarLog($dados = array(
				'subject' => 'Novo Personagem.',
				'text' => ('Usuário '.Auth::user()->name.' criou um novo personagem com nome '.$player->name.'.'),
				'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			Session::flash('notificacoes', Lang::get('content.character created successfully. lets play').'!');
			return Redirect::route('minha-conta');
		}else{
			return Redirect::route('tela-registrar-player')->withErrors(Lang::get('content.it was not possible to register your character').'!', 'player');
		}
	}

	public function getRanking(){
		$players = Player::with('User', 'PlayerSkill')->where('group_id', '<', '3');

		$data = Input::all();

		if(empty($data)){
			$players = $players->orderBy('level', 'desc');
		}

		if(isset($data['name']) && $data['name']!=''){
			$players = $players->where('name', 'like', '%'.$data['name'].'%');
		}
		if(isset($data['world_id']) && $data['world_id']>=0){
			$players->where('world_id', '=', $data['world_id']);
		}
		if(isset($data['town_id']) && $data['town_id']>0){
			$players->where('town_id', '=', $data['town_id']);
		}
		if(isset($data['vocation']) && $data['vocation']>0){
			$players->where('vocation', '=', $data['vocation']);
		}
		if(isset($data['sex']) && $data['sex']<2){
			$players->where('sex', '=', $data['sex']);
		}
		if(isset($data['status']) && $data['status']>=0){
			$players->where('online', '=', $data['status']);
		}

		if(isset($data['ordem'])){
			if($data['ordem']==1){
				$players = $players->orderBy('level', 'desc');
			}
		}

		$players = $players->get();

		if(isset($data['ordem'])){
			if($data['ordem']==8){
				$players = $players->sort(function($a, $b)
				{
					$a = $a->playerskill()->where('skillid', '=', 1)->first()->value;
					$b = $b->playerskill()->where('skillid', '=', 1)->first()->value;
					if ($a === $b) {
						return 0;
					}
					return ($a < $b) ? 1 : -1;
				});
			}
		}

		$players = $players->take(100);

		if(Auth::user()->group_id >= 5 || Auth::user()->player()->where('level', '>=', 25)->exists()){
			$privacy = 0;
		}else{
			$privacy = 1;
		}

		$cidades = City::lists('name', 'town_id');
		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$filtros = Helpers::arFiltroRanking();
		$status = Helpers::arFiltroStatus();

		return View::make('players.ranking', compact('players', 'cidades', 'mundos', 'vocacoes', 'status', 'filtros', 'privacy'));
	}

	public function getBusca(){
		$players = Player::with('User', 'PlayerSkill');
		
		$filtro = array();
		$data = Input::all();

		if(isset($data['name']) && $data['name']!=''){
			$players = $players->where('name', 'like', '%'.$data['name'].'%');
			$filtro = array_add($filtro, "name", $data['name']);
		}
		if(isset($data['world_id']) && $data['world_id']>=0){
			$players->where('world_id', '=', $data['world_id']);
			$filtro = array_add($filtro, "world_id", $data['world_id']);
		}
		if(isset($data['town_id']) && $data['town_id']>0){
			$players->where('town_id', '=', $data['town_id']);
			$filtro = array_add($filtro, "town_id", $data['town_id']);
		}
		if(isset($data['vocation']) && $data['vocation']>0){
			$players->where('vocation', '=', $data['vocation']);
			$filtro = array_add($filtro, "vocation", $data['vocation']);
		}
		if(isset($data['sex']) && $data['sex']<2){
			$players->where('sex', '=', $data['sex']);
			$filtro = array_add($filtro, "sex", $data['sex']);
		}
		if(isset($data['status']) && $data['status']>=0){
			$players->where('online', '=', $data['status']);
		}

		if(isset($data['ordem'])){
			if($data['ordem']==1){
				$players = $players->orderBy('level', 'desc');
				$filtro = array_add($filtro, "ordem", $data['ordem']);
			}
		}

		$players = $players->paginate(10);

		if(isset($data['ordem'])){
			if($data['ordem']==8){
				$filtro = array_add($filtro, "ordem", $data['ordem']);
				$players = $players->sort(function($a, $b)
				{
					$a = $a->playerskill()->where('skillid', '=', 1)->first()->value;
					$b = $b->playerskill()->where('skillid', '=', 1)->first()->value;
					if ($a === $b) {
						return 0;
					}
					return ($a < $b) ? 1 : -1;
				});
			}
		}

		if(Auth::user()->group_id >= 5 || Auth::user()->player()->where('level', '>=', 25)->exists()){
			$privacy = 0;
		}else{
			$privacy = 1;
		}

		$cidades = City::lists('name', 'town_id');
		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$filtros = Helpers::arFiltroRanking();
		$status = Helpers::arFiltroStatus();

		return View::make('players.busca', compact('players', 'cidades', 'mundos', 'vocacoes', 'filtros', 'status', 'filtro', 'privacy'));
	}

	public function getUltimasMortes(){
		$vitimas = PlayerDeath::with('Player')->orderBy('id', 'desc')->take(50)->get();

		$players = array();

		$filtro = array();
		$data = Input::all();

		foreach ($vitimas as $key => $vitima) {
			$assasinos = Killer::with('EnvironmentKiller', 'PlayerDeath')->where('death_id', '=', $vitima->id)->get();

			if(isset($data['name']) && $data['name']!=''||isset($data['killer']) && $data['killer']!=''||isset($data['world_id']) && $data['world_id']>=0){
				if(isset($data['name']) && $data['name']!='' && str_contains($vitima->player->name, $data['name'])){
					$players = array_add($players, $key, array(
						'player_id' => $vitima->player->id,
						'name' => $vitima->player->name,
						'date' => $vitima->date,
						'level' => $vitima->level,
						'world_id' => $vitima->player->world_id,
						'killer' => $assasinos->first()->environmentkiller->name,
						'online' => $vitima->player->online
						));
				}
				if(isset($data['killer']) && $data['killer']!='' && str_contains($assasinos->first()->environmentkiller->name, $data['killer'])){
					$players = array_add($players, $key, array(
						'player_id' => $vitima->player->id,
						'name' => $vitima->player->name,
						'date' => $vitima->date,
						'level' => $vitima->level,
						'world_id' => $vitima->player->world_id,
						'killer' => $assasinos->first()->environmentkiller->name,
						'online' => $vitima->player->online
						));
				}
				if(isset($data['world_id']) && $data['world_id']>=0 && $vitima->player->world_id == $data['world_id']){
					$players = array_add($players, $key, array(
						'player_id' => $vitima->player->id,
						'name' => $vitima->player->name,
						'date' => $vitima->date,
						'level' => $vitima->level,
						'world_id' => $vitima->player->world_id,
						'killer' => $assasinos->first()->environmentkiller->name,
						'online' => $vitima->player->online
						));
				}
			}else{
				$players = array_add($players, $key, array(
					'player_id' => $vitima->player->id,
					'name' => $vitima->player->name,
					'date' => $vitima->date,
					'level' => $vitima->level,
					'world_id' => $vitima->player->world_id,
					'killer' => $assasinos->first()->environmentkiller->name,
					'online' => $vitima->player->online
					));
			}
		}

		$cidades = City::lists('name', 'town_id');
		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$filtros = Helpers::arFiltroRanking();

		return View::make('players.ultimas_mortes', compact('players', 'cidades', 'mundos', 'vocacoes', 'filtros'));
	}

	public function getPersonagem($id = null){
		$player = Player::with('User', 'PlayerSkill', 'PlayerStorage')->FindorFail($id);

		if(Auth::user()->type == 5 || $player->user->id == Auth::user()->id){
			$privacy = 0;
		}else{
			$privacy = 1;
		}

		$mortes = PlayerDeath::with('Player')->where('player_id', '=', $player->id)->orderBy('id', 'desc')->take(10)->get();
		$lista_mortes = array();

		foreach ($mortes as $key => $vitima) {
			$assasinos = Killer::with('EnvironmentKiller', 'PlayerDeath')->where('death_id', '=', $vitima->id)->get();

			$lista_mortes = array_add($lista_mortes, $key, array(
				'player_id' => $vitima->player->id,
				'name' => $vitima->player->name,
				'date' => $vitima->date,
				'level' => $vitima->level,
				'world_id' => $vitima->player->world_id,
				'killer' => $assasinos->first()->environmentkiller->name
				));
		}

		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$grupos = Helpers::arGrupo();
		$insignias = Helpers::arInsignias();
		$quests = Helpers::arQuests();

		return View::make('players.personagem', compact('player', 'mundos', 'vocacoes', 'grupos', 'lista_mortes', 'insignias', 'quests', 'privacy'));
	}

	public function getOnline(){
		$players = Player::with('User', 'PlayerSkill')->where('online', '=', 1);

		$data = Input::all();

		if(isset($data['world_id']) && $data['world_id']>=0){
			$players->where('world_id', '=', $data['world_id']);
		}
		if(isset($data['town_id']) && $data['town_id']>0){
			$players->where('town_id', '=', $data['town_id']);
		}
		if(isset($data['vocation']) && $data['vocation']>0){
			$players->where('vocation', '=', $data['vocation']);
		}
		if(isset($data['sex']) && $data['sex']<2){
			$players->where('sex', '=', $data['sex']);
		}

		if(isset($data['ordem'])){
			if($data['ordem']==1){
				$players = $players->orderBy('level', 'desc');
			}
		}

		$players = $players->get();

		if(isset($data['ordem'])){
			if($data['ordem']==8){
				$players = $players->sort(function($a, $b)
				{
					$a = $a->playerskill()->where('skillid', '=', 1)->first()->value;
					$b = $b->playerskill()->where('skillid', '=', 1)->first()->value;
					if ($a === $b) {
						return 0;
					}
					return ($a < $b) ? 1 : -1;
				});
			}
		}

		$players = $players->take(100);

		$cidades = City::lists('name', 'town_id');
		$mundos = Helpers::arMundos();
		$vocacoes = Helpers::arVocacoes();
		$filtros = Helpers::arFiltroOnline();

		return View::make('players.online', compact('players', 'cidades', 'mundos', 'vocacoes', 'filtros'));
	}

	public function getDesbugar($id = null){
		$player = Player::with('User')->findOrFail($id);

		if($player->user->id != Auth::user()->id){
			return Redirect::route('minha-conta')->with('message', Lang::get('content.you can only use\'s function in your characters').'!');
		}
		if($player->online == 1){
			return Redirect::route('minha-conta')->with('message', Lang::get('content.to use the function fix your character needs to be offline').'!');
		}
		if(time() < $player->debug){
			return Redirect::route('minha-conta')->with('message', Lang::get('content.this function can only be used once every hours', ['hour' => 6]).'!');
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Debugação de Personagem.',
			'text' => ('Usuário '.Auth::user()->name.', desbugou seu personagem '.$player->name.'.'),
			'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => $player->id));

		$data = array('posx' => 0, 'posy' => 0, 'posz' => 0, 'debug' => (time() + (6 * 60 * 60)));
		$player->update($data);

		return Redirect::to('conta')->with('message', Lang::get('content.ready! his character was sent to his hometown, try login if error remains, contact the team').'.');
	}

	public function getIndex()
	{
		$players = Player::paginate(50);

		$mundos = Helpers::arMundos();

		return View::make('players.index', compact('players', 'mundos'));
	}

	public function getEditar($id = null)
	{
		$player = Player::findOrFail($id);

		$cidades = City::lists('name', 'town_id');
		$mundos = Helpers::arMundos();
		$grupos = Helpers::arGrupo();

		return View::make('players.edit', compact('player', 'cidades', 'mundos', 'grupos'));
	}

	public function postEditar($id)
	{
		$player = Player::with('User')->findOrFail($id);

		$data = Input::all();
		if(!empty(Input::has('name'))) { $data = array_add($data, 'name', trim(Input::get('newName'))); }

		$rules = array(
			'name' => array('unique:players','min:4','max:255')
			);
		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'player')->withInput();
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Personagem.',
			'text' => ('Usuário '.Auth::user()->name.' editou o personagem '.$player->name.' do usuário '.$player->user->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$player->update($data);

		return Redirect::to('painel/personagens')->with('message', 'Atualização realizada com sucesso!');
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}
}