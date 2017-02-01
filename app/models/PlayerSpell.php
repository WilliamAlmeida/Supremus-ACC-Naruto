<?php

class PlayerSpell extends \Eloquent {

	protected $table = 'player_spells';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'player_id' => array('min:0','numeric'),
		'name' => array('min:0','max:255')
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'name');

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}