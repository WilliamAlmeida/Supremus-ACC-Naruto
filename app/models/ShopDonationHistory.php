<?php

class ShopDonationHistory extends \Eloquent {

	protected $table = 'shop_donation_history';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'method' => array('required','min:0','max:255'),
		'receiver' => array('required','min:0','max:255'),
		'buyer' => array('required','min:0','max:255'),
		'account' => array('required','min:0','numeric'),
		'points' => array('required','min:0','numeric'),
		'date' => array('min:0','numeric'),
		'transacaoID' => array('min:0','max:255')
		);

	// Don't forget to fill this array
	protected $fillable = array('method', 'receiver', 'buyer', 'account', 'points', 'date', 'transacaoID');

    public function user()
    {
    	return $this->belongsTo('User', 'account', 'id');
    }

    public function pagsegurotransacao()
    {
    	return $this->belongsTo('PagseguroTransacao', 'transacaoID', 'TransacaoID');
    }

    public function moiptransacao()
    {
    	return $this->belongsTo('MoipTransacao', 'transacaoID', 'TransacaoID');
    }

    public function paypaltransacao()
    {
    	return $this->belongsTo('PaypalTransacao', 'transacaoID', 'TransacaoID');
    }

}