<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferMasterFund extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_transfer_master_fund';

	public function transfer_by(){
		 return $this->belongsTo('App\User', 'transfer_by_user_id', 'id');
	}
	public function transfer_to(){
		 return $this->belongsTo('App\User', 'transfer_to_user_id', 'id');
	}
}
