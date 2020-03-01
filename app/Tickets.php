<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{

    protected $table = 'tbl_tickets';
	
	public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function agent(){
		 return $this->belongsTo('App\User', 'agent_id', 'id');
	}

	public function category(){
		 return $this->belongsTo('App\TicketCategories', 'category_id', 'id');
	}

	public function comments(){
         return $this->hasMany('App\TicketComments', 'ticket_id', 'id');
    }
	
}
