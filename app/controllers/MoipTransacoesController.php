<?php

class MoipTransacoesController extends \BaseController {

	public function getTransacao($code = null)
	{
		$transacao = MoipTransacao::with('User','ShopDonationHistory')->where('TransacaoID', '=', $code)->first();
		$configuracoes= Configuracao::first();

		$status = MoipHelper::arStatusTransacao();
		$grupos = Helpers::arGrupo();

		return View::make('transacao.visualizacao', compact('transacao', 'status', 'configuracoes', 'grupos'));
	}

	public function postEfetuarTransacao()
	{
		$data = Input::all();

		if(Input::has('code')){
			$rules = array(
				'code' => array('min:1','max:255')
				);
			$validator = Validator::make($data, $rules);
			if ($validator->fails()) { return Redirect::back()->withErrors($validator, 'cupom')->withInput(); }

			$cupom = Coupon::with('Users', 'Player')->whereCode($data['code']);
			if(!$cupom->exists())
			{
				return Redirect::route('shop')->with('message', Lang::get('content.sorry invalid coupon, enter an existing coupon').'.');
			}else{
				$cupom = $cupom->first();
				if(date('Y-m-d h:i:s') > $cupom->validate)
				{
					return Redirect::route('shop')->with('message', Lang::get('content.sorry, but the coupon expired in', ['name' => $cupom->name, 'date' => Helpers::formataData($cupom->validate)]).'.');
				}
			}

			if(Auth::user()->coupon()->whereCode($cupom->code)->count())
			{
				return Redirect::route('shop')->with('message', Lang::get('content.have you used the coupon', ['name' => $cupom->name]).'.');
			}

			if($cupom->type==0){
				if($cupom->limit && $cupom->users()->count() >= $cupom->limit)
				{
					return Redirect::route('shop')->with('message', Lang::get('content.sorry, but this coupon has arrived at the limit of use').'.');
				}

				$cupom->users()->attach(Auth::user()->id);
				$desconto = $cupom->count;
			}else{
				return Redirect::route('shop')->with('message', Lang::get('content.sorry, but this is not a discount coupon').'.');
			}
		}

		$configuracao = Configuracao::first();
		$preco = $configuracao->cost_points;
		if(isset($desconto)){ $preco = $preco-($preco*($desconto/100)); }

		if(!empty($data)){
			$unique = sha1(str_random(15));

			$data = [
			'unique_id' => $unique,
			'reason' => ((isset($data['item'])) ? $data['item'] : 'Desconhecida'),
			'url_notification' => route('receber-notificacao-moip'),
			'url_return' => route('concluir-transacao-moip'),
			'prices' => [
			'value' => ($preco*$data['points'])
			]
			];

			$response = MoipApi::postOrder($data);

			$xmlRes = simplexml_load_string($response->replyXML);
			$xmlIns = simplexml_load_string($response->getXML);

			$usuario = Auth::user();
			$configuracao = Configuracao::first();

			$transacao = new MoipTransacao();
			$transacao->TransacaoID = (string) $xmlIns->InstrucaoUnica->IdProprio;
			$transacao->VendedorEmail = (string) $xmlIns->InstrucaoUnica->Recebedor->LoginMoIP;
			$transacao->Referencia = base64_encode($usuario->id);
			$transacao->Anotacao = $usuario->id;
			$transacao->Data = date('Y-m-d h:i:s');
			$transacao->NumItens = (string) $xmlIns->InstrucaoUnica->Valores->Valor;
			$transacao->status = 2;
			$transacao->save();

			return Redirect::to($response->url);

		}else{
			return Redirect::back();
		}
	}

	public function getConcluirTransacao()
	{
		$moip = Session::get('pagamento.response');

		try {
			$xmlRes = simplexml_load_string($moip['replyXML']);
			$xmlIns = simplexml_load_string($moip['getXML']);

			$usuario = Auth::user();
			$configuracao = Configuracao::first();

			// $transacao = MoipTransacao::where('TransacaoID', '=', $xmlIns->InstrucaoUnica->IdProprio);
			// if($transacao->exists()==false){
			// 	$transacao = new MoipTransacao();
			// }else{
			// 	$transacao = $transacao->first();
			// }

			// $transacao->TransacaoID = (string) $xmlIns->InstrucaoUnica->IdProprio;
			// $transacao->VendedorEmail = (string) $xmlIns->InstrucaoUnica->Recebedor->LoginMoIP;
			// $transacao->Referencia = $configuracao->title.' - Shop';
			// $transacao->Anotacao = $usuario->id;
			// $transacao->Data = date('Y-m-d h:i:s');
			// $transacao->NumItens = (string) $xmlIns->InstrucaoUnica->Valores->Valor;
			// $transacao->status = 1;
			// $transacao->update();
			$resultado = MoipTransacao::with('User')->where('TransacaoID', '=', $xmlIns->InstrucaoUnica->IdProprio)->update(['status' => 1]);
			if(!$resultado){
				return Redirect::route('shop')->with('message', Lang::get('content.at the conclusion of the payment failure').'.');
			}

			$donation = new ShopDonationHistory();
			$donation->method = 'Moip';
			$donation->receiver = $usuario->email;
			$donation->buyer = $usuario->email;
			$donation->account = $usuario->id;
			$donation->points = (string) $xmlIns->InstrucaoUnica->Valores->Valor;
			$donation->date = time();
			$donation->transacaoID = (string) $xmlIns->InstrucaoUnica->IdProprio;
			$donation->save();

			return Redirect::route('shop')->with('message', Lang::get('content.payment success', ['payment' => 'Moip']).'!');
		} catch (Exception $error) {
			return Redirect::route('shop')->with('message', Lang::get('content.at the conclusion of the payment failure').'.');
		}
	}

	public function getNotificacao()
	{
		header("access-control-allow-origin: https://desenvolvedor.moip.com.br");
		try {
			if(!Input::has('id_transacao') || !Input::has('status_pagamento')){
				echo 'Erro, não foram encontrado os dados: "id_transacao" ou "status_pagamento".';
				return false;
			}

			$codigo = Input::get('id_transacao');
			$status = Input::get('status_pagamento');

			$resultado = $transacao = MoipTransacao::with('User')->where('TransacaoID', '=', $codigo)->update(['status' => $status]);

			if($status==4){
				$transacao = MoipTransacao::with('User')->where('TransacaoID', '=', $codigo)->first();
				$usuario = User::with('MoipTransacao')->findOrfail($transacao->user->id);
				$usuario->premium_points += $transacao->NumItens;
				$usuario->update();
			}

			return ($resultado) ? 'sucesso' : 'falhou';
		} catch (Exception $error) {
			return 'erro';
			// echo $error;
		}
	}

}