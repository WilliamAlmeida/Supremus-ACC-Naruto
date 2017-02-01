<?php

class PlayerStorage extends \Eloquent {

	protected $table = 'player_storage';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'player_id' => array('min:0','numeric'),
		'key' => array('min:0','numeric'),
		'value' => array('min:0')
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'key', 'value');

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}