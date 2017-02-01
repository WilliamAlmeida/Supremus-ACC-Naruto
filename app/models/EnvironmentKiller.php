<?php

class EnvironmentKiller extends \Eloquent {

	protected $table = 'environment_killers';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'kill_id' => array('min:0','numeric'),
		'name' => array('min:0'),
		);

	// Don't forget to fill this array
	protected $fillable = array('kill_id', 'name');

    public function killer()
    {
    	return $this->belongsTo('Killer', 'kill_id', 'id');
    }
}