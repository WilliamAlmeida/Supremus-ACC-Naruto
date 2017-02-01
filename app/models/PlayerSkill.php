<?php

class PlayerSkill extends \Eloquent {

	protected $table = 'player_skills';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'player_id' => array('min:0','numeric'),
		'skillid' => array('min:0','numeric'),
		'value' => array('min:0','numeric'),
		'count' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'skillid', 'value', 'count');

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}