<?php

class ServerRecord extends \Eloquent {

	protected $table = 'server_record';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'record' => array('min:0','numeric'),
		'world_id' => array('min:0','numeric'),
		'timestamp' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('record', 'world_id', 'timestamp');
}