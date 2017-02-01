<?php

use App\Http\Requests;

use PHPSC\PagSeguro\Customer\Customer;
use PHPSC\PagSeguro\Items\Item;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;

use PHPSC\PagSeguro\Purchases\Subscriptions\Locator as SubscriptionLocator;
use PHPSC\PagSeguro\Purchases\Transactions\Locator as TransactionLocator;

use PHPSC\PagSeguro\Purchases\Transactions\Locator;

class PagseguroTransacoesController extends \BaseController {

	public function getTransacao($code = null)
	{
		$transacao = PagseguroTransacao::with('User','ShopDonationHistory')->where('TransacaoID', '=', $code)->first();
		$configuracoes= Configuracao::first();

		$status = Pagseguro::arStatusTransacao();
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
			$credentials = Pagseguro::credentials();
			try {
				$service = new CheckoutService($credentials); /*cria instância do serviço de pagamentos*/

				$checkout = $service->createCheckoutBuilder()
				->addItem(new Item(1, $data['item'], $preco, $data['points']))
				->setReference(base64_encode(Auth::user()->id))
				->setRedirectTo(route('concluir-transacao-pagseguro'))
				->getCheckout();

				$response = $service->checkout($checkout);

				Session::put('PagSeguro_Code', $response->getCode());

				Helpers::registrarLog($dados = array(
					'subject' => 'Compra de Pontos no Shop.',
					'text' => ('Usuário '.Auth::user()->name.' solicitou uma compra de '.$data["points"].' pontos no Shop.'),
					'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				return Redirect::to($response->getRedirectionUrl());

			} catch (Exception $error) { /*Caso ocorreu algum erro*/
				return Redirect::route('shop')->with('message', $error->getMessage());
			}
		}else{
			return Redirect::back();
		}
	}

	public function getConcluirTransacao()
	{
		$code = Request::get('transaction_id');
		$credentials = Pagseguro::credentials();

		try {
			$usuario = Auth::user();
			$service = new Locator($credentials); /*Cria instância do serviço de localização de transações*/

			$transaction = $service->getByCode($code);

			$detalhes = $transaction->getDetails();

			$pagamento = $transaction->getPayment();

			$cliente = $detalhes->getCustomer();
			$phone_c = $cliente->getPhone();
			$endereco_c = $cliente->getAddress();
			
			$vendedor = $transaction->getShipping();
			$endereco_v = $vendedor->getAddress();

			$itens = $transaction->getItems();

			$transacao = new PagseguroTransacao();
			$transacao->TransacaoID = $detalhes->getCode();
			$transacao->VendedorEmail = $credentials->getEmail();
			$transacao->Referencia = base64_decode($detalhes->getReference());
			$transacao->TipoFrete = $vendedor->getType();
			$transacao->ValorFrete = $vendedor->getCost();
			$transacao->Extras = $pagamento->getExtraAmount();
			$transacao->Anotacao = $usuario->id;
			$transacao->TipoPagamento = $pagamento->getPaymentMethod()->getType();
			$transacao->StatusTransacao = $pagamento->getPaymentMethod()->getCode();
			$transacao->CliNome = $cliente->getName();
			$transacao->CliEmail = $cliente->getEmail();
			if(!empty($endereco_c)){
				$transacao->CliEndereco = $endereco_c->getStreet();
				$transacao->CliEndereco = $endereco_c->getNumber();
				$transacao->CliEndereco = $endereco_c->getComplement();
				$transacao->CliEndereco = $endereco_c->getDistrict();
				$transacao->CliEndereco = $endereco_c->getCity();
				$transacao->CliEndereco = $endereco_c->getState();
				$transacao->CliEndereco = $endereco_c->getPostalCode();
			}
			$transacao->CliTelefone = $phone_c->getAreaCode().$phone_c->getNumber();
			$transacao->Data = $detalhes->getDate()->format('Y-m-d h:i:s');
			$transacao->NumItens = $itens[0]->getQuantity();
			$transacao->status = $detalhes->getStatus();
			$transacao->save();

			$donation = new ShopDonationHistory();
			$donation->method = 'PagSeguro';
			$donation->receiver = $usuario->email;
			$donation->buyer = $usuario->email;
			$donation->account = $usuario->id;
			$donation->points = $transacao->NumItens;
			$donation->date = time();
			$donation->transacaoID = $transacao->TransacaoID;
			$donation->save();

			if($detalhes->getStatus()==3){
				$transacao = PagseguroTransacao::with('User')->where('TransacaoID', '=', $transacao->TransacaoID)->first();
				$usuario = User::with('PagseguroTransacao')->findOrfail($transacao->user->id);
				$usuario->premium_points += $transacao->NumItens;
				$usuario->update();
			}

			return Redirect::route('shop')->with('message', Lang::get('content.payment success', ['payment' => 'Pagseguro']).'!');
		} catch (Exception $error) {
			return Redirect::route('shop')->with('message', $error->getMessage());
		}
	}

	public function getNotificacao()
	{
		$credentials = Pagseguro::credentials();
		/*$link = $credentials->getWsUrl('/v2/transactions/notifications/37F2AC18D1FC46D0A0DDABC0A7FE5B8D');*/
		/*$link = "https://ws.pagseguro.uol.com.br/v2/transactions/37F2AC18D1FC46D0A0DDABC0A7FE5B8D?email=".$credentials->getEmail()."&token=".$credentials->getToken();*/
		header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
		try {
			$service = ($_POST['notificationType'] == 'preApproval') ? new SubscriptionLocator($credentials) : new TransactionLocator($credentials);
			/*Cria instância do serviço de acordo com o tipo da notificação*/

			$purchase = $service->getByNotification($_POST['notificationCode']);
			$detalhes = $purchase->getDetails();
			$itens = $purchase->getItems();

			$verif = PagseguroTransacao::with('User')->where('TransacaoID', '=', $detalhes->getCode())->first();
			if($verif){
				$resultado = $transacao = PagseguroTransacao::with('User')->where('TransacaoID', '=', $detalhes->getCode())->update(['status' => $detalhes->getStatus()]);
			}else{
				$usuario = User::findOrfail(base64_decode($detalhes->getReference()));

				$transacao = new PagseguroTransacao();
				$transacao->TransacaoID = $detalhes->getCode();
				$transacao->VendedorEmail = $credentials->getEmail();
				$transacao->Referencia = $detalhes->getReference();
				$transacao->Anotacao = $usuario->id;
				$transacao->CliNome = (($usuario->nickname) ? $usuario->nickname : $usuario->name);
				$transacao->CliEmail = $usuario->email;

				$transacao->Data = $detalhes->getDate()->format('Y-m-d h:i:s');
				$transacao->NumItens = $itens[0]->getQuantity();
				$transacao->status = $detalhes->getStatus();
				$transacao->save();

				$donation = new ShopDonationHistory();
				$donation->method = 'PagSeguro';
				$donation->receiver = $usuario->email;
				$donation->buyer = $usuario->email;
				$donation->account = $usuario->id;
				$donation->points = $transacao->NumItens;
				$donation->date = time();
				$donation->transacaoID = $transacao->TransacaoID;
				$resultado = $donation->save();
			}

			if($detalhes->getStatus()==3){
				$transacao = PagseguroTransacao::with('User')->where('TransacaoID', '=', $detalhes->getCode())->first();
				$usuario = User::with('PagseguroTransacao', 'Player')->findOrfail($transacao->user->id);
				$usuario->premium_points += $transacao->NumItens;
				$usuario->update();

			}

			return ($resultado) ? 'sucesso' : 'falhou'; /*var_dump($purchase);*/ /*Exibe na tela a transação ou assinatura atualizada*/
		} catch (Exception $error) {
			echo $error->getMessage();
		}
	}

}