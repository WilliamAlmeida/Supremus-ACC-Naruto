<?php

class ShopHistory extends \Eloquent {

	protected $table = 'shop_history';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'product' => array('required','min:0','numeric'),
		'session' => array('required','min:0','max:255'),
		'from' => array('required','min:0'),
		'player' => array('required','min:0'),
		'date' => array('required','min:0','numeric'),
		'processed' => array('required','min:0','numeric'),
		'points' => array('required','min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('product', 'session', 'from', 'player', 'date', 'processed', 'points');

    protected $guardad = array('id');

    public function player()
    {
        return $this->belongsTo('Player', 'player', 'name');
    }

    public function shopoffer()
    {
        return $this->belongsTo('ShopOffer', 'product', 'id');
    }
}