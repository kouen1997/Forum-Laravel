<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class TriviaViews extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_trivia_views';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['name','username', 'email','password'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function trivia(){
         return $this->belongsTo('App\Trivia', 'trivia_id', 'id');
    }



}
