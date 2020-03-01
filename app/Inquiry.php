<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_inquiry';

    public function property(){
        return $this->belongsTo('App\Property', 'property_id', 'id');
    }
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
