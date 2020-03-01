<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Property extends Model
{

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_properties';

    public function photos()
	{
        return $this->hasMany('App\Photos', 'property_id', 'id')->orderBy('id', 'ASC');
    }
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function inquiry()
	{
        return $this->hasMany('App\Inquiry', 'property_id', 'id')->orderBy('id', 'ASC');
    }

}
