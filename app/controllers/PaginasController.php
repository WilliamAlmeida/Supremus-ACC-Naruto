<?php

class PaginasController extends \BaseController {

	public function getIndex()
	{
		$paginas = Pagina::withTrashed()->paginate(15);

		return View::make('paginas.index', compact('paginas'));
	}

	public function getAdicionar()
	{
		return View::make('paginas.create');
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), Pagina::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'pagina')->withInput();
		}

		$pagina = new Pagina($data);
		$pagina->slug = Str::slug($pagina->title);
		$pagina->account_id = Auth::user()->id;
		$pagina->save();

		Helpers::registrarLog($dados = array(
			'subject' => 'Nova Página Institucional.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu uma nova página com titulo '.$pagina->title.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/paginas');
	}

	public function getEditar($id)
	{
		$pagina = Pagina::withTrashed()->find($id);

		return View::make('paginas.edit', compact('pagina'));
	}

	public function postEditar($id)
	{
		$pagina = Pagina::withTrashed()->findOrFail($id);

		$rules = array(
			'title' => array('required','min:4','max:255'),
			'body' => array('required','min:4'),
			'meta_title' => array('required','max:63'),
			'meta_description' => array('required','max:160'),
			'meta_keywords' => array('required','max:200')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'pagina')->withInput();
		}

		if (Input::has('gallery')===false) { $pagina->gallery = 0; }

		$data['slug'] = Str::slug($data['title']);

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Página Institucional.',
			'text' => ('Usuário '.Auth::user()->name.' editou informações da página '.$data["title"].'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$pagina->update($data);

		return Redirect::to('painel/paginas/editar/'.$id)->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id, $soft = "true")
	{
		$pagina = Pagina::withTrashed()->findOrFail($id);
		if($soft=="false"){
			$midiapagina = $pagina->midiapagina->lists('id');
			$pagina->midiapagina()->detach($midiapagina);

			$rates = $pagina->rate->lists('id');
			$pagina->rate()->detach($rates);

			Helpers::registrarLog($dados = array(
				'subject' => 'Remoção de Página Institucional.',
				'text' => ('Usuário '.Auth::user()->name.' deletou a página '.$pagina->title.'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$pagina->forceDelete();

			return Redirect::to('painel/paginas')->with('message', 'Deletado com sucesso!');
		}else{
			if($pagina->trashed()){
				$pagina->restore();

				Helpers::registrarLog($dados = array(
					'subject' => 'Ativação de Página Institucional.',
					'text' => ('Usuário '.Auth::user()->name.' ativou a página '.$pagina->title.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/paginas')->with('message', 'Ativado com sucesso!');
			}else{
				$pagina->delete();

				Helpers::registrarLog($dados = array(
					'subject' => 'Desativação de Página Institucional.',
					'text' => ('Usuário '.Auth::user()->name.' desativou a página '.$pagina->title.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/paginas')->with('message', 'Desativado com sucesso!');
			}
		}
	}

	public function getPagina($name = null){
		$pagina = Pagina::with('User', 'MidiaPagina')->where('slug', '=', $name)->first();

		if($pagina!=null){

			$capa = $pagina->midiapagina->filter(function($imagem)
			{
				if($imagem->capa){
					return true;
				}
			});

			$galeria = $pagina->midiapagina->filter(function($imagem)
			{
				if(!$imagem->capa){
					return true;
				}
			});

			Helpers::view($pagina->id, 'paginas');
		}else{
			$capa = null;
			$galeria = null;
		}

		return View::make('paginas.pagina', compact('pagina', 'capa', 'galeria'));
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}