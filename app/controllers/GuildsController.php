<?php

class GuildsController extends \BaseController {

	public function getGuildas(){
		$guilds = Guild::where('id', '>', 0);

		$data = Input::all();
		$filtro = array();

		if(isset($data['world_id']) && $data['world_id']>=0){
			$guilds->where('world_id', '=', $data['world_id']);
			$filtro = array_add($filtro, "world_id", $data['world_id']);
		}

		if(isset($data['ordem'])){
			if($data['ordem']==1){
				$guilds = $guilds->orderBy('price', 'asc');
			}
			if($data['ordem']==2){
				$guilds = $guilds->orderBy('beds', 'desc');
			}
		}else{
			$guilds = $guilds->orderBy('id', 'desc');
		}

		$guilds = $guilds->paginate(50);

		$mundos = Helpers::arMundos();

		return View::make('guilds.guildas', compact('guilds', 'mundos', 'filtro'));
	}

	public function getGuilda($id = null){
		$guild = Guild::FindorFail($id);

		$mundos = Helpers::arMundos();

		return View::make('guilds.guilda', compact('guild', 'mundos'));
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}
