<?php

class Midia extends \Eloquent {

	protected $table = 'medias';
	protected $primaryKey = 'id';

	// Add your validation rules here
	public static $rules = [
		'path' => array('unique:medias','required'),
		'name' => array('required','min:1','max:255'),
		'type' => array('required','min:1','max:255')
	];

	// Don't forget to fill this array
	protected $fillable = ['path', 'name', 'type'];

	protected $guardad = ['id'];

	public function noticia()
	{
		return $this->belongsToMany('Midia', 'news_has_media', 'media_id', 'news_id');
	}

	public function pagina()
	{
		return $this->belongsToMany('Midia', 'pages_has_media', 'media_id', 'pages_id');
	}

	public function shopoffer()
	{
		return $this->belongsToMany('ShopOffer', 'shop_offer_has_media', 'media_id', 'shop_offer_id');
	}

	public function configuracao()
	{
		return $this->belongsToMany('Midia', 'configuration_has_media', 'media_id', 'configuration_id');
	}
}