<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketUserCategories extends Model
{

    protected $table = 'tbl_ticket_user_categories';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

	public function category(){
		 return $this->belongsTo('App\TicketCategories', 'category_id', 'id');
	}
	
}
