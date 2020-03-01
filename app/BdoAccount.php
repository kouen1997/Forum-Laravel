<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BdoAccount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_bdo_account';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
