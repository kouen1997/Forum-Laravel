<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{   
    protected $table = 'tbl_withdrawals';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
     
}