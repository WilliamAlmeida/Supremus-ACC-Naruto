<?php

class Coupon extends \Eloquent {

	protected $table = 'coupons';
	protected $primaryKey = 'id';
	/*public $timestamps = true;*/
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = array(
		'name' => array('required','min:1','max:255'),
		'code' => array('unique:coupons','required','min:1','max:255'),
		'type' => array('required','min:0','numeric'),
		'validate' => array('required','date','after:date'),
		'item' => array('min:0','numeric'),
		'count' => array('required','min:1','numeric'),
		'limit' => array('required','min:0','numeric'),
		'account_id' => array('min:0','numeric')
	);

	// Don't forget to fill this array
	protected $fillable = array('name', 'code', 'type', 'validate', 'item', 'count', 'limit', 'account_id');
	
	protected $guardad = array('id');

    public function player()
    {
        return $this->belongsToMany('Player', 'players_has_coupons', 'coupons_id', 'players_id');
    }

    public function users()
    {
    	return $this->belongsToMany('User', 'accounts_has_coupons', 'coupons_id', 'accounts_id');
    }

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }
}