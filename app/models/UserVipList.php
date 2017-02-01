<?php

class UserVipList extends \Eloquent {

	protected $table = 'account_viplist';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'account_id' => array('min:0','numeric'),
		'world_id' => array('min:0','numeric'),
		'player_id' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('account_id', 'world_id', 'player_id');

    public function user()
    {
    	return $this->belongsTo('User', 'account_id', 'id');
    }
}