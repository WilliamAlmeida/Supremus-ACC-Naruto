<?php

use App\Http\Requests;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PaypalTransacoesController extends \BaseController {

	private $_api_context;

	public function __construct()
	{
		$configuracoes = Configuracao::first();
        // setup PayPal api context
		$paypal_conf = Config::get('packages/paypal');
		$this->_api_context = new ApiContext(new OAuthTokenCredential($configuracoes->paypal_client_id, $configuracoes->paypal_secret));
		$this->_api_context->setConfig($paypal_conf['settings']);
	}

	public function getTransacao($code = null)
	{
		$transacao = PaypalTransacao::with('User','ShopDonationHistory')->where('TransacaoID', '=', $code)->first();
		$configuracoes = Configuracao::first();

		$status = PaypalHelper::arStatusTransacao();
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

		$usuario = Auth::user();
		$configuracao = Configuracao::first();
		$preco = $configuracao->cost_points;
		if(isset($desconto)){ $preco = $preco-($preco*($desconto/100)); }

		if(!empty($data)){
			$payer = new Payer();
			$payer->setPaymentMethod('paypal');

			$item_1 = new Item();
			$item_1->setName($data['item']) /*item name*/
			->setCurrency('BRL') /*USD*/
			->setQuantity($data['points'])
			->setPrice($preco); /*unit price*/

			/*add item to list*/
			$item_list = new ItemList();
			$item_list->setItems(array($item_1));

			$amount = new Amount();
			$amount->setCurrency('BRL')
			->setTotal(($preco*$data['points']));

			$transaction = new Transaction();
			$transaction->setAmount($amount)
			->setItemList($item_list)
			->setDescription($configuracao->title.' - Shop');

			$redirect_urls = new RedirectUrls();
			$redirect_urls->setReturnUrl(route('concluir-transacao-paypal'))
			->setCancelUrl(route('concluir-transacao-paypal'));

			$payment = new Payment();
			$payment->setIntent('Sale')
			->setPayer($payer)
			->setRedirectUrls($redirect_urls)
			->setTransactions(array($transaction));

			try {
				$payment->create($this->_api_context);
			} catch (\PayPal\Exception\PPConnectionException $ex) {
				if (\Config::get('app.debug')) {
					echo "Exception: " . $ex->getMessage() . PHP_EOL;
					$err_data = json_decode($ex->getData(), true);
					exit;
				} else {
					die('Some error occur, sorry for inconvenient');
				}
			}

			foreach($payment->getLinks() as $link) {
				if($link->getRel() == 'approval_url') {
					$redirect_url = $link->getHref();
					break;
				}
			}

			/*add payment ID to session*/
			Session::put('Paypal_Code', $payment->getId());

			if(isset($redirect_url)) {
				Helpers::registrarLog($dados = array(
					'subject' => 'Compra de Pontos no Shop.',
					'text' => ('Usuário '.Auth::user()->name.' solicitou uma compra de '.$data["points"].' pontos no Shop.'),
					'type' => 2, 'ip' => null, 'account_id' => Auth::user()->id, 'player_id' => null));

				$transacao = new PaypalTransacao();
				$transacao->TransacaoID = $payment->getId();
				$transacao->VendedorEmail = $configuracao->email;
				$transacao->Referencia = $configuracao->title.' - Shop';
				$transacao->Anotacao = $usuario->id;
				$transacao->Data = date('Y-m-d h:i:s');
				$transacao->NumItens = $data['points'];
				$transacao->status = 2;
				$transacao->save();

				/*redirect to paypal*/
				return Redirect::away($redirect_url);
			}

			return Redirect::route('shop')->with('message', Lang::get('content.sorry, there was an error in time to make the payment by', ['payment' => 'Paypal']).'.');
		// return Redirect::route('original.route')->with('error', 'Unknown error occurred');
		}else{
			return Redirect::back();
		}
	}

	public function getConcluirTransacao()
	{
		/*Get the payment ID before session clear*/
		$payment_id = Session::get('Paypal_Code');

		/*clear the session payment ID*/
		Session::forget('Paypal_Code');

		if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
			PaypalTransacao::with('User')->where('TransacaoID', '=', $payment_id)->update(['status' => 5]);

			return Redirect::route('shop')->with('message', Lang::get('content.at the conclusion of the payment failure').'.');
		}

		$payment = Payment::get($payment_id, $this->_api_context);

		/*PaymentExecution object includes information necessary */
		/*to execute a PayPal account payment. */
		/*The payer_id is added to the request query parameters*/
		/*when the user is redirected from paypal back to your site*/
		$execution = new PaymentExecution();
		$execution->setPayerId(Input::get('PayerID'));

		/*Execute the payment*/
		$result = $payment->execute($execution, $this->_api_context);

		// echo '<pre>';print_r($result);echo '</pre>';exit; /*DEBUG RESULT, remove it later*/

		if ($result->getState() == 'approved') { /*payment made*/
			$usuario = Auth::user();

			$resultado = PaypalTransacao::with('User')->where('TransacaoID', '=', Input::get('paymentId'))->update(['status' => 4]);
			if(!$resultado){
				return Redirect::route('shop')->with('message', Lang::get('content.at the conclusion of the payment failure').'.');
			}

			$donation = new ShopDonationHistory();
			$donation->method = 'Paypal';
			$donation->receiver = $usuario->email;
			$donation->buyer = $usuario->email;
			$donation->account = $usuario->id;
			$donation->points = $result->transactions[0]->item_list->items[0]->quantity;
			$donation->date = time();
			$donation->transacaoID = Input::get('paymentId');
			$donation->save();

			$transacao = PaypalTransacao::with('User')->where('TransacaoID', '=', Input::get('paymentId'))->first();
			if($transacao->status == 4){
				$usuario = User::with('PaypalTransacao')->findOrfail($transacao->user->id);
				$usuario->premium_points += $result->transactions[0]->item_list->items[0]->quantity;
				$usuario->update();

				if(date('Y-m-d h:i:s') <= "2016-03-31 23:59:00"){
					for ($i=0; $i < round($transacao->NumItens/10); $i++) {
						$compra = new ShopHistory();
						$compra->product = 7;
						$compra->session = csrf_token();
						$compra->from = $usuario->name;
						$compra->player = $usuario->player()->orderBy('level', 'desc')->first()->name;
						$compra->date = time();
						$compra->points = 0;
						$compra->save();
					}
				}
			}

			return Redirect::route('shop')->with('message', Lang::get('content.payment success', ['payment' => 'Paypal']).'!');
		}
		return Redirect::route('shop')->with('message', Lang::get('content.at the conclusion of the payment failure').'.');
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

			$resultado = $transacao = PagseguroTransacao::with('User')->where('TransacaoID', '=', $detalhes->getCode())->update(['status' => $detalhes->getStatus()]);

			if($detalhes->getStatus()==3){
				$transacao = PagseguroTransacao::with('User')->where('TransacaoID', '=', $detalhes->getCode())->first();
				$usuario = User::with('PagseguroTransacao')->findOrfail($transacao->user->id);
				$usuario->premium_points += $transacao->NumItens;
				$usuario->update();
			}

			return ($resultado) ? 'sucesso' : 'falhou'; /*var_dump($purchase);*/ /*Exibe na tela a transação ou assinatura atualizada*/
		} catch (Exception $error) {
			echo $error->getMessage();
		}
	}

}
