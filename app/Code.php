<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_codes';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function account(){
		 return $this->belongsTo('App\Account', 'code', 'activation_code');
	}
}
