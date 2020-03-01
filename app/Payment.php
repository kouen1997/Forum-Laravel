<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_payment';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
