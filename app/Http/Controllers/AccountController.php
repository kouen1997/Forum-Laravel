<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Requests\Account\UpdateProfilePasswordRequest;
use App\Http\Requests\Account\UpdateProfilePinRequest;
use App\Http\Requests\Account\UpdateProfileTinRequest;
use App\Http\Requests\Account\SocialConnectRequest;
use App\Http\Requests\Account\MarketplaceConnectRequest;
use App\Http\Requests\Account\AddAccountRequest;
use App\Http\Requests\Account\TransferCodesRequest;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\User;
use App\WatchHistory;
use App\Account;
use App\Wallet;
use App\WalletMove;
use App\Genealogy;
use App\PairingBonus;
use App\LevelingBonus;
use App\Points;
use App\Code;
use App\TransferCodes;
use App\Settings;
use App\Voucher;
use App\Team;
use App\Property;
use App\Forum;
use Hash;
use DB;
use PDF;

class AccountController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('member',['except' => ['getMemberImg']]);
    }

    public function getDashboard(){

        $user = Auth::user();

        $forums = Forum::latest()->take(3)->get();

        $recent_property = Property::with('photos','user')->where('offer_type', 'Sell')->orderBy('created_at', 'DESC')->first();
        
        return view('dashboard.index')
            ->with('user',$user)
            ->with('recent_property',$recent_property)
            ->with('forums', $forums);       
    }

    public function getAccount(){

        $user = Auth::user();
        $ecomnnect_wallet = getTotalPoints($user->id);
        $ads_profit = getSettings('ads_profit');
        $total_ad_points = $user->paid_account()->count() * 1500;
        $total_premium_ads = $user->premium_ads()->sum('points');
        $available_topup_points = $total_ad_points - $total_premium_ads;
        
        return view('member.account')
            ->with('user',$user)
            ->with('ecomnnect_wallet',$ecomnnect_wallet)
            ->with('ads_profit',$ads_profit)
            ->with('available_topup_points',$available_topup_points);       
    }

    public function getAccountData(Request $request){

        if ($request->wantsJson()) {
                
                $user = Auth::user();
                $accounts = $user->account()->count();

                if($accounts > 0){
                    if($user->active == 0){
                        $user->active = 1;
                        $user->activated_at = Carbon::now();
                        $user->save();
                    }
                } else {
                    if($user->active == 1){
                        $user->active = 0;
                        $user->activated_at = Carbon::now();
                        $user->save();
                    }
                }
                
                $earnings = getEarnings($user->id);
                $summary = getDashboardCounts($user->id); 

                return response()->json(['earnings'=> $earnings, 'summary'=> $summary,'account'=> $accounts],200); 
        
        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getProfile(){

        $user = Auth::user();
        $teams = Team::get();
        
        return view('member.profile')->with('user',$user)->with('teams',$teams);    
    }

    public function getSecurityPin(){

        $user = Auth::user();
        
        return view('member.security-pin')->with('user',$user);
    }

    public function getSecurityPassword(){

        $user = Auth::user();
        
        return view('member.security-password')->with('user',$user);
    }

    public function postProfile(UpdateProfileRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();
                if($user->middle_name == NULL || $user->team == NULL){
                    $user->middle_name = $request->middle_name;
                }
                $user->mobile = $request->mobile;
                $user->birth_date = $request->birth_date;
                $user->save();

                return response()->json(array("result"=>true,"message"=>'Profile has been updated.'),200); 
                                    
                    
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postSecurityPassword(UpdateProfilePasswordRequest $request){
        if($request->wantsJson()) {

            try {  

                if (Hash::check($request->current_password ,Auth::user()->password))
                {

                    $user = Auth::user();
                    $user->password = bcrypt($request->password);
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Password has been updated.'),200); 
    

                } else {
                    return response()->json(array("result"=>false,"message"=>'Incorrent current password.'),422);
                }
                    
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postSecurityPin(UpdateProfilePinRequest $request){
        if($request->wantsJson()) {

            try {  

                if (Hash::check($request->current_password ,Auth::user()->password))
                {

                    $user = Auth::user();
                    $user->pin = $request->pin;
                    $user->pin_attempt = DB::raw('pin_attempt+1');
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Pin successfully set!'),200); 
    
                } else {
                    return response()->json(array("result"=>false,"message"=>'Wrong current password!'),422);
                }
                    
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postProfileTin(UpdateProfileTinRequest $request){
        if($request->wantsJson()) {

            $user = Auth::user();

            if($user->pin == $request->pin) {

                try {
                        
                    $user->tin = $request->tin;
                    $user->save();
                    
                    return response()->json(array("result"=>true,"message"=>'TIN Successfully Save'),200);

                }catch(\Exception $e){
                    return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
                }
            
            } else{
                return response()->json(array("result"=>false,"message"=>'Incorrect Security Pin.'),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getAccounts(){

        $user = Auth::user();
        
        return  view('member.accounts')->with('user',$user);       
    }

    public function getAccountActivation(){

        $user = Auth::user();

        if($user->active == 0){
        
            return view('member.activation')->with('user',$user);
        }else {

            return redirect('/listing');
        }
    }

    public function getAddAccount(){

        $user = Auth::user();

        if($user->active == 1){
        
            return view('member.add')->with('user',$user);
        }else {

            return redirect('/account/activation');
        }
             
    }

    public function getAccountsData(Request $request){

        if ($request->wantsJson()) {
                
            $accounts = Auth::user()->account()->orderBy('created_at','desc')->get();
            $codes = Auth::user()->code()->where('status','UNUSED')->orderBy('owned_at','desc')->get();

            $acounts_data = [];

            foreach ($accounts as $key => $value) {
                
                $account = [ 
                    'account_name' => $value->account_name,
                    'activation_code' => $value->activation_code,
                    'parent_account_name' => $value->parent_account_name,
                    'position' => $value->position,
                    'status' => $value->status,
                    'waiting_left' => $value->waiting_left,
                    'waiting_right' => $value->waiting_right,
                    'pairing_today' => $value->pairing_bonus()->whereDate('created_at', Carbon::today())->count(),
                    'pairing_total' => $value->pairing_bonus()->count(),
                    'created_at' => Carbon::parse($value->created_at)->format('Y-m-d h:i:s')
                ];

                array_push($acounts_data, $account);
            }

            return response()->json(['accounts'=> $acounts_data, 'codes'=> $codes],200); 
        
        } else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getActivationCodes(){

        $user = Auth::user();
        
        return  view('member.activation-codes')->with('user',$user);       
    }

    public function getActivationCodesData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $codes = Code::with('account')->where('user_id',Auth::user()->id)->orderBy('owned_at','desc');
            
            if($codes){

                return Datatables::of($codes)
                ->editColumn('code', function ($codes) {
                    return $codes->code;
                })
                ->editColumn('used_by', function ($codes) {
                    if($codes->status == 'UNUSED'){
                        return '';
                    } elseif($codes->status == 'USED') {
                        return $codes->account->account_name; 
                    } else {
                        return '';
                    }
                })
                ->editColumn('code_type', function ($codes) {
                    if($codes->code_type == 'FREE SLOT'){
                        return '<strong><span class="text-danger">' . $codes->code_type . '</span></strong>';
                    } else {
                        return '<strong><span class="text-success">' . $codes->code_type . '</span></strong>';
                    }
                })
                ->editColumn('status', function ($codes) {
                    if($codes->status == 'UNUSED'){
                        return '<span class="text-success">UNUSED</span>';
                    } elseif($codes->status == 'USED') {
                        return '<span class="text-danger">USED</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('date', function ($codes) {
                    return date('F j, Y g:i a', strtotime($codes->owned_at)) . ' | ' . Carbon::parse($codes->owned_at)->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['code','used_by','code_type','status','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        }else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getTransferCodes(){

        $user = Auth::user();
        $codes = Code::where('user_id',$user->id)->where('status','UNUSED')->orderBy('owned_at','desc')->get();
        
        return  view('member.transfer-codes')->with('user',$user)->with('codes',$codes);       
    }

    public function getTransferCodesHistory(){

        $user = Auth::user();
        
        return view('member.activation-codes-history')->with('user',$user);       
    }

    public function getTransferCodesData(Request $request){

        if($request->wantsJson()) {

            $user = Auth::user();
            
            $transfer_codes = TransferCodes::select('transfer_by_user_id','transfer_to_user_id','code','created_at')->where('transfer_by_user_id',$user->id)->orWhere('transfer_to_user_id',$user->id);

            return Datatables::of($transfer_codes)
                ->editColumn('details', function ($transfer_codes) {
                    if($transfer_codes->transfer_by_user_id == Auth::user()->id){
                        return '<span>You have transferred code to <strong class="text-danger">'.$transfer_codes->transfer_to->username. '</strong> ('. $transfer_codes->transfer_to->full_name .')</span>';
                    } elseif($transfer_codes->transfer_to_user_id == Auth::user()->id) {
                        return '<span>You have received code from <strong class="text-success">'.$transfer_codes->transfer_by->username. '</strong> ('. $transfer_codes->transfer_by->full_name .')</span>';
                    }
                })
                ->editColumn('code', function ($transfer_codes) {
                    return $transfer_codes->code;
                })
                ->addColumn('date', function ($transfer_codes) {
                    return date('F j, Y g:i a', strtotime($transfer_codes->created_at)) . ' | ' . $transfer_codes->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['details','code','date'])
                ->make(true);
            
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
        }           
    }

    public function postTransferCodes(TransferCodesRequest $request){
        if($request->wantsJson()) {

            try {

                $user = Auth::user();

                if($user->username == $request->username){
                    return response()->json(array("result"=>false,"message"=>'Code\'s already belongs to you.'),422);
                }

                if($user->active == 0){
                    return response()->json(array("result"=>false,"message"=>'Sorry this feature is for activated or premium member only.'),422);
                }
                
                if($user->pin == $request->pin) {
                
                    $member = User::where('username',$request->username)->orWhere('email',$request->username)->first();
                    if(!$member){
                        return response()->json(array("result"=>false,"message"=>'User not found.'),422);
                    }
                    
                    $quantity = $request->quantity;
                    $codes = Code::where('user_id',$user->id)->where('status','UNUSED')->where('code_type',$request->code_type)->orderBy('created_at','desc')->take($quantity)->get();

                    if($quantity > count($codes)){
                        return response()->json(array("result"=>false,"message"=>'Not enough available codes.'),422);
                    }
                    
                    $code = Code::where('user_id',$user->id)->where('code_type',$request->code_type)->where('status','UNUSED')->first();
                    if(!$code){
                        return response()->json(array("result"=>false,"message"=>'Something went wrong with your activation code or Insufficient Codes.'),422);
                    }

                    if($quantity > 1){
                    
                        foreach($codes as $code){
                        
                            $code = Code::find($code->id);
                            $code->user_id = $member->id;
                            $code->owned_at = Carbon::now();
                            $code->transfered_at = Carbon::now();
                            $code->touch();
                            $code->save();
                            
                            $transfer = new TransferCodes;
                            $transfer->transfer_by_user_id = $user->id;
                            $transfer->transfer_to_user_id = $member->id;
                            $transfer->code = $code->code;
                            $transfer->save();  
                        }
                        
                    }else{
                    
                        $code = Code::find($code->id);
                        $code->user_id = $member->id;
                        $code->owned_at = Carbon::now();
                        $code->transfered_at = Carbon::now();
                        $code->touch();
                        $code->save();
                        
                        $transfer = new TransferCodes;
                        $transfer->transfer_by_user_id = $user->id;
                        $transfer->transfer_to_user_id = $member->id;
                        $transfer->code = $code->code;
                        $transfer->save();  
                    }
                    
                    return response()->json(array("result"=>true,"message"=>'Code Successfully transferred.'),200);

                } else{
                    return response()->json(array("result"=>false,"message"=>'Your Security Pin is invalid.'),422);
                }                       
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'.$e),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getSubscribers(){

        $user = Auth::user();
        
        return  view('member.subscribers')->with('user',$user);       
    }

    public function getSubscribersData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $subscribers = User::where('sponsor_id',$user->id)->orderBy('created_at','desc');
            
            if($subscribers){

                return Datatables::of($subscribers)
                ->editColumn('name', function ($subscribers) {
                    return ucwords($subscribers->full_name);
                })
                ->editColumn('username', function ($subscribers) {
                    return $subscribers->username; 
                })
                ->addColumn('details', function ($subscribers) {
                    return $subscribers->mobile;
                })
                ->editColumn('status', function ($subscribers) {
                    if($subscribers->active == 1){
                        return '<span class="text-success">PREMIUM</span>';
                    } elseif($subscribers->active == 0) {
                        return '<span class="text-danger">FREE</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($subscribers) {
                    if($subscribers->retailer == 0){
                        if($subscribers->active == 0){
                            return '<button class="btn btn-lime btn-sm" id="status'.$subscribers->id.'" onclick="angular.element(this).scope().frm.activateRetailer('.$subscribers->id.')" >Activate sub-seller</button>';
                        }
                    }elseif($subscribers->retailer == 1) {
                        if($subscribers->active == 0){
                            return '<strong class="text-success">ACTIVATED</strong>';
                        }
                    }
                })
                ->addColumn('date', function ($subscribers) {
                    return date('F j, Y g:i a', strtotime($subscribers->created_at)) . ' | ' . $subscribers->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['name','username','mobile','status','action','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        }else{

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getTAC(){

        $user = Auth::user();
        
        return  view('member.terms-and-conditions')->with('user',$user);       
    }

    public function getMemo(){

        $user = Auth::user();
        
        return  view('member.important-memo')->with('user',$user);       
    }
}
