<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $table = 'tbl_booking';

    protected $appends = ['extra_fee_sum'];

    public function getExtraFeeSumAttribute()
    {
    	return (int)$this->extra_fee()->sum('amount');
    }
      
	
	public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function extra_fee(){
         return $this->hasMany('App\BookingExtraFee', 'booking_id', 'id');
    }
	
}
