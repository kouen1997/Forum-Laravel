<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_login_history';

    public function user(){
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
