<?php

class Registro extends \Eloquent {

	protected $table = 'logs';
	protected $primaryKey = 'id';
	public $timestamps = true;

	// Add your validation rules here
	public static $rules = array(
		'subject' => array('required','min:1','max:255'),
		'type' => array('required','min:1','max:255'),
		'ip' => array('required','min:0','numeric'),
		'text' => array('min:1'),
		'account_id' => array('min:0','numeric'),
		'player_id' => array('min:0','numeric')
	);

	// Don't forget to fill this array
	protected $fillable = array('subject', 'type', 'ip', 'text', 'account_id', 'player_id');
	
	protected $guardad = array('id');

    public function player()
    {
    	return $this->hasOne('Player', 'id', 'player_id');
    }

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }
}