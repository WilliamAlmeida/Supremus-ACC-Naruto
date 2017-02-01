<?php

class Noticia extends \Eloquent {

	protected $table = 'news';
	protected $primaryKey = 'id';
	/*public $timestamps = true;*/
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = array(
		'title' => array('unique:news','required','min:4','max:255'),
		'description' => array('required','min:4'),
		'tags' => array('max:200'),
		'meta_title' => array('unique:news','required','max:63'),
		'meta_description' => array('required','max:160'),
		'meta_keywords' => array('required','max:200'),
		'news_categories' => array('required')
	);

	// Don't forget to fill this array
	protected $fillable = array('title', 'slug', 'description', 'featured', 'tags', 'gallery', 'meta_title', 'meta_description', 'meta_keywords', 'account_id');
	
	protected $guardad = array('id');

    public function rate()
    {
        return $this->belongsToMany('Rate', 'news_has_rates', 'news_id', 'rates_id');
    }

    public function categorianoticia()
    {
        return $this->belongsToMany('CategoriaNoticia', 'news_has_news_categories', 'news_id', 'news_categories_id');
    }

	public function midianoticia()
	{
		return $this->belongsToMany('Midia', 'news_has_media', 'news_id', 'media_id');
	}

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }

}