<?php

class Player extends \Eloquent {

	protected $table = 'players';
	public $timestamps = false;

	// Add your validation rules here
	public static $rules = array(
		'name' => array('unique:players','required','min:4','max:255'),
		'world_id' => array('required','min:0','max:365','numeric'),
		'group_id' => array('min:0','max:365','numeric'),
		'account_id' => array('min:0','numeric'),
		'level' => array('min:1','numeric'),
		'vocation' => array('required','min:0','numeric'),
		'health' => array('min:150','numeric'),
		'healthmax' => array('min:150','numeric'),
		'experience' => array('min:0','numeric'),
		'lookbody' => array('min:0','numeric'),
		'lookfeet' => array('min:0','numeric'),
		'looklegs' => array('min:0','numeric'),
		'looktype' => array('min:136','numeric'),
		'lookaddons' => array('min:0','numeric'),
		'maglevel' => array('min:0','numeric'),
		'manamax' => array('min:0','numeric'),
		'manaspent' => array('min:0','numeric'),
		'soul' => array('min:0','numeric'),
		'town_id' => array('min:0','numeric'),
		'posx' => array('min:0','numeric'),
		'posy' => array('min:0','numeric'),
		'posz' => array('min:0','numeric'),
		'conditions' => array('min:0'),
		'cap' => array('min:0','numeric'),
		'sex' => array('required','min:0','numeric'),
		'lastlogin' => array('min:0'),
		'lastip' => array('min:0'),
		'save' => array('min:1','numeric'),
		'skull' => array('min:0','numeric'),
		'skulltime' => array('min:0','numeric'),
		'rank_id' => array('min:0','numeric'),
		'guildnick' => array('min:0','max:255'),
		'lastlogout' => array('min:0','numeric'),
		'blessings' => array('min:0','numeric'),
		'balance' => array('min:0','numeric'),
		'stamina' => array('min:1','numeric'),
		'direction' => array('min:0','numeric'),
		'loss_experience' => array('min:100','numeric'),
		'loss_mana' => array('min:100','numeric'),
		'loss_skills' => array('min:100','numeric'),
		'loss_containers' => array('min:100','numeric'),
		'loss_items' => array('min:100','numeric'),
		'premend' => array('min:0','numeric'),
		'online' => array('min:0','numeric'),
		'marriage' => array('min:0','numeric'),
		'promotion' => array('min:0','numeric'),
		'deleted' => array('min:0','numeric'),
		'description' => array('min:0','numeric'),
		'old_name' => array('min:0','max:255'),
		'hide_char' => array('min:0'),
		'worldtransfer' => array('min:0'),
		'created' => array('min:0'),
		'nick_verify' => array('min:0'),
		'comment' => array('min:0'),
        'debug' => array('min:0','numeric')
		);

	// Don't forget to fill this array
	protected $fillable = array('name', 'world_id', 'group_id', 'account_id', 'level', 'vocation', 'health', 'healthmax', 'experience', 'lookbody', 'lookfeet', 'lookhead', 'looklegs', 'looktype', 'lookaddons', 'maglevel', 'mana', 'manamax', 'manaspent', 'soul', 'town_id', 'posx', 'posy', 'posz', 'conditions', 'cap', 'sex', 'lastlogin', 'lastip', 'save', 'skull', 'skulltime', 'rank_id', 'guildnick', 'lastlogout', 'blessings', 'balance', 'stamina', 'direction', 'loss_experience', 'loss_mana', 'loss_skills', 'loss_containers', 'loss_items', 'premend', 'online', 'marriage', 'promotion', 'deleted', 'description', 'old_name', 'hide_char', 'worldtransfer', 'created', 'nick_verify', 'comment', 'debug');

	protected $guardad = array('id');

    public function user()
    {
    	return $this->hasOne('User', 'id', 'account_id');
    }

    public function playerskill()
    {
        return $this->belongsTo('PlayerSkill', 'id', 'player_id');
    }

    public function City()
    {
        return $this->belongsTo('City', 'town_id', 'town_id');
    }

    public function playerspell()
    {
        return $this->belongsTo('PlayerSpell', 'id', 'player_id');
    }

    public function playerstorage()
    {
        return $this->belongsTo('PlayerStorage', 'id', 'player_id');
    }

    public function shophistory()
    {
        return $this->belongsTo('ShopHistory', 'name', 'player');
    }

    public function playeritem()
    {
        return $this->belongsTo('PlayerItem', 'id', 'player_id');
    }

    public function playerdepotitem()
    {
        return $this->belongsTo('PlayerDepotitem', 'id', 'player_id');
    }

    public function playerdeath()
    {
        return $this->belongsTo('PlayerDeath', 'id', 'player_id');
    }

    public function playerkiller()
    {
        return $this->belongsTo('PlayerKiller', 'id', 'player_id');
    }

    public function guildinvite()
    {
        return $this->belongsTo('GuildInvite', 'id', 'player_id');
    }

    public function house()
    {
        return $this->belongsTo('House', 'id', 'owner');
    }

    public function houseauction()
    {
        return $this->belongsTo('HouseAuction', 'id', 'player_id');
    }

    public function serverreport()
    {
        return $this->belongsTo('ServerReport', 'id', 'player_id');
    }

    public function bugtracker()
    {
        return $this->belongsTo('BugTracker', 'id', 'author');
    }

    public function guild()
    {
        return $this->belongsTo('Guild', 'id', 'ownerid');
    }

    public function coupon()
    {
        return $this->belongsToMany('Coupon', 'players_has_coupons', 'players_id', 'coupons_id');
    }

    public function ban()
    {
        return $this->belongsTo('Ban', 'id', 'value');
    }

    public function registro()
    {
        return $this->belongsTo('Registro', 'id', 'player_id');
    }

}