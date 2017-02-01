<?php

class Referencia extends \Eloquent {

	protected $table = 'referals';

	// Add your validation rules here
	public static $rules = [
		'account_id' => array('required','min:0','numeric'),
		'name' => array('required','min:0','max:255'),
		'status' => array('required','min:0','numeric')
	];

	// Don't forget to fill this array
	protected $fillable = ['account_id', 'name', 'status'];

    public function user()
    {
    	return $this->belongsTo('User', 'account_id', 'id');
    }

}