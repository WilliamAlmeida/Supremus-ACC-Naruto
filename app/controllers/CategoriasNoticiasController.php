<?php

class CategoriasNoticiasController extends \BaseController {

	public function getIndex()
	{
		$sortBy = Request::get('sortBy');
		$direction = Request::get('direction');

		if($sortBy and $direction)
		{
			$categoriasnoticias = CategoriaNoticia::withTrashed('User')->orderBy($sortBy, $direction)->paginate(15);
		}else{
			$categoriasnoticias = CategoriaNoticia::withTrashed('User')->paginate(15);
		}

		return View::make('categorias_noticias.index', compact('categoriasnoticias'));
	}

	public function getAdicionar()
	{
		return View::make('categorias_noticias.create');
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), CategoriaNoticia::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'categoria')->withInput();
		}

		$categoria = new CategoriaNoticia($data);
		$categoria->slug = Str::slug($categoria->name);
		$categoria->account_id = Auth::user()->id;
		$categoria->save();

		Helpers::registrarLog($dados = array(
			'subject' => 'Nova Categoria de Notícia.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu uma nova categoria de notícia: '.$categoria->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/categorias-noticias');
	}

	public function getEditar($id)
	{
		$categoria = CategoriaNoticia::find($id);

		return View::make('categorias_noticias.edit', compact('categoria'));
	}

	public function postEditar($id)
	{
		$categoria = CategoriaNoticia::findOrFail($id);

		$rules = [
		'name' => array('required','min:2','max:50'),
		'meta_title' => array('required','max:63'),
		'meta_description' => array('required','max:160'),
		'meta_keywords' => array('required','max:200')
		];
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'categoria')->withInput();
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Categoria de Notícia.',
			'text' => ('Usuário '.Auth::user()->name.' editou informações da categoria '.$categoria->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$data['slug'] = Str::slug($data['name']);
		$categoria->update($data);

		return Redirect::to('painel/categorias-noticias')->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id, $soft = "true")
	{
		$categoria = CategoriaNoticia::withTrashed()->findOrFail($id);
		if($soft=="false"){
			$noticias = $categoria->noticia->lists('id');
			$categoria->noticia()->detach($noticias);

			Helpers::registrarLog($dados = array(
				'subject' => 'Remoção de Categoria de Notícia.',
				'text' => ('Usuário '.Auth::user()->name.' deletou a categoria '.$categoria->name.'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$categoria->forceDelete();

			return Redirect::to('painel/categorias-noticias')->with('message', 'Deletado com sucesso!');
		}else{
			if($categoria->trashed()){
				$categoria->restore();

				Helpers::registrarLog($dados = array(
					'subject' => 'Ativação de Categoria de Notícia.',
					'text' => ('Usuário '.Auth::user()->name.' ativou a categoria '.$categoria->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/categorias-noticias')->with('message', 'Ativado com sucesso!');
			}else{
				$categoria->delete();

				Helpers::registrarLog($dados = array(
					'subject' => 'Desativação de Categoria de Notícia.',
					'text' => ('Usuário '.Auth::user()->name.' desativou a categoria '.$categoria->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/categorias-noticias')->with('message', 'Desativado com sucesso!');
			}
		}
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}
}