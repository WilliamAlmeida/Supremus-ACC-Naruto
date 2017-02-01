<?php

class AccountReferal extends \Eloquent {

	protected $table = 'account_referal';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = [
		'account_id' => array('required','min:0','numeric'),
		'referal_account_id' => array('required','min:0','numeric'),
		'date' => array('min:0','numeric')
	];

	// Don't forget to fill this array
	protected $fillable = ['account_id', 'referal_account_id', 'date'];

    public function user()
    {
    	return $this->belongsTo('User', 'account_id', 'id');
    }

    public function referal()
    {
    	return $this->belongsTo('User', 'referal_account_id', 'id');
    }

}