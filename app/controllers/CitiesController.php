<?php

class CitiesController extends \BaseController {

	public function getIndex()
	{
		$cidades = City::withTrashed('User', 'Player')->paginate(15);

		return View::make('cities.index', compact('cidades'));
	}

	public function getAdicionar()
	{
		return View::make('cities.create');
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), City::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'cidade')->withInput();
		}

		$cidade = new City($data);
		$cidade->account_id = Auth::user()->id;
		$cidade->save();

		Helpers::registrarLog($dados = array(
			'subject' => 'Nova Cidade.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu uma nova cidade, seu nome é '.$cidade->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/cidades');
	}

	public function getEditar($id = null)
	{
		$cidade = City::withTrashed('User', 'Player')->find($id);

		return View::make('cities.edit', compact('cidade'));
	}

	public function postEditar($id)
	{
		$cidade = City::withTrashed()->findOrFail($id);

		$rules = array(
			'name' => array('required','min:1','max:255'),
			'town_id' => array('required','min:0','numeric'),
			'posx' => array('required','min:0','numeric'),
			'posy' => array('required','min:0','numeric'),
			'posz' => array('required','min:0','numeric'),
			'account_id' => array('min:0','numeric')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'cidade')->withInput();
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Cidade.',
			'text' => ('Usuário '.Auth::user()->name.' editou informações da cidade '.$cidade->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$cidade->update($data);

		return Redirect::to('painel/cidades/editar/'.$id)->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id, $soft = "true")
	{
		$cidade = City::withTrashed('User', 'Player')->findOrFail($id);
		if($soft=="false"){
			Helpers::registrarLog($dados = array(
				'subject' => 'Remoção de Cidade.',
				'text' => ('Usuário '.Auth::user()->name.' deletou a cidade '.$cidade->name.'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$cidade->forceDelete();

			return Redirect::to('painel/cidades')->with('message', 'Deletado com sucesso!');
		}else{
			if($cidade->trashed()){
				$cidade->restore();

				Helpers::registrarLog($dados = array(
					'subject' => 'Ativação de Cidade.',
					'text' => ('Usuário '.Auth::user()->name.' ativou a cidade '.$cidade->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/cidades')->with('message', 'Ativado com sucesso!');
			}else{
				$cidade->delete();

				Helpers::registrarLog($dados = array(
					'subject' => 'Desativação de Cidade.',
					'text' => ('Usuário '.Auth::user()->name.' desativou a cidade '.$cidade->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/cidades')->with('message', 'Desativado com sucesso!');
			}
		}
	}
}
