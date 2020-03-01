<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ForumViews extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_forum_views';
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
    
    public function user(){
         return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function forum(){
         return $this->belongsTo('App\Forum', 'forum_id', 'id');
    }

}
