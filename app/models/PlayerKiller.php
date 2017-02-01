<?php

class PlayerKiller extends \Eloquent {

	protected $table = 'player_killers';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'kill_id' => array('min:0','numeric'),
		'player_id' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('kill_id', 'player_id');

    protected $guardad = array('id');

    public function killer()
    {
    	return $this->belongsTo('Killer', 'kill_id', 'id');
    }

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}