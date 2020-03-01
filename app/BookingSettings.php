<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingSettings extends Model
{

    protected $table = 'tbl_booking_settings';
	
	public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
	
}
