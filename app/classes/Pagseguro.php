<?php

use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Environments\Production;
use PHPSC\PagSeguro\Environments\Sandbox;

class Pagseguro extends \BaseController {

	public static function credentials(){

		$configuracoes = Configuracao::first();
		/* Ambiente de produção: */
		/*$credentials = new Credentials('williamkillerca@hotmail.com', '532947552CF8461F921AC61010A2E89A', new Production() );*/

		/* Ambiente de testes: */
		return $credentials = new Credentials(
			$configuracoes->pagseguro_email, 
			$configuracoes->pagseguro_token,
			new Sandbox()
			);
	}

	public static function arStatusTransacao(){
		$status = array();
		$status = array_add($status, 1, array(
			'status' => 'Aguardando pagamento',
			'descricao' => 'O comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.'
			));
		$status = array_add($status, 2, array(
			'status' => 'Em análise',
			'descricao' => 'O comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.'
			));
		$status = array_add($status, 3, array(
			'status' => 'Paga',
			'descricao' => 'A transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.'
			));
		$status = array_add($status, 4, array(
			'status' => 'Disponível',
			'descricao' => 'A transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.'
			));
		$status = array_add($status, 5, array(
			'status' => 'Em disputa',
			'descricao' => 'O comprador, dentro do prazo de liberação da transação, abriu uma disputa.'
			));
		$status = array_add($status, 6, array(
			'status' => 'Devolvida',
			'descricao' => 'O valor da transação foi devolvido para o comprador.'
			));
		$status = array_add($status, 7, array(
			'status' => 'Cancelada',
			'descricao' => 'A transação foi cancelada sem ter sido finalizada.'
			));
		return $status;
	}
}