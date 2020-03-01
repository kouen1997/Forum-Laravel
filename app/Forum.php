<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Forum extends Model
{
    use Sluggable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_forum';
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
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function forum(){
         return $this->belongsTo('App\Forum', 'user_id', 'id');
    }

    public function user(){
         return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function category(){
         return $this->belongsTo('App\ForumCategory', 'category_id', 'id');
    }

    public function comments(){
         return $this->hasMany('App\ForumComments', 'forum_id', 'id');
    }

    public function views(){
         return $this->hasMany('App\ForumViews', 'forum_id', 'id');
    }



}
