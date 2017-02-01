<?php

class ShopsController extends \BaseController {

	public function getHome()
	{
		$usuario = User::with('Player')->findOrfail(Auth::user()->id);

		$history = ShopHistory::with('Player', 'ShopOffer');

		$history = $history->where('from', '=', $usuario->name);

		if(!$usuario->player()->get()->isEmpty()){
			foreach ($usuario->player() as $key => $player) {
				if($key){
					$history = $history->where('from', '=', $player->name);
				}else{
					$history = $history->orWhere('name', '=', $player->name);
				}
			}
		}
		$history = $history->orderBy('date', 'desc')->take(10)->get();

		$donations = ShopDonationHistory::with('User', 'PagseguroTransacao', 'MoipTransacao', 'PaypalTransacao')->whereAccount($usuario->id)->take(10)->orderBy('date','desc')->get();

		$status = array(
			'PagSeguro' => Pagseguro::arStatusTransacao(),
			'Moip' => MoipHelper::arStatusTransacao(),
			'Paypal' => PaypalHelper::arStatusTransacao()
			);

		$itens = ShopOffer::all();

		$lista_players = $usuario->player()->lists('name', 'id');
		$lista_friends = Player::where('account_id', '!=', $usuario->id)->lists('name', 'id');

		$payments = array(
			'pagseguro' => ((Configuracao::first()->pagseguro_token) ? true : false),
			'moip' => ((Moip::first()->token) ? true : false),
			'paypal' => ((Configuracao::first()->paypal_secret) ? true : false)
			);

		return View::make('shops.home', compact('usuario', 'donations', 'status', 'itens', 'history', 'lista_players', 'lista_friends', 'payments'));
	}
	
	public function getIndex()
	{
		$itens = ShopOffer::paginate(15);

		return View::make('shops.index', compact('itens'));
	}

	public function getAdicionar()
	{
		$categorias = Helpers::arCategorias();

		return View::make('shops.create', compact('categorias'));
	}

	public function postAdicionar()
	{
		$validator = Validator::make($data = Input::all(), ShopOffer::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'item')->withInput();
		}

		$item = new ShopOffer($data);
		$item->save();

		Helpers::registrarLog($dados = array(
			'subject' => 'Novo Item no Shop.',
			'text' => ('Usuário '.Auth::user()->name.' inseriu um novo item no Shop com nome '.$data['name'].'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/itens');
	}

	public function getEditar($id = null)
	{
		$item = ShopOffer::with('MidiaShopOffer')->find($id);

		$categorias = Helpers::arCategorias();

		return View::make('shops.edit', compact('item', 'categorias'));
	}

	public function postEditar($id)
	{
		$item = ShopOffer::findOrFail($id);

		$rules = array(
			'points' => array('required','min:0','numeric'),
			'category' => array('required','min:1','numeric'),
			'type' => array('required','min:1','numeric'),
			'item' => array('required','min:0','numeric'),
			'count' => array('required','min:0','numeric'),
			'description' => array('required','min:10'),
			'name' => array('required','min:0','max:255'),
			'destaque' => array('min:0','max:1','numeric'),
			'points_off' => array('min:0','numeric')
			);
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'item')->withInput();
		}

		if (Input::has('featured')===false) { $item->featured = 0; }

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição do Item do Shop.',
			'text' => ('Usuário '.Auth::user()->name.' editou o item '.$item->name.'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		$item->update($data);

		return Redirect::to('painel/itens/editar/'.$id)->with('message', 'Atualização realizada com sucesso!');
	}

	public function getDeletar($id = null, $soft = "true")
	{
		$item = ShopOffer::withTrashed('MidiaShopOffer', 'ShopHistory')->findOrFail($id);
		if($soft=="false"){
			Helpers::registrarLog($dados = array(
				'subject' => 'Remoção de Item do Shop.',
				'text' => ('Usuário '.Auth::user()->name.' deletou o item '.$item->name.' do Shop.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			$item->forceDelete();

			return Redirect::to('painel/itens')->with('message', 'Deletado com sucesso!');
		}else{
			if($item->trashed()){
				$item->restore();

				Helpers::registrarLog($dados = array(
					'subject' => 'Ativação de Item do Shop.',
					'text' => ('Usuário '.Auth::user()->name.' ativou a item '.$item->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/itens')->with('message', 'Ativado com sucesso!');
			}else{
				$item->delete();

				Helpers::registrarLog($dados = array(
					'subject' => 'Desativação de Item do Shop.',
					'text' => ('Usuário '.Auth::user()->name.' desativou a item '.$item->name.'.'),
					'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to('painel/itens')->with('message', 'Desativado com sucesso!');
			}
		}
	}

	public function getHistoricoCompras()
	{
		$compras = ShopHistory::orderBy('date', 'desc')->paginate(15);

		return View::make('shops.compras', compact('compras'));
	}

	public function postComprar($id = null){
		$usuario = Auth::user();
		$data = Input::all();

		$item = ShopOffer::findOrFail($id);
		if($item->stock <= 0){
			return Redirect::route('shop')->with('message_item', Lang::get('content.this is a limited item, your stock is empty, wait when some promotion and he\'s available for sale again').'.');
		}

		if(isset($data['quantidade'])){
			if($data['quantidade'] <= 0){
				return Redirect::route('shop')->with('message_item', Lang::get('content.select a quantity permitted').'!');
			}
			if($item->points_off <= 0){
				if(($data['quantidade']*$item->points) > $usuario->premium_points){
					return Redirect::route('shop')->with('message_item', Lang::get('content.you do not have the amount of points required to purchase', ['quantity' => $data['quantidade'], 'name' => $item->name]).'!');
				}
			}else{
				if(($data['quantidade']*$item->points_off) > $usuario->premium_points){
					return Redirect::route('shop')->with('message_item', Lang::get('content.you do not have the amount of points required to purchase', ['quantity' => $data['quantidade'], 'name' => $item->name]).'!');
				}	
			}
		}

		if(isset($data['present'])){
			if(!isset($data['friend_player'])){
				return Redirect::route('shop')->with('message_item', Lang::get('content.character is not found, select a character to receive the gift').'!');
			}else{
				$player = Player::with('User')->where('id', '=', $data['friend_player'])->first();
				if(empty($player)){
					return Redirect::route('shop')->with('message_item', Lang::get('content.Character is not found, select an existing character').'!');
				}
			}

		}elseif(isset($data['my_player'])){
			$player = Player::with('User')->where('id', '=', $data['my_player'])->first();
			if(empty($player)){
				return Redirect::route('shop')->with('message_item', Lang::get('content.Character is not found, select an existing character').'!');
			}
		}else{
			return Redirect::route('shop')->with('message_item', Lang::get('content.Character is not found, select an existing character').'!');
		}

		for ($i=0; $i < $data['quantidade']; $i++) {
			$compra = new ShopHistory();
			$compra->product = $item->id;
			$compra->session = $data['_token'];
			$compra->from = $usuario->name;
			$compra->player = $player->name;
			$compra->date = time();
			$compra->points = ($item->points_off) ? $item->points_off : $item->points;
			if($item->category==2){
				$compra->processed = 1;
			}
			$compra->save();
		}
		
		if($item->category==2){
			User::whereId($player->user->id)->update(['premdays' => $player->user->premdays+$item->count]);
		}
		
		if($item->points_off > 0){
			$custo = $data['quantidade']*$item->points_off;
		}else{
			$custo = $data['quantidade']*$item->points;
		}
		$usuario->premium_points -= $custo;
		$usuario->premium_points_lost += $custo;
		$usuario->update(['premium_points' => $usuario->premium_points, 'premium_points_lost' => $usuario->premium_points_lost]);

		Helpers::registrarLog($dados = array(
			'subject' => 'Compra de Item no Shop.',
			'text' => ('Usuário '.Auth::user()->name.' comprou '.$item->name.'.'),
			'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::route('shop')->with('message_item', Lang::get('content.purchase successful').'!');
	}

}