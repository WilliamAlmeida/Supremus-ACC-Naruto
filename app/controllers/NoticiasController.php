<?php

class NoticiasController extends BaseController {

	public function getHome()
	{
		$noticias = Noticia::with('User','CategoriaNoticia', 'Rate', 'MidiaNoticia')->orderBy('featured', 'desc')->get();

		$noticias_featured = $noticias->filter(function($noticia)
		{
			if($noticia->featured && isset($noticia->midianoticia->first()->capa)){
				return true;
			}
		});

		$noticias = $noticias->sortByDesc('id')->take(10);

		return View::make('noticias.home', compact('noticias', 'noticias_featured'));
	}

	public function getIndex()
	{
		$noticias = Noticia::withTrashed('User', 'CategoriaNoticia')->paginate(15);

		return View::make('noticias.index', compact('noticias'));
	}

	public function getAdicionar()
	{
		$categorias = CategoriaNoticia::with('User')->lists('name', 'id');

		return View::make('noticias.create', compact('categorias'));
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), Noticia::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'noticia')->withInput();
		}

		$noticia = new Noticia($data);
		$noticia->slug = Str::slug($noticia->title);
		$noticia->account_id = Auth::user()->id;
		$noticia->save();

		$categorias = Input::get('news_categories');
		$noticia->categorianoticia()->attach($categorias);

		Helpers::registrarLog($dados = array(
			'subject' => 'Nova Notícia.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu uma nova notícia com titulo '.$noticia->title.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/noticias');
	}

	public function getEditar($id = null)
	{
		$lista_categorias = CategoriaNoticia::with('User')->lists('name', 'id');
		$noticia = Noticia::withTrashed('CategoriaNoticia', 'User', 'Rate', 'MidiaNoticia')->find($id);
		$categorias = $noticia->categorianoticia->lists('id');

		return View::make('noticias.edit', compact('noticia', 'categorias', 'lista_categorias'));
	}

	public function postEditar($id)
	{
		$noticia = Noticia::withTrashed()->findOrFail($id);

		$rules = array(
			'title' => array('required','min:4','max:255'),
			'description' => array('required','min:4'),
			'tags' => array('max:200'),
			'meta_title' => array('required','max:63'),
			'meta_description' => array('required','max:160'),
			'meta_keywords' => array('required','max:200'),
			'news_categories' => array('required')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'noticia')->withInput();
		}

		if (Input::has('featured')===false) { $noticia->featured = 0; }
		if (Input::has('gallery')===false) { $noticia->gallery = 0; }

		$data['slug'] = Str::slug($data['title']);
		$noticia->update($data);

		$categorias = Input::get('news_categories');
		$noticia->categorianoticia()->sync($categorias);

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Notícia.',
			'text' => ('Usuário '.Auth::user()->name.' editou informações da notícia '.$data["title"].'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/noticias/editar/'.$id)->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id, $soft = "true")
	{
		$noticia = Noticia::withTrashed('CategoriaNoticia', 'User', 'MidiaNoticia', 'Rate')->findOrFail($id);
		if($soft=="false"){
			$categorianoticia = $noticia->categorianoticia()->lists('id');
			$midianoticia = $noticia->midianoticia->lists('id');
			$rates = $noticia->rate->lists('id');

			$noticia->rate()->detach($rates);
/*			foreach ($midianoticia as $key => $value) {
				MidiasController::getDeletar($value);
			}*/
			$noticia->midianoticia()->detach($midianoticia);
			$noticia->categorianoticia()->detach($categorianoticia);

			Helpers::registrarLog($dados = array(
				'subject' => 'Remoção de Notícia.',
				'text' => ('Usuário '.Auth::user()->name.' deletou a notícia '.$noticia->title.'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$noticia->forceDelete();

			return Redirect::to('painel/noticias')->with('message', 'Deletado com sucesso!');
		}else{
			if($noticia->trashed()){
				$noticia->restore();

				Helpers::registrarLog($dados = array(
					'subject' => 'Ativação de Notícia.',
					'text' => ('Usuário '.Auth::user()->name.' ativou a notícia '.$noticia->title.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/noticias')->with('message', 'Ativado com sucesso!');
			}else{
				$noticia->delete();

				Helpers::registrarLog($dados = array(
					'subject' => 'Desativação de Notícia.',
					'text' => ('Usuário '.Auth::user()->name.' desativou a notícia '.$noticia->title.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/noticias')->with('message', 'Desativado com sucesso!');
			}
		}
	}

	public function getNoticiaCategoria($name = null){
		$categoria = $name;
		$categoria_noticia = CategoriaNoticia::with('User', 'Noticia')->where('slug', '=', $name)->first();
		if(!empty($categoria_noticia)){
			$noticias = $categoria_noticia->noticia()->with('User', 'CategoriaNoticia', 'Rate', 'MidiaNoticia')->orderBy('id', 'desc')->paginate(15);
		}else{
			$noticias = null;
		}

		return View::make('noticias.noticias_categoria', compact('categoria_noticia','noticias','categoria'));
	}

	public function postNoticiaCategoria($name = null){
		$data = Input::all();

		if(!empty($data['price'])){
			$price = explode(',', $data['price']);
			$price_min = $price[0];
			$price_max = $price[1];
		}

		$categoria_noticia = CategoriaNoticia::with('User', 'Noticia')->where('slug', '=', $name)->first();
		$noticias = $categoria_noticia->noticia()->with('User', 'CategoriaNoticia', 'Rate', 'MidiaNoticia');

		if($data['date_start']!='' && $data['date_final']!=''){
			$noticias = $noticias->whereBetween('created_at', array($data['date_start'], $data['date_final']));
		}
		if(isset($data['featured']) && $data['featured']!=''){
			$noticias = $noticias->where('featured', '=', $data['featured']);
		}
		if($data['keywords']!=''){
			$noticias = $noticias->where('meta_keywords', 'like', '%'.$data['keywords'].'%');
		}

		$noticias = $noticias->orderBy('id', 'desc')->paginate(15);

		return View::make('noticias.noticias_categoria', compact('categoria_noticia','noticias'));
	}

	public function getNoticia($name = null){
		$noticia = Noticia::with('User', 'CategoriaNoticia', 'Rate', 'MidiaNoticia')->where('slug', '=', $name)->first();
		
		$capa = $noticia->midianoticia->filter(function($imagem)
		{
			if($imagem->capa){
				return true;
			}
		});

		$galeria = $noticia->midianoticia->filter(function($imagem)
		{
			if(!$imagem->capa){
				return true;
			}
		});
		
		if($noticia->rate->count()){
			$rate = $noticia->rate->sum('rate')/$noticia->rate->count();
		}else{
			$rate = null;
		}

		if(Auth::check()){
			$votou = $noticia->rate()->where('account_id', '=', Auth::user()->id)->get()->count();
		}else{
			$votou = 0;
		}

		Helpers::view($noticia->id, 'noticias');

		return View::make('noticias.noticia', compact('noticia', 'capa', 'galeria', 'votou'));
	}

	public function getNoticiaPesquisa($name = null){
		$pesquisa = $name;
		$noticias = Noticia::with('User', 'CategoriaNoticia', 'Rate', 'MidiaNoticia')->where('slug', 'like', '%'.$name.'%')->orderBy('id', 'desc')->paginate(15);

		return View::make('noticias.pesquisa', compact('noticias', 'pesquisa'));
	}

	public function getLauncher()
	{
		$noticias = Noticia::with('User', 'CategoriaNoticia', 'MidiaNoticia')->orderBy('featured', 'desc')->get();

		$noticias_featured = $noticias->filter(function($noticia)
		{
			if($noticia->featured && isset($noticia->midianoticia->first()->capa)){
				return true;
			}
		});

		$noticias = $noticias->sortByDesc('id')->take(3);

		return View::make('noticias.launcher', compact('noticias', 'noticias_featured'));
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}