<?php

class House extends \Eloquent {

	protected $table = 'houses';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'world_id' => array('required','min:0','numeric'),
		'owner' => array('min:0','numeric'),
		'paid' => array('min:0','numeric'),
		'warning' => array('min:1','numeric'),
		'lastwarning' => array('min:0','numeric'),
		'name' => array('required','min:0','max:255'),
		'town' => array('required','min:0','numeric'),
		'size' => array('min:0','numeric'),
		'price' => array('required','min:0','numeric'),
		'rent' => array('min:0','numeric'),
		'doors' => array('min:0','numeric'),
		'beds' => array('min:0','numeric'),
		'tiles' => array('min:0','numeric'),
		'guild' => array('min:0','numeric'),
		'clear' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('world_id', 'owner', 'paid', 'warnings', 'lastwarning', 'name', 'town', 'size', 'price', 'rent', 'doors', 'beds', 'tiles', 'guild', 'clear');

	protected $guardad = array('id');

    public function player()
    {
    	return $this->belongsTo('Player', 'owner', 'id');
    }

    public function city()
    {
    	return $this->belongsTo('City', 'town', 'town_id');
    }

    public function houseauction()
    {
    	return $this->belongsTo('HouseAuction', 'id', 'house_id');
    }
}