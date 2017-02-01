<?php

class AccountPrivacy extends \Eloquent {

	protected $table = 'account_privacy';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'account_id' => array('min:0','numeric'),
		'digimon' => array('required','min:0','numeric'),
		'email' => array('required','min:0','numeric'),
		'merit_points' => array('required','min:0','numeric'),
		'task' => array('required','min:0','numeric'),
		'digimon_killed' => array('required','min:0','numeric'),
		'digimon_analyzer' => array('required','min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('digimon', 'email', 'merit_points', 'task', 'digimon_killed', 'digimon_analyzer', 'account_id');

    public function user()
    {
    	return $this->belongsTo('User', 'account_id', 'id');
    }
}