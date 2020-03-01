<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_watch_history';

    public function user(){
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
