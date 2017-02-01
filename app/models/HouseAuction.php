<?php

class HouseAuction extends \Eloquent {

	protected $table = 'house_auctions';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'house_id' => array('min:0','numeric'),
		'world_id' => array('min:0','numeric'),
		'player_id' => array('min:0','numeric'),
		'bid' => array('min:0','numeric'),
		'limit' => array('min:0','numeric'),
		'endtime' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('house_id', 'world_id', 'player_id', 'bid', 'limit', 'endtime');

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }

    public function house()
    {
    	return $this->belongsTo('House', 'house_id', 'id');
    }
}