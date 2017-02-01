<?php

class GuildInvite extends \Eloquent {

	protected $table = 'guild_invites';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'player_id' => array('min:0','numeric'),
		'guild_id' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('player_id', 'guild_id');

    public function player()
    {
        return $this->hasMany('Player', 'player_id', 'id');
    }

    public function guild()
    {
        return $this->belongsTo('Guild', 'guild_id', 'id');
    }
}