<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletEFund extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_wallet_efund';

    public function user(){
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
