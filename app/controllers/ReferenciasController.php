<?php

class ReferenciasController extends \BaseController {

	public function getResgatar($codigo = null){
		if(!$codigo){ return Redirect::back(); }
		$codigo = base64_decode($codigo);

		if(Auth::user()->referencia()->whereName($codigo)->whereStatus(1)->exists()){
			Session::flash('notificacoes', Lang::get('content.this prize has been left for you').'!');
			return Redirect::back();
		}

		$resultado = Helpers::verificarReferencias(Auth::user()->id, $codigo, true);

		if($resultado){
			$referencia = new Referencia();
			$referencia->account_id = Auth::user()->id;
			$referencia->name = $codigo;
			$referencia->status = 1;
			$referencia->save();

			Session::flash('notificacoes', Lang::get('content.award rescued successfully').'!');
		}
		return Redirect::route('minha-conta');
	}

}
