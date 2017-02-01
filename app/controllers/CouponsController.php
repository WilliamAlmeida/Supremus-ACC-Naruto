<?php

class CouponsController extends \BaseController {

	public function getHome()
	{
		return View::make('coupons.home');
	}

	public function postResgatar()
	{
		$rules = array(
			'code' => array('required','min:1','max:255')
			);

		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'cupom')->withInput();
		}

		$cupom = Coupon::with('Users', 'Player')->whereCode($data['code']);

		if(!$cupom->exists())
		{
			return Redirect::route('tela-resgate-cupom')->with('message', Lang::get('content.sorry invalid coupon, enter an existing coupon').'.');
		}else{
			$cupom = $cupom->first();
			if(date('Y-m-d h:i:s') > $cupom->validate)
			{
				return Redirect::route('tela-resgate-cupom')->with('message', Lang::get('content.sorry, but the coupon expired in', ['name' => $cupom->name, 'date' => Helpers::formataData($cupom->validate)]).'.');
			}
		}

		if(Auth::user()->coupon()->whereCode($cupom->code)->count())
		{
			return Redirect::route('tela-resgate-cupom')->with('message', Lang::get('content.have you used the coupon', ['name' => $cupom->name]).'.');
		}

		if($cupom->type==2){
			if($cupom->limit && $cupom->users()->count() >= $cupom->limit)
			{
				return Redirect::route('tela-resgate-cupom')->with('message', Lang::get('content.sorry, but this coupon has arrived at the limit of use').'.');
			}

			$cupom->users()->attach(Auth::user()->id);
			Helpers::vip(Auth::user(), 1, $cupom->count);
		}else{
			return Redirect::route('tela-resgate-cupom')->with('message', Lang::get('content.sorry but this is a coupon for, it cannot be recovered in this form', ['type' => Helpers::arTiposItem()[$cupom->type]]).'.');
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Resgate de Cupom.',
			'text' => ('Usuário '.Auth::user()->name.' resgatou o cupom '.$cupom->name.'.'),
			'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::route('tela-resgate-cupom')->with('message', Lang::get('content.coupon redeemed successfully', ['name' => $cupom->name]).'!');
	}

	public function getIndex()
	{
		$cupons = Coupon::withTrashed('User', 'Users', 'Player')->paginate(15);

		return View::make('coupons.index', compact('cupons'));
	}

	public function getAdicionar()
	{
		$tipos = Helpers::arTiposItem();

		return View::make('coupons.create', compact('tipos'));
	}

	public function postAdicionar()
	{
		$data = Input::all();
		$data['validate'] = $data['validate'].' '.$data['time'].':00';

		$validator = Validator::make($data, Coupon::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'cupom')->withInput();
		}

		$cupom = new Coupon($data);
		$cupom->account_id = Auth::user()->id;
		$cupom->save();

		Helpers::registrarLog($dados = array(
			'subject' => 'Novo Cupom.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu um cupom com nome '.$cupom->name.' e seu código é '.$cupom->code.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/cupons');
	}

	public function getEditar($id = null)
	{
		$cupom = Coupon::withTrashed('User', 'Player')->findOrFail($id);

		$tipos = Helpers::arTiposItem();

		return View::make('coupons.edit', compact('cupom', 'tipos'));
	}

	public function postEditar($id)
	{
		$cupom = Coupon::withTrashed()->findOrFail($id);

		$rules = array(
			'name' => array('required','min:1','max:255'),
			'code' => array('required','min:1','max:255'),
			'type' => array('required','min:0','numeric'),
			'validate' => array('required','date'),
			'item' => array('min:0','numeric'),
			'count' => array('required','min:1','numeric'),
			'limit' => array('required','min:0','numeric')
			);

		$data = Input::all();
		$data['validate'] = $data['validate'].' '.$data['time'].':00';

		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'cupom')->withInput();
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Cupom.',
			'text' => ('Usuário '.Auth::user()->name.' editou o cupom '.$cupom->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$cupom->update($data);

		return Redirect::to('painel/cupons/editar/'.$id)->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id, $soft = "true")
	{
		$cupom = Coupon::withTrashed('User', 'Player')->findOrFail($id);
		if($soft=="false"){
			Helpers::registrarLog($dados = array(
				'subject' => 'Remoção de Cupom.',
				'text' => ('Usuário '.Auth::user()->name.' deletou o cupom '.$cupom->name.', código '.$cupom->code.'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$cupom->forceDelete();

			return Redirect::to('painel/cupons')->with('message', 'Deletado com sucesso!');
		}else{
			if($cupom->trashed()){
				$cupom->restore();

				Helpers::registrarLog($dados = array(
					'subject' => 'Ativação de Cupom.',
					'text' => ('Usuário '.Auth::user()->name.' ativou o cupom '.$cupom->name.', código '.$cupom->code.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/cupons')->with('message', 'Ativado com sucesso!');
			}else{
				$cupom->delete();

				Helpers::registrarLog($dados = array(
					'subject' => 'Desativação de Cupom.',
					'text' => ('Usuário '.Auth::user()->name.' desativou o cupom '.$cupom->name.', código '.$cupom->code.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/cupons')->with('message', 'Desativado com sucesso!');
			}
		}
	}
}