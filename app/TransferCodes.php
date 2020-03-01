<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferCodes extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_transfer_codes';

	public function transfer_by(){
		 return $this->belongsTo('App\User', 'transfer_by_user_id', 'id');
	}
	public function transfer_to(){
		 return $this->belongsTo('App\User', 'transfer_to_user_id', 'id');
	}
}
