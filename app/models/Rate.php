<?php

class Rate extends \Eloquent {

	protected $table = 'rates';
	protected $primaryKey = 'id';

	// Add your validation rules here
	public static $rules = array(
		'rate' => array('required','min:1','max:5','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('rate');
	
	protected $guardad = array('id', 'account_id');

	public function noticia()
	{
		return $this->belongsToMany('Noticia', 'news_has_rates', 'rates_id', 'news_id');
	}

	public function produto()
	{
		return $this->belongsToMany('Produto', 'products_has_rates', 'rates_id', 'products_id');
	}

	public function user()
	{
		return $this->hasOne('User', 'id', 'account_id');
	}

}