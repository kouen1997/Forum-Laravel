<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_product_orders';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

    public function product(){
		 return $this->belongsTo('App\Product', 'product_id', 'id');
	}

}
