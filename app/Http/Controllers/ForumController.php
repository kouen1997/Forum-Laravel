<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Forum;
use App\ForumViews;
use App\ForumComments;
use App\ForumReplies;
use App\ForumCategory;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Forum\AddForumRequest;
use App\Http\Requests\Forum\EditForumRequest;

class ForumController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function getForum()
    {

        try{

            $user = Auth::user();

            if($user){

                $forums = Forum::with('category')->latest()->paginate(20);

                $userForums = Forum::where('user_id', Auth::user()->id)->latest()->get();

                $categories = ForumCategory::all();

                $mostViewed = ForumViews::select('forum_id')
                                    ->groupBy('forum_id')
                                    ->orderBy(DB::raw('count(forum_id)'), 'DESC')
                                    ->take(10)
                                    ->get();

                $mostDiscuss = ForumComments::select('forum_id')
                                    ->groupBy('forum_id')
                                    ->orderBy(DB::raw('count(forum_id)'), 'DESC')
                                    ->take(10)
                                    ->get();

                return view('forum.forum', compact('forums','mostViewed','mostDiscuss','userForums','categories'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function getViewForum($slug)
    {
        try{

            $user = Auth::user();

            if($user){

                $forum = Forum::where('slug', $slug)->first();
                $comments = ForumComments::where('forum_id', $forum->id)->latest()->get();
                $views = ForumViews::where('user_id', $user->id)->where('forum_id', $forum->id)->first();
                $lastests = Forum::with('category')->latest()->paginate(20);

                if($forum){

                    if(!$views){

                        $view = new ForumViews;
                        $view->user_id = $user->id;
                        $view->forum_id = $forum->id;
                        $view->save();

                    }

                    return view('forum.view_forum', compact('forum','comments','lastests'));

                }else{

                    return abort(404);
                    
                }

            }

        } catch(\Exception $e) {

           return abort(404);
            
        }
    }
    public function getWriteForum()
    {
        try{

            $user = Auth::user();

            if($user){

                $categories = ForumCategory::all();
                return view('forum.create_forum', compact('categories'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postForum(AddForumRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $uniqueTitle = Forum::where('title', $request->title)->count();

                $forum_validation = Forum::where('user_id', $user->id)->whereDay('created_at', Carbon::now()->format('d'))->count(); 

                if ($forum_validation > 4) {

                    Session::flash('failed', 'you can only post 5 forums per day');
                    return back();

                }else{

                    $forum = new Forum;
                    $forum->user_id = $user->id;
                    $forum->title = $request->title;
                    $forum->category_id = $request->category;
                    $forum->content = $request->content;
                    $forum->save();

                    return redirect('/forum/view/'.$forum->slug);
                }

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postForumComment(Request $request, $forum_id)
    {
        try{
            
            if($request->wantsJson()) {

                $user = Auth::user();
                $forum = Forum::find($forum_id);

                if($user){

                    if($forum){

                        $last_comment = ForumComments::where('user_id', $user->id)->where('forum_id', $forum->id)->whereBetween('created_at', [Carbon::now()->subMinutes(5), Carbon::now()])->count(); 

                        if ($last_comment > 0) {

                            return response()->json(['status' => 'error', 'message' => 'One comment per 5 minutes only.']);

                        }else{
                         
                            $comment = new ForumComments;
                            $comment->user_id = $user->id;
                            $comment->forum_id = $forum_id;
                            $comment->content =  $request->comment;
                            $comment->save();

                            $postHtml = view('forum.comments', compact('comment', 'forum'))->render();

                            return response()->json(['status' => 'success', 'data' => $postHtml]);
                        }

                    }else{

                        return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again!'],422);

                    }
                }

            } else {

                return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again!'],422);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function postForumReply(Request $request, $forum_id, $comment_id)
    {
        try{
            
            if($request->wantsJson()) {

                $user = Auth::user();
                $forum = Forum::find($forum_id);
                $comment = ForumComments::find($comment_id);

                if($user){

                    if($forum){

                        if($comment){

                            $last_comment = ForumReplies::where('user_id', $user->id)->where('forum_id', $forum->id)->where('comment_id', $comment_id)->whereBetween('created_at', [Carbon::now()->subMinutes(5), Carbon::now()])->count(); 

                            if ($last_comment > 0) {

                                return response()->json(['status' => 'error', 'message' => 'One reply per 5 minutes only.']);

                            }else{
                             
                                $reply = new ForumReplies;
                                $reply->user_id = $user->id;
                                $reply->forum_id = $forum_id;
                                $reply->comment_id = $comment_id;
                                $reply->content =  $request->reply;
                                $reply->save();

                                $postHtml = view('forum.replies', compact('reply','comment', 'forum'))->render();

                                return response()->json(['status' => 'success', 'data' => $postHtml]);
                            }

                        }else{

                            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again!'],422);

                        }

                    }else{

                        return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again!'],422);

                    }
                }

            } else {

                return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again!'],422);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function getForumSearch(Request $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $search = Input::get('search');

                if(!empty($search)){

                    $forums = Forum::where('title', 'LIKE', '%'.$search.'%')->orWhere('content', 'LIKE', '%'.$search.'%')->latest()->paginate(20)->setPath('');

                    $forums->appends( array (
                        'search' => Input::get('search') 
                    ));

                    $categories = ForumCategory::all();

                    $userForums = Forum::where('user_id', Auth::user()->id)->get();

                    $mostViewed = ForumViews::select('forum_id')
                                            ->groupBy('forum_id')
                                            ->orderBy(DB::raw('count(forum_id)'), 'DESC')
                                            ->take(10)
                                            ->get();

                    $mostDiscuss = ForumComments::select('forum_id')
                                            ->groupBy('forum_id')
                                            ->orderBy(DB::raw('count(forum_id)'), 'DESC')
                                            ->take(10)
                                            ->get();

                    return view('forum.forum', compact('forums','mostViewed','mostDiscuss','userForums','categories'));

                }


            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getForumCategory($category)
    {
        try{

            $user = Auth::user();

            if($user){

                if($category == "all"){

                    $forums = Forum::latest()->paginate(20);

                    if(!empty(Input::get('search'))){

                        $forums->appends( array (
                            'search' => Input::get('search'),
                            'category' => $category
                        )); 
                        
                    }

                }else{

                    $category = ForumCategory::where('slug', $category)->first();

                    $forums = Forum::where('category_id', $category->id)->latest()->paginate(20);

                    if(!empty(Input::get('search'))){

                        $forums->appends( array (
                            'search' => Input::get('search'),
                            'category' => $category
                        )); 

                    }

                }

                $userForums = Forum::where('user_id', Auth::user()->id)->latest()->get();

                $categories = ForumCategory::all();

                $mostViewed = ForumViews::select('forum_id')
                                    ->groupBy('forum_id')
                                    ->orderBy(DB::raw('count(forum_id)'), 'DESC')
                                    ->take(10)
                                    ->get();

                $mostDiscuss = ForumComments::select('forum_id')
                                    ->groupBy('forum_id')
                                    ->orderBy(DB::raw('count(forum_id)'), 'DESC')
                                    ->take(10)
                                    ->get();

                return view('forum.forum', compact('forums','mostViewed','mostDiscuss','userForums','categories'));

            }


        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getEditForum($slug)
    {
        try{

            $user = Auth::user();

            if($user){

                $forum = Forum::where('slug', $slug)->first();
                $categories = ForumCategory::all();


                if($user->id == $forum->user_id){
                    return view('forum.edit_forum', compact('categories','forum'));
                }else{
                    return redirect()->back();
                }
                



            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function postEditForum(EditForumRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $forum = Forum::where('id', $request->forum_id)->first();
                $forum->user_id = $user->id;
                $forum->title = $request->title;
                $forum->category_id = $request->category;
                $forum->content = $request->content;
                $forum->save();

                return redirect('/forum/view/'.$forum->slug);
                

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postDeleteForum($forum_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $forum = Forum::find($forum_id);
                $forum->delete();

                return redirect('/forum');
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
}
