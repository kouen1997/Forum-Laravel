<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadLog extends Model
{

    protected $table = 'tbl_load_logs';
	
	public function user(){
		 return $this->belongsTo('App\User', 'user', 'id');
	}
	
}
