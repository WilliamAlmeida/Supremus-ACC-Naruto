<?php

class Ban extends \Eloquent {

	protected $table = 'bans';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'type' => array('min:0','numeric'),
		'value' => array('min:0','numeric'),
		'param' => array('min:0','numeric'),
		'active' => array('min:1','numeric'),
		'expires' => array('required','date'),
		'added' => array('min:0','numeric'),
		'admin_id' => array('min:0','numeric'),
		'comment' => array('required','min:5'),
		'reason' => array('min:0','numeric'),
		'action' => array('min:0','numeric'),
		'statement' => array('min:0','max:255')
		);

	// Don't forget to fill this array
	protected $fillable = array('type', 'value', 'param', 'active', 'expires', 'added', 'admin_id', 'comment', 'reason', 'action', 'statement');

	protected $guardad = array('id');

    public function user()
    {
        return $this->belongsTo('User', 'value', 'id');
    }

    public function player()
    {
        return $this->belongsTo('Player', 'value', 'id');
    }

    public function admin()
    {
        return $this->belongsTo('User', 'admin_id', 'id');
    }

}