<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class TruemoneyWithdrawal extends Model
{   
    protected $table = 'tbl_truemoney_withdrawals';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
     
}