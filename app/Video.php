<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class VideoTutorial extends Model
{
    use Sluggable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_video_tutorials';
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

}
