<?php

class CategoriaNoticia extends \Eloquent {

	protected $table = 'news_categories';
	protected $primaryKey = 'id';
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	// Add your validation rules here
	public static $rules = [
		'name' => array('unique:news_categories','required','min:2','max:50'),
		'meta_title' => array('unique:news_categories','required','max:63'),
		'meta_description' => array('required','max:160'),
		'meta_keywords' => array('required','max:200')
	];

	// Don't forget to fill this array
	protected $fillable = ['name', 'slug', 'meta_title', 'meta_description', 'meta_keywords', 'account_id'];

	protected $guardad = array('id');

    public function noticia()
    {
        return $this->belongsToMany('Noticia', 'news_has_news_categories', 'news_categories_id', 'news_id');
    }

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }

}