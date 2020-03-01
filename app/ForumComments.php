<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumComments extends Model
{

	 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_forum_comments';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}

    public function forum(){
         return $this->belongsTo('App\Forum', 'forum_id', 'id');
    }

    public function replies(){
         return $this->hasMany('App\ForumReplies', 'comment_id', 'id');
    }
	
}