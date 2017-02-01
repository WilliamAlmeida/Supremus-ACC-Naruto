<?php

class RegistrosController extends \BaseController {

	public function getIndex()
	{
		$registros = Registro::with('User', 'Player')->orderBy('id', 'desc')->paginate(50);

		$tipos = Helpers::arTiposRegistro();

		return View::make('registros.index', compact('registros', 'tipos'));
	}

	public function getRegistro($id = null)
	{
		$registro = Registro::with('User', 'Player')->findOrfail($id);

		$tipos = Helpers::arTiposRegistro();

		return View::make('registros.show', compact('registro', 'tipos'));
	}

	public function getDeletar($id = null)
	{
		ShopOffer::destroy($id);

		return Redirect::to('itens')->with('message', 'Deletado com sucesso!');
	}
}
