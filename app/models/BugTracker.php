<?php

class BugTracker extends \Eloquent {

	protected $table = 'bugtracker';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'category' => array('min:0','numeric'),
		'time' => array('min:1','numeric'),
		'author' => array('min:0','numeric'),
		'text' => array('min:0'),
		'title' => array('min:0','max:120'),
		'done' => array('min:0','numeric'),
		'priority' => array('min:0','numeric'),
		'closed' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('category', 'time', 'author', 'text', 'title', 'done', 'priority', 'closed');

    protected $guardad = array('id');

	public function player()
	{
		return $this->belongsTo('Player', 'author', 'id');
	}
}