<?php

class MidiasController extends \BaseController {

	public function getIndex()
	{
		$midias = Midia::paginate(15);

		return View::make('midias.index', compact('midias'));
	}

	public function getAdicionar()
	{
		/*$data['imagem'] = (Session::get('imagem')) ? Session::get('imagem') : 'false'; 
		$data['modal'] = (Session::get('modal') != null) ? 'true' : 'false';*/

		return View::make('midias.create');
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), Midia::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'midias')->withInput();
		}

		$imagens = $data['path'];

		foreach ($imagens as $key => $imagem) {
			$momento = date_format(date_create(), 'h-i-s-d-m-Y');
			$nome = Str::slug($data['name']).'-'.$momento.'-original.'.$imagem->getClientOriginalExtension();

			(str_contains(Request::getHttpHost(), 'localhost')) ? $complemento = "public/" : $complemento = "";

			$imagem->move($complemento.'assets/uploads/'.$data['type'], $nome);
			$caminho = $complemento.'assets/uploads/'.$data['type'].'/'.$nome;
			$int_image = Image::make($caminho)->encode('jpg', 75);

			if($data['type'] == "noticias"){
				$int_image->fit(750, 300, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); }, 'top-left');
			}elseif($data['type'] == "paginas"){
				$int_image->fit(750, 300, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); }, 'top-left');
			}elseif($data['type'] == "itens"){
				$int_image->fit(64, 64, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); }, 'top-left');
			}elseif($data['type'] == "configuracoes"){
				if($data['name']=="Banner"){
					$int_image->fit(1024, 300, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); }, 'top-left');
				}elseif($data['name']=="Favicon"){
					$int_image->fit(310, 310, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); }, 'top-left');
				}
			}
			if($data['name']!="Background"){
				$int_image->save(str_replace('-original', '-banner', $caminho));
			}

			if($data['type'] == "noticias"){
				$int_image->fit(750, 150, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); });
			}elseif($data['type'] == "paginas"){
				$int_image->fit(750, 150, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); });
			}elseif($data['type'] == "itens"){
				$int_image->fit(32, 32, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); });
			}elseif($data['type'] == "configuracoes"){
				if($data['name']=="Banner"){
					$int_image->fit(750, 150, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); });
				}elseif($data['name']=="Favicon"){
					$int_image->fit(32, 32, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); });
				}elseif($data['name']=="Background"){
					$int_image->fit(500, 300, function($constraint){ $constraint->aspectRatio(); $constraint->upsize(); });
				}
			}

			$int_image->save(str_replace('-original', '-thumbnail', $caminho));

			$data['path'] = str_replace('public/', '', $caminho);
			$data['name'] = $data['name'];

			$midia = Midia::create($data);

			if($data['type'] == "noticias"){
				$midia->noticia()->attach($data['id']);
			}elseif($data['type'] == "paginas"){
				$midia->pagina()->attach($data['id']);
			}elseif($data['type'] == "itens"){
				$midia->shopoffer()->attach($data['id']);
			}elseif($data['type'] == "configuracoes"){
				$midia->configuracao()->attach($data['id']);
			}
		}

		/*Session::put('imagem', 'assets/uploads/'.$imagem->getClientOriginalName()); Session::put('modal', 'true');*/

		return Redirect::back();
		//return Redirect::to('midias');
	}

	public function getEditar($id)
	{
		$midia = Midia::find($id);

		return View::make('midias.edit', compact('midia'));
	}

	public function postEditar($id)
	{
		$midia = Midia::findOrFail($id);

		$rules = [
		'name' => array('required','min:1','max:255')
		];
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'midias')->withInput();
		}

		$midia->update($data);

		return Redirect::back();
	}

	public function getDeletar($id)
	{
		$midia = Midia::with('Pagina', 'Noticia', 'ShopOffer', 'Configuracao')->findOrFail($id);

		if(File::exists(public_path($midia->path))){
			File::delete(public_path($midia->path));

			File::delete(public_path(str_replace('-original', '-banner', $midia->path)));

			File::delete(public_path(str_replace('-original', '-thumbnail', $midia->path)));
		}

		$midia->pagina()->detach($midia->pagina->lists('id'));
		$midia->noticia()->detach($midia->noticia->lists('id'));
		$midia->shopoffer()->detach($midia->shopoffer->lists('id'));
		$midia->configuracao()->detach($midia->configuracao->lists('id'));

		Midia::destroy($id);

		return Redirect::back()->with('message', 'Deletado com sucesso!');
	}

	public function getCapa($id, $item_id)
	{
		$midia = Midia::with('Pagina', 'Noticia', 'ShopOffer', 'Configuracao')->findOrFail($id);
		$midia->capa = 1;
		$midia->update($midia->toArray());

		if($midia->type=="paginas"){
			$pagina = Pagina::with('MidiaPagina')->findOrFail($item_id);
			$midias = $pagina->midiapagina()->where('id', '!=', $id)->update(array('capa' => 0));
		}elseif($midia->type=="noticias"){
			$noticia = Noticia::with('MidiaNoticia')->findOrFail($item_id);
			$midias = $noticia->midianoticia()->where('id', '!=', $id)->update(array('capa' => 0));
		}elseif($midia->type=="itens"){
			$shopoffer = ShopOffer::with('MidiaShopOffer')->findOrFail($item_id);
			$midias = $shopoffer->midiashopoffer()->where('id', '!=', $id)->update(array('capa' => 0));
		}elseif($midia->type=="configuracoes"){
			$configuracao = Pagina::with('MidiaConfiguracao')->findOrFail($item_id);
			$midias = $configuracao->midiaconfiguracao()->where('id', '!=', $id)->update(array('capa' => 0));
		}

		return Redirect::back()->with('message', 'Imagem alterada com sucesso!');
	}

	public function postCropImage()
	{
		Session::forget('modal');

		$img = 'public/'.Session::get('imagem');

		$int_image = Image::make($img);

		$int_image->crop(intval(Input::get('w')), intval(Input::get('h')), intval(Input::get('x')), intval(Input::get('y')) );

		$int_image->fit(300);

		$int_image->save($img);

		return Redirect::back();
	}

	public function missingMethod($parameters = array())
	{
		return "Nada encontrado!";
	}

}
