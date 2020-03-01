<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketCategories extends Model
{

    protected $table = 'tbl_ticket_categories';

    public function tickets(){
         return $this->hasMany('App\Tickets', 'category_id', 'id');
    }
	
}
