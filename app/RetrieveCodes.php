<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetrieveCodes extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_retrieve_codes';

	public function retrieve_by(){
		 return $this->belongsTo('App\User', 'retrieve_by_user_id', 'id');
	}
	public function retrieve_from(){
		 return $this->belongsTo('App\User', 'retrieve_from_user_id', 'id');
	}
}
