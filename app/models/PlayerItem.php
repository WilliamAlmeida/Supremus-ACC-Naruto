<?php

class PlayerItem extends \Eloquent {

	protected $table = 'player_items';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'player_id' => array('require','min:0','numeric'),
		'pid' => array('min:0','numeric'),
		'sid' => array('min:0','numeric'),
		'itemtype' => array('require','min:0','numeric'),
		'count' => array('min:0','numeric')
		/*'attributes' => array('')*/
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'pid', 'sid', 'itemtype', 'count', 'attributes');

    public function player()
    {
    	return $this->belongsTo('Player', 'player_id', 'id');
    }
}