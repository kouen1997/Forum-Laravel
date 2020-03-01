<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\User;
use App\News;
use App\Property;
use App\Photos;
use App\WatchHistory;

class HomeController extends Controller
{

    
    public function getHome(Request $request) {

        if($request->has('ref')){

            return redirect('/register?ref='.$request->ref);

        } else {

            $user = Auth::user();
            
            $properties = Property::with('photos','user')->orderBy('created_at', 'DESC')->get();

            $newss = News::latest()->take(4)->get();

            $featured_properties = Property::with('photos','user')->where('is_featured', 1)->orderBy('created_at', 'DESC')->get();

            return view('home.index')->with('user',$user)->with('properties',$properties)->with('featured_properties',$featured_properties)->with('newss', $newss);

        }

    }

    public function getAddListingProperties() {

        if(!Auth::guest()){

            return redirect('/profile/property/add');

        } else {

            return redirect('/login');
    
        }

    }

    public function home(Request $request)
    {
        if($request->has('r')){

            return redirect('/register?r='.$request->r);

        } else {

            return view('landing');

        }
       	
    }

    public function postShareLinkRewards(Request $request){

        if($request->wantsJson()) {

            try {

                $user = Auth::user();
                
                $watch_count = WatchHistory::where('user_id', $user->id)->count();

                if($user->active == 1) {

                    $accounts_count = $user->account()->count();

                    if($accounts_count == 1) {

                        if($watch_count < 150 ){
                            
                            $watch = new WatchHistory;
                            $watch->user_id = $user->id;
                            $watch->amount = 10;
                            $watch->save();
                            return response()->json(array("result"=>true,"message"=>'Success.'),200);

                        }

                    } elseif($accounts_count == 7) {

                        if($watch_count < 15 ){
                            
                            $watch = new WatchHistory;
                            $watch->user_id = $user->id;
                            $watch->amount = 150;
                            $watch->save();
                            return response()->json(array("result"=>true,"message"=>'Success.'),200);

                        }

                    } else {

                        return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
                    }
                }

            } catch(\Exception $e) {

                return response()->json(array("result"=>false,"message"=>$e->getMessage()),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getTAC(){

        return view('terms-and-conditions');
    }

    public function getVision(){

        return view('vision');
    }

    public function getMission(){

        return view('mission');
    }
}
