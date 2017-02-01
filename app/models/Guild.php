<?php

class Guild extends \Eloquent {

	protected $table = 'guilds';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'world_id' => array('required','min:0','numeric'),
		'name' => array('unique:guilds','min:0','max:255'),
		'ownerid' => array('min:0','numeric'),
		'creationdata' => array('min:0','numeric'),
		'motd' => array('min:0')
		);

	// Don't forget to fill this array
	protected $fillable = array('world_id', 'name', 'ownerid', 'creationdata', 'motd');

	protected $guardad = array('id');

    public function player()
    {
        return $this->belongsTo('Player', 'id', 'player_id');
    }

    public function guildrank()
    {
        return $this->belongsTo('GuildRank', 'id', 'guild_id');
    }
}