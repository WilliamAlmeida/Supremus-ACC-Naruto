<?php

class ServerReport extends \Eloquent {

	protected $table = 'server_reports';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'world_id' => array('min:0','numeric'),
		'player_id' => array('min:1','numeric'),
		'posx' => array('min:0','numeric'),
		'posy' => array('min:0','numeric'),
		'posz' => array('min:0','numeric'),
		'timestamp' => array('min:0','numeric'),
		'report' => array('min:0'),
		'reads' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('world_id', 'player_id', 'posx', 'posy', 'posz', 'timestamp', 'report', 'reads');

    protected $guardad = array('id');

    public function player()
    {
        return $this->belongsTo('Player', 'player_id', 'id');
    }

}