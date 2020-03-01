<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumReplies extends Model
{

	 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_forum_replies';

    public function user(){
		 return $this->belongsTo('App\User', 'user_id', 'id');
	}
    public function forum(){
         return $this->belongsTo('App\Forum', 'forum_id', 'id');
    }
    public function comment(){
         return $this->belongsTo('App\ForumComments', 'comment_id', 'id');
    }
	
}