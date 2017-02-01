<?php

class City extends \Eloquent {

	protected $table = 'cities';
	protected $primaryKey = 'id';
	/*public $timestamps = true;*/
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = array(
		'name' => array('unique:cities','required','min:1','max:255'),
		'town_id' => array('required','min:0','numeric'),
		'posx' => array('required','min:0','numeric'),
		'posy' => array('required','min:0','numeric'),
		'posz' => array('required','min:0','numeric'),
		'account_id' => array('min:0','numeric')
	);

	// Don't forget to fill this array
	protected $fillable = array('name', 'town_id', 'posx', 'posx', 'posy', 'posz', 'account_id');
	
	protected $guardad = array('id');

    public function player()
    {
        return $this->belongTo('Player', 'town_id', 'town_id');
    }

    public function house()
    {
        return $this->belongTo('House', 'town_id', 'town');
    }

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }
}