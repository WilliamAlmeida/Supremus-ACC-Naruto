<?php

class GuildRank extends \Eloquent {

	protected $table = 'guild_ranks';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'guild_id' => array('min:0','numeric'),
		'name' => array('unique:guild_ranks','required','min:0','max:255'),
		'level' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'guild_id');

    public function guild()
    {
        return $this->hasMany('Guild', 'guild_id', 'id');
    }
}