<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketComments extends Model
{

    protected $table = 'tbl_ticket_comments';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function ticket(){
		 return $this->belongsTo('App\Tickets', 'ticket_id', 'id');
	}
	
}
