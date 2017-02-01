<?php

class Configuracao extends \Eloquent {

	protected $table = 'configuration';
	protected $primaryKey = 'id';

	// Add your validation rules here
	public static $rules = array(
		'title' => array('unique:configuration','required','max:63'),
		'description' => array('required','max:160'),
		'keywords' => array('required','max:200'),
		'email' => array('required','min:4','max:255','email'),
		'facebook' => array('min:4','url'),
		'twitter' => array('min:4','url'),
		'founded' => array('min:9','max:11'),
		'cost_points' => array('min:0','numeric'),
		'pagseguro_email' => array('min:0','max:255','email'),
		'pagseguro_token' => array('min:0','max:255'),
		'moip_email' => array('min:0','max:50','email'),
		'moip_key' => array('min:0','max:40'),
		'moip_token' => array('min:0','max:32'),
		'level' => array('required','min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('title', 'description', 'keywords', 'email', 'facebook', 'twitter', 'founded', 'cost_points', 'pagseguro_email', 'pagseguro_token', 'level');
	
	protected $guardad = array('id');

	public function midiaconfiguracao()
	{
		return $this->belongsToMany('Midia', 'configuration_has_media', 'configuration_id', 'media_id');
	}
}