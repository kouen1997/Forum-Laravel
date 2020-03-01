<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyCode extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_buy_code';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
