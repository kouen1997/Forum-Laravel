<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YazzAccount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_yazz_account';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
