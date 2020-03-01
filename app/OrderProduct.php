<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_order_products';

    public function order(){
		 return $this->belongsTo('App\Order', 'order_id', 'id');
	}

    public function product(){
		 return $this->belongsTo('App\Product', 'product_id', 'id');
	}

}
