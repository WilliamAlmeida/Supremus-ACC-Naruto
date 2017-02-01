<?php

class TransacoesController extends \BaseController {

	public function getIndex()
	{
		$transacoes = ShopDonationHistory::with('PagseguroTransacao','MoipTransacao','PaypalTransacao')->groupBy('TransacaoID')->orderBy('date', 'asc')->paginate(100);
		// $transacoes = PagseguroTransacao::with('User','ShopDonationHistory')->paginate(15);
		$configuracoes = Configuracao::first();

		$status = array(
			'PagSeguro' => Pagseguro::arStatusTransacao(),
			'Moip' => MoipHelper::arStatusTransacao(),
			'Paypal' => PaypalHelper::arStatusTransacao()
			);

		return View::make('transacao.index', compact('transacoes', 'status', 'configuracoes'));
	}

	public function getAdicionar()
	{
		$lista_contas = User::lists('name', 'id');
		$configuracoes = Configuracao::first();

		$status = array(
			'PagSeguro' => Pagseguro::arStatusTransacao(),
			'Moip' => MoipHelper::arStatusTransacao(),
			'Paypal' => PaypalHelper::arStatusTransacao()
			);
		$status = array('PagSeguro' => null, 'Moip' => null, 'Paypal' => null);
		foreach (Pagseguro::arStatusTransacao() as $key => $value) { $status['PagSeguro'] = array_add($status['PagSeguro'], $key, $value['status']); }
		foreach (MoipHelper::arStatusTransacao() as $key => $value) { $status['Moip'] = array_add($status['Moip'], $key, $value['status']); }
		foreach (PaypalHelper::arStatusTransacao() as $key => $value) { $status['Paypal'] = array_add($status['Paypal'], $key, $value['status']); }

		$payments = array();
		if($configuracoes->pagseguro_token){ $payments = array_add($payments, 'PagSeguro', 'PagSeguro'); }
		if($configuracoes->paypal_secret){ $payments = array_add($payments, 'Paypal', 'Paypal'); }
		if(Moip::first()->token){ $payments = array_add($payments, 'Moip', 'Moip'); }

		return View::make('transacao.create', compact('lista_contas', 'payments', 'status'));
	}

	public function postAdicionar()
	{
		$rules = array(
			'TransacaoID' => array('required','min:0','max:255'),
			'NumItens' => array('required','min:0','numeric'),
			'Data' => array('required','min:0','date'),
			'status' => array('required','min:0','numeric')
			);

		$data = Input::all();
		$data['Data'] = $data['Data'].' '.$data['time'].':00';
		$data['status'] = $data[$data['method']];

		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'transacao')->withInput();
		}

		$configuracao = Configuracao::first();
		$usuario = User::findOrfail($data['Anotacao']);

		if($data['method'] == 'PagSeguro'){
			$transacao = new PagseguroTransacao($data);
			$transacao->VendedorEmail = $configuracao->pagseguro_email;
		}elseif($data['method'] == 'Paypal'){
			$transacao = new PaypalTransacao($data);
			$transacao->VendedorEmail = $configuracao->email;
		}elseif($data['method'] == 'Moip'){
			$transacao = new MoipTransacao($data);
			$transacao->VendedorEmail = Moip::first()->receiver;
		}

		$transacao->CliEmail = $usuario->email;
		$resultado = $transacao->save();

		if($resultado){
			$donation = new ShopDonationHistory();
			$donation->method = $data['method'];
			$donation->receiver = $transacao->VendedorEmail;
			$donation->buyer = $transacao->CliEmail;
			$donation->account = $transacao->Anotacao;
			$donation->points = $transacao->NumItens;
			$donation->date = time(date_create($data['Data']));
			$donation->transacaoID = $transacao->TransacaoID;
			$donation->save();

			/*if($data['status'] == 4 && $transacao->status != 4){
				$usuario->update(['premium_points' => ($usuario->premium_points+$data['NumItens'])]);
			}*/

			Helpers::registrarLog($dados = array(
				'subject' => 'Nova Transação.',
				'text' => ('Usuário '.Auth::user()->name.' registrou uma nova com o código '.$data["TransacaoID"].'.'),
				'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

			return Redirect::to('painel/transacoes');
		}else{
			return Redirect::back()->withErrors('Não foi possivel registrar esta transação!', 'transacao')->withInput();
		}
	}

	public function getEditar($id = null, $method = null)
	{
		if($method == "PagSeguro"){
			$transacao = PagseguroTransacao::where('TransacaoID', '=', $id)->first();
		}elseif($method == "Moip"){
			$transacao = MoipTransacao::where('TransacaoID', '=', $id)->first();
		}elseif($method == "Paypal"){
			$transacao = PaypalTransacao::where('TransacaoID', '=', $id)->first();
		}

		$lista_contas = User::lists('name', 'id');
		$configuracoes = Configuracao::first();

		$status = array(
			'PagSeguro' => Pagseguro::arStatusTransacao(),
			'Moip' => MoipHelper::arStatusTransacao(),
			'Paypal' => PaypalHelper::arStatusTransacao()
			);
		$status = array('PagSeguro' => null, 'Moip' => null, 'Paypal' => null);
		foreach (Pagseguro::arStatusTransacao() as $key => $value) { $status['PagSeguro'] = array_add($status['PagSeguro'], $key, $value['status']); }
		foreach (MoipHelper::arStatusTransacao() as $key => $value) { $status['Moip'] = array_add($status['Moip'], $key, $value['status']); }
		foreach (PaypalHelper::arStatusTransacao() as $key => $value) { $status['Paypal'] = array_add($status['Paypal'], $key, $value['status']); }

		$payments = array();
		if($configuracoes->pagseguro_token){ $payments = array_add($payments, 'PagSeguro', 'PagSeguro'); }
		if($configuracoes->paypal_secret){ $payments = array_add($payments, 'Paypal', 'Paypal'); }
		if(Moip::first()->token){ $payments = array_add($payments, 'Moip', 'Moip'); }

		return View::make('transacao.edit', compact('transacao', 'lista_contas', 'payments', 'status', 'method'));
	}

	public function postEditar($id)
	{
		$rules = array(
			'TransacaoID' => array('required','min:0','max:255'),
			'NumItens' => array('required','min:0','numeric'),
			'Data' => array('required','min:0','date'),
			'status' => array('required','min:0','numeric')
			);

		$data = Input::all();
		$data['Data'] = $data['Data'].' '.$data['time'].':00';
		$data['status'] = $data[$data['method']];

		$validator = Validator::make($data, $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator, 'transacao')->withInput();
		}

		$configuracao = Configuracao::first();
		$usuario = User::findOrfail($data['Anotacao']);
		$method = $data['method'];

		unset($data['_token']); unset($data['method']); unset($data['PagSeguro']); unset($data['Paypal']); unset($data['Moip']); unset($data['time']);

		if($method == 'PagSeguro'){
			$transacao = PagseguroTransacao::where('TransacaoID', '=', $id)->first();

			$resultado = PagseguroTransacao::where('TransacaoID', '=', $id)->update($data);
		}elseif($method == 'Paypal'){
			$transacao = PaypalTransacao::where('TransacaoID', '=', $id)->first();

			$resultado = PaypalTransacao::where('TransacaoID', '=', $id)->update($data);
		}elseif($method == 'Moip'){
			$transacao = MoipTransacao::where('TransacaoID', '=', $id)->first();

			$resultado = MoipTransacao::where('TransacaoID', '=', $id)->update($data);
		}

		$donation = array(
			'method' => $method,
			'account' => $data['Anotacao'],
			'points' => $data['NumItens'],
			'date' => time(date_create($data['Data'])),
			'transacaoID' => $data['TransacaoID'],
			);
		$resultado = ShopDonationHistory::where('TransacaoID', '=', $id)->update($donation);

		if($data['status'] == 4 && $transacao->status != 4){
			$usuario->update(['premium_points' => ($usuario->premium_points+$data['NumItens'])]);
		}

		Helpers::registrarLog($dados = array(
			'subject' => 'Edição de Transação.',
			'text' => ('Usuário '.Auth::user()->name.' editou informações da transação '.$data["TransacaoID"].'.'),
			'type' => 3, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

		return Redirect::to('painel/transacoes/editar/'.$id.'/'.$method)->with('message', 'Atualização realizada com sucesso!');
	}
}