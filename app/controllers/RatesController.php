<?php

class RatesController extends \BaseController {


	public function getIndex()
	{
		$rates = Rate::paginate(15);

		return View::make('rates.index', compact('rates'));
	}

	public function getAdicionar()
	{
		return View::make('rates.create');
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), Rate::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'rate')->withInput();
		}

		$rate = new Rate($data);
		$rate->slug = Str::slug($rate->title);
		$rate->account_id = Auth::user()->id;
		$rate->save();

		return Redirect::to('rates');
	}

	public function getEditar($id = null)
	{
		return View::make('rates.edit');
	}

	public function postEditar($id)
	{
		$rate = Rate::findOrFail($id);

		$rules = array(
			'rate' => array('required','min:1','max:5','numeric')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'rate')->withInput();
		}

		$rate->update($data);

		return Redirect::to('rates')->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id = null)
	{
		$rate = Rate::findOrFail($id);

		$noticias = $rate->noticia->lists('id');
		$rate->noticia()->detach($noticias);

		$produtos = $rate->produto->lists('id');
		$rate->produto()->detach($produtos);

		$paginas = $rate->pagina->lists('id');
		$rate->pagina()->detach($paginas);

		Rate::destroy($id);

		return Redirect::to('rates')->with('message', 'Deletado com sucesso!');
	}

	public function getRate($pontuacao = null, $usuario = null, $id = null, $tipo = null){
		if(!is_null($pontuacao) && !is_null($usuario) && !is_null($id) && !is_null($tipo)){
			if($tipo==="noticias"){
				$noticia = Noticia::with('Rate')->findOrFail($id);
				$usuario = User::with('Rate')->findOrFail(Auth::user()->id);
				$rate = $noticia->rate()->where('account_id', '=', $usuario->id)->get();

				if($pontuacao>0){
					$validator = Validator::make($data = array('rate' => $pontuacao), Rate::$rules);
					if ($validator->fails()) { return 0; }

					if($rate->count()){
						$rate->first()->update(['rate' => $pontuacao]);
					}else{
						$rate = new Rate($data);
						$rate->account_id = $usuario->id;
						$rate->save();

						$rate->noticia()->attach($noticia->id);
					}
				}else{
					if($rate->count()){
						$rate->first()->noticia()->detach($noticia->id);
						$rate->first()->delete();
					}
				}

				if($noticia->rate->count()){ $score = $noticia->rate->sum('rate')/$noticia->rate->count(); $total = $noticia->rate->count(); }else{ $score = 0; $total = 0; }
				$retorno = array('score' => $score, 'total' => $total);
				return $retorno;

			}elseif($tipo==="produtos"){
				$produto = Produto::with('Rate')->findOrFail($id);
				$usuario = User::with('Rate')->findOrFail(Auth::user()->id);
				$rate = $produto->rate()->where('account_id', '=', $usuario->id)->get();

				if($pontuacao>0){
					$validator = Validator::make($data = array('rate' => $pontuacao), Rate::$rules);
					if ($validator->fails()) { return 0; }

					if($rate->count()){
						$rate->first()->update(['rate' => $pontuacao]);
					}else{
						$rate = new Rate($data);
						$rate->account_id = $usuario->id;
						$rate->save();

						$rate->produto()->attach($produto->id);
					}
				}else{
					if($rate->count()){
						$rate->first()->produto()->detach($produto->id);
						$rate->first()->delete();
					}
				}

				if($produto->rate->count()){ $score = $produto->rate->sum('rate')/$produto->rate->count(); $total = $produto->rate->count(); }else{ $score = 0; $total = 0; }
				$retorno = array('score' => $score, 'total' => $total);
				return $retorno;
			}elseif($tipo==="paginas"){

			}
		}
	}

}
