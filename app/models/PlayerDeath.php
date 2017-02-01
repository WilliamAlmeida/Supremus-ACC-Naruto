<?php

class PlayerDeath extends \Eloquent {

	protected $table = 'player_deaths';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'player_id' => array('min:0','numeric'),
		'date' => array('min:0','numeric'),
		'level' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'date', 'level');

    protected $guardad = array('id');

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}