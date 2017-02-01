<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accounts';
  public $timestamps = false;

	/*Add your validation rules here*/
    public static $rules = array(
      'name' => array('unique:accounts','required','min:4','max:32'),
      'password' => array('required','min:6','max:20','alpha_dash'),
      'premdays' => array('min:0','numeric'),
      'lastday' => array('min:0','max:255','numeric'),
      'email' => array('unique:accounts','required','min:6','max:255','email'),
      'key' => array('min:5','max:255'),
      'blocked' => array('min:0','max:255','numeric'),
      'warnings' => array('min:0','max:255','numeric'),
      'group_id' => array('min:0','max:255','numeric'),
      'page_access' => array('min:0','max:255','numeric'),
      'page_lastday' => array('min:0','max:255','numeric'),
      'email_new' => array('min:0','max:255','email'),
      'email_new_time' => array('min:0','max:255','numeric','email'),
      'rlname' => array('min:0','max:255'),
      'location' => array('min:0','max:255'),
      'created' => array('min:0','max:255','numeric'),
      'email_code' => array('min:0','max:255'),
      'next_email' => array('min:0','max:255','numeric','email'),
      'premium_points' => array('min:0','numeric'),
      'premium_points_lost' => array('min:0','numeric'),
      'nickname' => array('min:3','max:48'),
      'avatar' => array('min:3','max:48'),
      'about_me' => array('min:0'),
      'viptime' => array('min:0','max:365')
      );

	// Don't forget to fill this array
    protected $fillable = array('name', 'password', 'premdays', 'lastday', 'email', 'key', 'email', 'blocked', 'warnings', 'group_id', 'page_access', 'page_lastday', 'email_new', 'email_new_time', 'rlname', 'location', 'created', 'email_code', 'next_email', 'premium_points', 'premium_points_lost', 'nickname', 'avatar', 'about_me', 'viptime');

    protected $guardad = array('id');
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    public function player()
    {
        return $this->belongsTo('Player', 'id', 'account_id');
    }

    public function userviplist()
    {
        return $this->belongsTo('UserVipList', 'id', 'account_id');
    }
    
    public function city()
    {
        return $this->belongsTo('City', 'id', 'account_id');
    }
    
    public function noticia()
    {
        return $this->belongsTo('Noticia', 'id');
    }

    public function categorianoticia()
    {
        return $this->belongsTo('CategoriaNoticia', 'id');
    }

    public function rate()
    {
        return $this->belongsTo('Rate', 'id');
    }

    public function shopdonationhistory()
    {
        return $this->belongsTo('ShopDonationHistory', 'id', 'account');
    }

    public function pagsegurotransacao()
    {
        return $this->belongsTo('PagseguroTransacao', 'id', 'Anotacao');
    }

    public function moiptransacao()
    {
        return $this->belongsTo('MoipTransacao', 'id', 'Anotacao');
    }

    public function paypaltransacao()
    {
        return $this->belongsTo('PaypalTransacao', 'id', 'Anotacao');
    }

    public function coupon()
    {
        return $this->belongsToMany('Coupon', 'accounts_has_coupons', 'accounts_id', 'coupons_id');
    }

    public function ban()
    {
        return $this->belongsTo('Ban', 'id', 'value');
    }

    public function registro()
    {
        return $this->belongsTo('Registro', 'id', 'account_id');
    }

    public function accountprivacy()
    {
        return $this->belongsTo('AccountPrivacy', 'id', 'account_id');
    }

    public function accountviplist()
    {
        return $this->belongsTo('AccountVipList', 'id', 'account_id');
    }

    public function accountreferal()
    {
        return $this->belongsTo('AccountReferal', 'id', 'referal_account_id');
    }

    public function referalaccount()
    {
        return $this->belongsTo('AccountReferal', 'id', 'account_id');
    }

    public function referencia(){
        return $this->belongsTo('Referencia', 'id', 'account_id');
    }
}
