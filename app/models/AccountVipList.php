<?php

class AccountVipList extends \Eloquent {

	protected $table = 'account_viplist';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'account_id' => array('required','min:0','numeric'),
		'player_id' => array('required','min:0','numeric'),
		'description' => array('required','min:0','max:128'),
		'icon' => array('required','min:0','numeric'),
		'notify' => array('required','min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('description', 'icon', 'notify', 'player_id', 'account_id');

    public function user()
    {
    	return $this->belongsTo('User', 'account_id', 'id');
    }

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}