<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadWallet extends Model
{

    protected $table = 'tbl_load_wallet';
	
	public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
	
}
