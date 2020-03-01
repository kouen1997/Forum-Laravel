<?php

namespace App\Http\Controllers;

use App\RafflePoints;
use Validator;
use Input;
use Auth;
use URL;
use Hash;
use DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddAccountRequest;
use App\Http\Requests\TransferCodeRequest;
use App\Http\Requests\SettingRequest;
use App\Http\Requests\PinSettingRequest;
use App\Http\Requests\AddTutorialRequest;
use App\Http\Requests\AddWithdrawalRequest;
use App\Http\Requests\AddLoadwalletRequest;
use App\Http\Requests\AddAdsmoneyRequest;
use App\Http\Requests\ComposeMessageRequest;
use Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cache;
use BlueM;
use Yajra\Datatables\Datatables;
use App\User;
use App\PostingReward;


class TopController extends Controller
{
    protected $auth;
    
    use AuthenticatesUsers;
     
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     
  	public function __construct(Guard $auth)
    {   
        $this->auth = $auth;
     
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getTopIDG(){
		
  		$user = Auth::user()->member;
  		return  view('admin.top-idg')->with('user', $user);

	   }

     public function getTopIDGData(Request $request){
      if ($request->wantsJson()) {

        $top_idg = "";
        $users = [];
    
        $paysbooksocial_url = env("SOCIAL_MEDIA_URL", "https://paysbooksocial.co/api").'/top-idg';

        $ch = curl_init($paysbooksocial_url);
                curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ));

        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        if(isset($result) && $result->status == 'success') {
            
           $top_idg = $result->top_idg;

           foreach ($top_idg as $key => $value) {
              
            $user = User::with('member')->where('social_id',$value->user->id)->first();
            
            $data = [
                'user'   => $user,
                'total_idg'   => $value->total_idg
            ];
            
            array_push($users, $data);
              
          }
        }

        return Datatables::of($users)
          ->addColumn('member', function ($users) {
              if($users['user'] != NULL){
                return $users['user']->member->fname." ".$users['user']->member->lname;
              } else {
                return "NO SOCIAL ACCOUNT CONNECTED";
              }

            })
          ->addColumn('username', function ($users) {
              if($users['user'] != NULL){
                return $users['user']->member->username;
              } else {
                return "NO SOCIAL ACCOUNT CONNECTED";
              }

            })
          ->addIndexColumn()
          ->rawColumns(['member','username'])
          ->make(true);
        
      } else {
        return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again!'),422);
      }     
    }

     public function getTopTrending(){

      $user = Auth::user();
      return  view('admin.top-trending')->with('user', $user);
      
     }

     public function getTopTrendingData(Request $request){
      if ($request->wantsJson()) {

        $top_trendings = "";
        $users = [];
    
        $top_trendings = DB::table('tbl_trending_post')->get();

        if(count($top_trendings) > 0 ) {

           foreach ($top_trendings as $key => $value) {
              
            if(count($users) == 100){
              break;
            }
              
            $user = User::where('social_id',$value->user_id)->first();

            if($user) {

                $data = [
                    'user'   => $user,
                    'social_emal'   => $value->email,
                    //'description'   => $value->description,
                    'comments_count'   => $value->comments_count,
                    'users_liked_count'   => $value->users_liked_count,
                    'users_shared_count'   => $value->users_shared_count
                ];

     
                $reward = new PostingReward;
                $reward->user_id = $user->id;
                $reward->save();

                array_push($users, $data);


                

            }

          }

        }

        return Datatables::of($users)
          ->addColumn('member', function ($users) {
              if($users['user'] != NULL){
                return $users['user']->first_name." ".$users['user']->last_name;
              } else {
                return "NO SOCIAL ACCOUNT CONNECTED <br> (".$users['social_emal'].")";
              }

            })
          ->addColumn('username', function ($users) {
              if($users['user'] != NULL){
                return $users['user']->username;
              } else {
                return "NO SOCIAL ACCOUNT CONNECTED";
              }

            })
          ->addColumn('like_count', function ($users) {
             return $users['users_liked_count'];
            })
          ->addColumn('share_count', function ($users) {
              return $users['users_shared_count'];
            })
          ->addIndexColumn()
          ->rawColumns(['member','username','like_count','share_count'])
          ->make(true);
        
      } else {
        return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again!'),422);
      }     
    }
	
}	
