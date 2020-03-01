<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadTransfer extends Model
{

    protected $table = 'tbl_load_transfer';
	
	public function transfer_by(){
		 return $this->belongsTo('App\User', 'transfer_by_user_id', 'id');
	}
	public function transfer_to(){
		 return $this->belongsTo('App\User', 'transfer_to_user_id', 'id');
	}
	
}
