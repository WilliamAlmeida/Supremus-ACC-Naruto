<?php

class Killer extends \Eloquent {

	protected $table = 'killers';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'death_id' => array('min:0','numeric'),
		'final_hit' => array('min:0'),
		'unjustified' => array('min:0')
		);

	// Don't forget to fill this array
	protected $fillable = array('death_id', 'final_hit', 'unjustified');

    protected $guardad = array('id');

    public function environmentkiller()
    {
    	return $this->belongsTo('EnvironmentKiller', 'id', 'kill_id');
    }

    public function playerdeath()
    {
    	return $this->belongsTo('PlayerDeath', 'death_id', 'id');
    }
}