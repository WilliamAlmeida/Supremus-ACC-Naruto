<?php

class Pagina extends \Eloquent {

	protected $table = 'pages';
	protected $primaryKey = 'id';
	/*public $timestamps = true;*/
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = array(
		'title' => array('required','min:4','max:255'),
		'slug' => array('unique:pages','min:4','max:255'),
		'body' => array('required','min:4'),
		'meta_title' => array('unique:pages','required','max:63'),
		'meta_description' => array('required','max:160'),
		'meta_keywords' => array('required','max:200')
	);

	// Don't forget to fill this array
	protected $fillable = array('title', 'slug', 'body', 'gallery', 'meta_title', 'meta_description', 'meta_keywords', 'account_id');
	
	protected $guardad = array('id');

	public function midiapagina()
	{
		return $this->belongsToMany('Midia', 'pages_has_media', 'pages_id', 'media_id');
	}

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }
}