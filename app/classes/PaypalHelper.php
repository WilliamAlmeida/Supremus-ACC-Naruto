<?php

class PaypalHelper extends \BaseController {

	public static function arStatusTransacao(){
		$status = array();
		$status = array_add($status, 1, array(
			'status' => 'Autorizado',
			'descricao' => 'Pagamento já foi realizado porém ainda não foi creditado na Carteira Paypal recebedora (devido ao floating da forma de pagamento).'
			));
		$status = array_add($status, 2, array(
			'status' => 'Iniciado',
			'descricao' => 'Pagamento está sendo realizado ou janela do navegador foi fechada (pagamento abandonado).'
			));
		$status = array_add($status, 3, array(
			'status' => 'Boleto Impresso',
			'descricao' => 'Boleto foi impresso e ainda não foi pago.'
			));
		$status = array_add($status, 4, array(
			'status' => 'Concluido',
			'descricao' => 'Pagamento já foi realizado e dinheiro já foi creditado na Carteira Paypal recebedora.'
			));
		$status = array_add($status, 5, array(
			'status' => 'Cancelado',
			'descricao' => 'Pagamento foi cancelado pelo pagador, instituição de pagamento, Paypal ou recebedor antes de ser concluído.'
			));
		$status = array_add($status, 6, array(
			'status' => 'Em Análise',
			'descricao' => 'Pagamento foi realizado com cartão de crédito e autorizado, porém está em análise pela Equipe Paypal. Não existe garantia de que será concluído.'
			));
		$status = array_add($status, 7, array(
			'status' => 'Estornado',
			'descricao' => 'Pagamento foi estornado pelo pagador, recebedor, instituição de pagamento ou Paypal.'
			));
		return $status;
	}
}