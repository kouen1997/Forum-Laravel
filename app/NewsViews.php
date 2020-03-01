<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class NewsViews extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_news_views';
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

    public function news(){
         return $this->belongsTo('App\News', 'news_id', 'id');
    }



}
