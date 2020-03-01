<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{   
    protected $table = 'tbl_teams';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
     
}