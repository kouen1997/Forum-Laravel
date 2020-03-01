<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_accounts';

	public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function placement(){
		 return $this->belongsTo('App\Account', 'parent_id', 'id');
	}

	public function wallet(){
		 return $this->hasMany('App\Wallet', 'account_id', 'id');
	}

	public function pairing_bonus(){
		 return $this->hasMany('App\PairingBonus', 'account_id', 'id')->where('status',1);
	}

	public function leveling_bonus(){
		 return $this->hasMany('App\LevelingBonus', 'account_id', 'id')->where('status',1);
	}
}
