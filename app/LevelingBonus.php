<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class LevelingBonus extends Model
{   
    protected $table = 'tbl_leveling_bonus';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function account(){
		 return $this->belongsTo('App\Account', 'account_id', 'id');
	}
     
}