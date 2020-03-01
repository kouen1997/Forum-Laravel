<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Crypt;
use Input;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\VideoTutorial;

class VideoTutorialController extends Controller
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

    public function getVideoTutorial()
    {
        try{

            $user = Auth::user();

            if($user){

                $videos = VideoTutorial::latest()->paginate(20);

                return view('video_tutorial.video_tutorial', compact('videos'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getViewVideoTutorial($slug)
    {
        try{

            $user = Auth::user();

            if($user){

                $video = VideoTutorial::where('slug', $slug)->first();

                if($video){

                    return view('video_tutorial.view_video_tutorial', compact('video'));

                }else{

                    return abort(404);
                    
                }

            }

        } catch(\Exception $e) {

           return abort(404);
            
        }
    }
	public function getVideoTutorialList()
    {
        try{

            $user = Auth::user();

            if($user){

                $videos = VideoTutorial::latest()->paginate(20);

                return view('video_tutorial.video_tutorial_listing', compact('videos'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getAddVideoTutorial()
    {
        try{

            $user = Auth::user();

            if($user){

                return view('video_tutorial.add_video_tutorial');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postAddVideoTutorial(Request $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $video_link = '';

                $youtube_regexp = "~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/) ([^&]{11})~x";

                $url = $request->link;

                $has_match = preg_match($youtube_regexp, $url, $matches);

                if($has_match) {

                    if (sizeof($matches) == 2) {

                        $video_link =  $matches[1];

                        $video = new VideoTutorial;
                        $video->title = $request->title;
                        $video->content = $request->content;
                        $video->video_link = $video_link;
                        $video->save();

                        return redirect('/video/tutorial/list');
                    }

                } else {

                    Session::flash('failed', 'Invalid Link');
                    return back();
                }

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getEditVideoTutorial($id)
    {
        try{

            $user = Auth::user();

            if($user){

                $video = VideoTutorial::where('id', Crypt::decrypt($id))->first();

                return view('video_tutorial.edit_video_tutorial', compact('video'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postEditVideoTutorial(Request $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $video_link = '';

                $youtube_regexp = "~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/) ([^&]{11})~x";

                $url = $request->link;

                $has_match = preg_match($youtube_regexp, $url, $matches);

                if($has_match) {

                    if (sizeof($matches) == 2) {

                        $video_link =  $matches[1];

                        $video = VideoTutorial::where('id', $request->id)->first();
                        $video->title = $request->title;
                        $video->content = $request->content;
                        $video->video_link = $video_link;
                        $video->save();

                        return redirect('/video/tutorial/list');
                    }

                } else {

                    Session::flash('failed', 'Invalid Link');
                    return back();
                }

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postDeleteVideoTutorial($video_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $video = VideoTutorial::find($video_id);
                $video->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
}