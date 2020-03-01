<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingReward extends Model
{

    protected $table = 'tbl_booking_reward';
	
	public function user(){
		 return $this->belongsTo('App\User', 'user', 'id');
	}
	
}
