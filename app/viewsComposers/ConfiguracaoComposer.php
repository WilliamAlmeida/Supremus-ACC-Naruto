<?php

class ConfiguracaoComposer {

	public function compose($view)
	{
		$configuracoes = Configuracao::with('MidiaConfiguracao')->first();

		if(!empty($configuracoes)){
			$background = $configuracoes->midiaconfiguracao()->whereName('Background')->first();
			$background = ($background) ? $background->path : null;
			$banner = $configuracoes->midiaconfiguracao()->whereName('Banner')->first();
			$favicon = $configuracoes->midiaconfiguracao()->whereName('Favicon')->first();
		}else{
			$configuracoes = new configuracao();
			$background = null;
			$banner = null;
			$favicon = null;
		}

		if(Auth::check()){
			if(Auth::user()->group_id >= 5 || Auth::user()->player()->where('level', '>=', 25)->exists()){
				$privacy_level = 0;
			}else{
				$privacy_level = 1;
			}
		}else{
			$privacy_level = 1;
		}

		$view->with(compact('configuracoes','background','banner','favicon', 'privacy_level'));
	}

	public function painelTS($view)
	{
		$informacoes['jogadores-online'] = Player::with('User')->whereOnline(1)->get()->count();
		$informacoes['jogadores-registrados'] = User::with('Player')->get()->count();

		$servidores = array();	
		foreach (Helpers::arMundos() as $key => $value) {
			$servidores = array_add($servidores, $key, array(
				'online' => Player::with('User')->where('world_id', '=', $key)->whereOnline(1)->get()->count(),
				'record' => ServerRecord::where('world_id', '=', $key)->get()->max('record')
				));
		}

		$mundos = Helpers::arMundos();

		$top_level = Player::with('User', 'PlayerSkill')->where('group_id', '<', '3')->orderBy('level', 'desc')->get()->take(5);

		$view->with(compact('informacoes','servidores','mundos','top_level'));
	}
}