<?php

class PaypalTransacao extends \Eloquent {

	protected $table = 'paypaltransacoes';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'TransacaoID' => array('required','min:0','max:255'),
		'VendedorEmail' => array('required','min:0','max:200'),
		'Referencia' => array('min:0','max:200'),
		'TipoFrete' => array('min:0','max:2'),
		'ValorFrete' => array('min:0'),
		'Extras' => array('min:0'),
		'Anotacao' => array('min:0'),
		'TipoPagamento' => array('required','min:0','max:50'),
		'StatusTransacao' => array('required','min:0','max:50'),
		'CliNome' => array('min:0','max:200'),
		'CliEmail' => array('required','min:0','max:200'),
		'CliEndereco' => array('min:0','max:200'),
		'CliNumero' => array('min:0','max:10'),
		'CliComplemento' => array('min:0','max:100'),
		'CliBairro' => array('min:0','max:100'),
		'CliCidade' => array('min:0','max:100'),
		'CliEstado' => array('min:2','max:3'),
		'CliCEP' => array('min:0','max:10'),
		'CliTelefone' => array('min:0','max:15'),
		'NumItens' => array('required','min:0','numeric'),
		'Data' => array('required','min:0'),
		'status' => array('required','min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('TransacaoID', 'VendedorEmail', 'Referencia', 'TipoFrete', 'ValorFrete', 'Extras', 'Anotacao', 'TipoPagamento', 'StatusTransacao', 'CliNome', 'CliEmail', 'CliEndereco', 'CliNumero', 'CliComplemento', 'CliBairro', 'CliCidade', 'CliEstado', 'CliCEP', 'CliTelefone', 'NumItens', 'Data', 'status');

    public function user()
    {
    	return $this->belongsTo('User', 'Anotacao', 'id');
    }

    public function shopdonationhistory()
    {
        return $this->belongsTo('ShopDonationHistory', 'TransacaoID', 'transacaoID');
    }

}