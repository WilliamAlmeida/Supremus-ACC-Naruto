<?php

class HousesController extends \BaseController {

	public function getCasas(){
		$houses = House::with('Player', 'City')->where('id', '>', 0);

		$data = Input::all();
		$filtro = array();

		if(isset($data['world_id']) && $data['world_id']>=0){
			$houses->where('world_id', '=', $data['world_id']);
			$filtro = array_add($filtro, "world_id", $data['world_id']);
		}
		if(isset($data['town_id']) && $data['town_id']>0){
			$houses->where('town', '=', $data['town_id']);
			$filtro = array_add($filtro, "town_id", $data['town_id']);
		}

		if(isset($data['ordem'])){
			if($data['ordem']==1){
				$houses = $houses->orderBy('price', 'asc');
			}
			if($data['ordem']==2){
				$houses = $houses->orderBy('beds', 'desc');
			}
		}else{
			$houses = $houses->orderBy('id', 'desc');
		}

		$houses = $houses->paginate(50);

		$mundos = Helpers::arMundos();
		$cidades = City::lists('name', 'town_id');
		$filtros = Helpers::arFiltroImoveis();

		return View::make('houses.casas', compact('houses', 'mundos', 'cidades', 'filtros', 'filtro'));
	}

	public function getCasa($id = null){
		$house = House::with('Player', 'City')->FindorFail($id);

		$mundos = Helpers::arMundos();

		return View::make('houses.casa', compact('house', 'mundos'));
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}
