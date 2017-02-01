<?php

class ShopOffer extends \Eloquent {

	protected $table = 'shop_offer';
	public $timestamps = false;
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = array(
		'points' => array('required','min:0','numeric'),
		'category' => array('required','min:1','numeric'),
		'type' => array('required','min:1','numeric'),
		'item' => array('required','min:0','numeric'),
		'count' => array('required','min:0','numeric'),
		'description' => array('required','min:10'),
		'name' => array('unique:shop_offer','required','min:0','max:255'),
		'destaque' => array('min:0','max:1','numeric'),
		'points_off' => array('min:0','numeric'),
		'stock' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('points', 'category', 'type', 'item', 'count', 'description', 'name', 'destaque', 'points_off', 'stock');

    protected $guardad = array('id');

	public function midiashopoffer()
	{
		return $this->belongsToMany('Midia', 'shop_offer_has_media', 'shop_offer_id', 'media_id');
	}

    public function shophistory()
    {
        return $this->belongsTo('ShopHistory', 'id', 'product');
    }
}