<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeRequest extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_code_requests';

    public function user(){
		 return $this->belongsTo('App\User', 'requested_by_user_id', 'id');
	}
}
