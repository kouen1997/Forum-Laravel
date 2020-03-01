<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\CreateMemberRequest;
use App\Http\Requests\Admin\UpdateMemberProfileRequest;
use App\Http\Requests\Admin\UpdateMemberPasswordRequest;
use App\Http\Requests\Admin\UpdateMemberPinRequest;
use App\Http\Requests\Admin\UpdateMemberSponsorRequest;
use App\Http\Requests\Admin\UpdateMemberBdoAttemptRequest;
use App\Http\Requests\Admin\TransferCodesRequest;
use App\Http\Requests\Admin\SetTruemoneyCardRequest;
use App\Http\Requests\Eloading\HelperLoadTransferRequest;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Http\Requests\Account\TransferMasterFundRequest;
use App\Http\Requests\Admin\RetrieveMasterFundRequest;
use App\Http\Requests\Admin\RetrieveEloadingWalletRequest;
use App\Http\Requests\Admin\UpdateMemberYazzAccountRequest;
use App\Http\Requests\Support\CommentsRequest;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\User;
use App\Account;
use App\BdoAccount;
use App\Genealogy;
use App\PairingBonus;
use App\LevelingBonus;
use App\Points;
use App\Code;
use App\CodeRequest;
use App\TransferCodes;
use App\RetrieveCodes;
use App\BuyCode;
use App\Withdrawal;
use App\Truemoney;
use App\TruemoneyWithdrawal;
use App\LoadWallet;
use App\LoadCharge;
use App\LoadTransfer;
use App\TransferMasterFund;
use App\Settings;
use App\Tickets;
use App\TicketComments;
use App\YazzAccount;
use App\Payment;
use App\Property;
use App\Photos;
use App\Inquiry;
use Session;
use Redirect;
use Hash;
use DB;

class HelperController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('helper');
    }

    public function getHelper(){

        $user = Auth::user();
        $paysbook_wallet = getTotalPoints($user->id);

        return  view('helper.dashboard')->with('user',$user)->with('paysbook_wallet',$paysbook_wallet);  
    }

    public function getHelperData(Request $request) {

        if ($request->wantsJson()) {
                
            $user = Auth::user();

            $total_fund = getDealerTotalMasterFund($user->id);
            $total_fund_transferred = getDealerTotalTransferredMasterFund($user->id);
            $total_codes = Code::where('user_id', $user->id)->where('status','UNUSED')->count();
            $total_paid_codes = Code::where('user_id', $user->id)->where('code_type','PAID')->where('status','UNUSED')->count();
            $total_free_codes = Code::where('user_id', $user->id)->where('code_type','FREE')->where('status','UNUSED')->count();
            $total_codes_transferred = TransferCodes::select('transfer_by_user_id','transfer_to_user_id','code','created_at')->where('transfer_by_user_id',$user->id)->count();
            $open = Tickets::where('agent_id',$user->id)->where('status','OPEN')->count();
            $completed = Tickets::where('agent_id',$user->id)->where('status','COMPLETED')->count();
            
            return response()->json(['total_fund'=> $total_fund, 'total_fund_transferred'=> $total_fund_transferred, 'total_codes'=> $total_codes, 'total_paid_codes'=> $total_paid_codes, 'total_free_codes'=> $total_free_codes, 'total_codes_transferred'=> $total_codes_transferred,'open'=> $open,'completed'=> $completed],200); 
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getHelperMembers(){

        $user = Auth::user();
        
        return  view('helper.members')->with('user',$user);      
    }

    public function getHelperMembersInfo($id) {

        $user = User::find($id);

        $paysbook_wallet = getTotalPoints($user->id);

        if(!YazzAccount::where('user_id',$user->id)->first()){
            $yazz_account = new YazzAccount;
            $yazz_account->user_id = $user->id;
            $yazz_account->save(); 
        }
        
        return  view('helper.members-info')->with('user',$user)->with('paysbook_wallet',$paysbook_wallet);  
    }

    public function getHelperMembersInfoData($id, Request $request) {

        if ($request->wantsJson()) {

            $user = User::find($id);

            $earnings = getEarnings($user->id);
            $dashboard_count = getDashboardCounts($user->id); 
            
            return response()->json(['earnings'=> $earnings, 'dashboard_count'=> $dashboard_count],200); 

         } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getHelperMembersData(Request $request) {

        if ($request->wantsJson()) {
                

            if($sponsor = $request->sponsor){   

                $members = User::with('code_unused','code','sponsor','sponsored','paid_account','free_account')->where('role',1)
                            ->where('sponsor_username',$sponsor)->orderBy('created_at','DESC')->take(100)->get();               
            } else {
        
                if($search = $request->username) {

                    $members = User::with('code_unused','code','sponsor','sponsored','paid_account','free_account')->where('role',1)->where('username', $search)->orderBy('created_at','DESC')->get();

                } else if($name = $request->name) {

                    $search = '%'.$name.'%';

                    $members = User::with('code_unused','code','sponsor','sponsored','paid_account','free_account')->where('role',1)->where(DB::raw('concat(first_name," ",last_name)') , 'LIKE' , $search)->orderBy('created_at','DESC')->get();

                } else {
                    $members = User::with('code_unused','code','sponsor','sponsored','paid_account','free_account')->where('role',1)
                                ->orderBy('created_at','DESC')->take(100)->get();
                }
            }

            return response()->json(['members'=> $members],200); 
            
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postHelperMembersYazzAccount($id, UpdateMemberYazzAccountRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                $yazz_account = YazzAccount::where('user_id',$id)->first();

                if($yazz_account){

                    if($request->card_payment > 0){

                       if(!Payment::where('user_id',$id)->where('description','ATM/BANK ACCOUNT CARD PAYMENT')->orWhere('description','YAZZ CARD PAYMENT')->first()){
                             //lets deduct 350
                            $payment = new Payment;
                            $payment->user_id = $id;
                            $payment->amount = $request->card_payment;
                            $payment->description = 'YAZZ CARD PAYMENT';
                            $payment->save();
                        }
                    }

                    if($request->shipping_cost > 0){

                        if(!Payment::where('user_id',$id)->where('description','YAZZ CARD SHIPPING COST')->first()){
                            $payment = new Payment;
                            $payment->user_id = $id;
                            $payment->amount = $request->shipping_cost;
                            $payment->description = 'YAZZ CARD SHIPPING COST';
                            $payment->save();
                        }
                        
                    }

                    $yazz_account->card_number = $request->card_number;
                    $yazz_account->save();

                    return response()->json(array("result"=>true,"message"=>'Member YAZZ Account Successfully Updated.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postHelperMembersProfile($id, UpdateMemberProfileRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                //find user
                $user = User::where('id',$id)->first();

                if($user){

                    $user->first_name = $request->first_name;
                    $user->middle_name = $request->middle_name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->mobile = $request->mobile;
                    $user->birth_date = $request->birth_date;
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Member Profile Successfully Updated.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postHelperMembersPassword($id, UpdateMemberPasswordRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                //find user
                $user = User::where('id',$id)->first();

                if($user){

                    $user->password = bcrypt($request->password);
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Member Password Successfully Updated.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postHelperMembersPin($id, UpdateMemberPinRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                //find sponsor
                $user = User::where('id',$id)->first();

                if($user){

                    $user->pin = $request->pin;
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Member Pin Successfully Updated.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postHelperMembersBdoAttempt($id, UpdateMemberBdoAttemptRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                //find sponsor
                $bdo_account = BdoAccount::where('user_id',$id)->first();

                if($bdo_account){

                    $bdo_account->attempt = $request->max_attempt;
                    $bdo_account->save();

                    return response()->json(array("result"=>true,"message"=>'Member Bdo Max Attempt Successfully Updated.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postHelperMembersSponsor($id, UpdateMemberSponsorRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                //find sponsor
                $user = User::where('id',$id)->first();

                if($user){


                    //find sponsor

                    $sponsor = User::where('username',$request->new_sponsor)->first();

                    $user->sponsor_id = $sponsor->id;
                    $user->sponsor_username = $sponsor->username;
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Member Sponsor Successfully Updated.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }


    public function getHelperAccounts(){

        $user = Auth::user();
        
        return  view('helper.accounts')->with('user',$user);      
    }

    public function getHelperAccountsData(Request $request) {

        if ($request->wantsJson()) {
        
            if($user_id = $request->user_id){

                $accounts = Account::with('user')->where('user_id', $user_id)->orderBy('created_at','desc')->get();
                
            } else {
        
                if($search = $request->search) {
                    $accounts = Account::with('user')
                    ->where(function($query) use($search){
                        $query->where('account_name', 'LIKE', $search.'%' )
                        ->orWhere('activation_code', 'LIKE',  $search.'%')
                        ->orWhere('parent_account_name', 'LIKE',  $search.'%');
                    })
                    ->orderBy('created_at','desc')->get();
                } else {

                    $accounts = Account::with('user')->orderBy('created_at','desc')->take(100)->get();
                }
            }

            return response()->json(['accounts' => $accounts],200); 
            
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getHelperGenealogy(Request $request){

        $user = Auth::user();

        if ($request->has('account') && $request->has('account') != '') {
            $parent_account_name = $request->account;
            $account = Account::where('account_name',$parent_account_name)->first();
            
            if(!$account){
                return redirect('/account');
            }

        } else {

            $account = Account::where('user_id',$user->id)->orderBy('id','ASC')->first();
        }

        if($account) {

            unset($GLOBALS["left_accounts"]); 
            unset($GLOBALS["right_accounts"]); 
            $GLOBALS["left_accounts"] = array(); 
            $GLOBALS["right_accounts"] = array();

            $genealogy_html = '';
            $genealogy_html .= '<div class="tree">';
            $genealogy_html .= '<ul id="org" style="display:none">';

            $genealogy_html .= '<li>';
            $genealogy_html .= '<div class="tree-node">';
            
            $genealogy_html .= '<div class="tree-node-avatar">';

            $genealogy_html .= "<img src='".url('favicon.png')."' class='img-circle user-img-circle".$account->owner_id."' style='height:50px; width:50px;'>";

            $genealogy_html .= '</div>';

            
            $genealogy_html .= '<div class="tree-node-info">';

            $genealogy_html .= "<a href='?account=".$account->account_name."'><b>".$account->account_name."</b></a></div>";
            
            $genealogy_html .= '<div class="tree-node-info-bottom" style="text-align:center">';
            $genealogy_html .= $account->position;
            $genealogy_html .= '</div></div>';   

            $genealogy_html .= '<ul>';

            //left accounts
            $left_account = Account::where('parent_id',$account->id)->where('position','LEFT')->first();
            if($left_account){
                $genealogy_html .= self::leftGenealogy($left_account,1,5);
            }

            //right accounts
            $right_account = Account::where('parent_id',$account->id)->where('position','RIGHT')->first();
            if($right_account){
                $genealogy_html .= self::rightGenealogy($right_account,1,5);
            }
            
            $genealogy_html .= '</ul>';
            $genealogy_html .= '</li>';  


            $genealogy_html .= '</ul>';
            $genealogy_html .= '</div>';


            return  view('helper.genealogy')->with('account',$account)->with('left_accounts',$GLOBALS["left_accounts"])->with('right_accounts',$GLOBALS["right_accounts"])->with('genealogy',$genealogy_html)->with('user',$user);

        } else { 

            return  view('web.account.blank')->with('user',$user);
        }
      
    }

    public function leftGenealogy($account, $countLevel , $levelLimit){
    

        $countLevel++;

        $html = '';

        if($countLevel<$levelLimit){

            $account = Account::where('id',$account->id)->first();

            if($account){

                $data = [
                    'account_name' => $account->account_name,
                    'position' => $account->position,
                    'placement' => $account->parent_account_name,
                    'level' => $countLevel,
                    'status' => $account->status
                ];

                array_push($GLOBALS["left_accounts"], $data);

                $html .= '<li>';
                $html .= '<div class="tree-node">';
                
                $html .= '<div class="tree-node-avatar">';

                $html .= "<img src='".url('favicon.png')."' class='img-circle user-img-circle".$account->owner_id."' style='height:50px; width:50px;'>";

                $html .= '</div>';

                
                $html .= '<div class="tree-node-info">';

                $html .= "<a href='?account=".$account->account_name."'><b>".$account->account_name."</b></a></div>";
                
                $html .= '<div class="tree-node-info-bottom" style="text-align:center">';
                $html .= $account->position;
                $html .= '</div></div>';     

                $html .= '<ul>';

                //left accounts
                $left_account = Account::where('parent_id',$account->id)->where('position','LEFT')->first();
                if($left_account){
                    $html .=  self::leftGenealogy($left_account,$countLevel , $levelLimit);
                }

                //right accounts
                $right_account = Account::where('parent_id',$account->id)->where('position','RIGHT')->first();
                if($right_account){
                    $html .= self::leftGenealogy($right_account,$countLevel , $levelLimit);
                }
                
                $html .= '</ul>';
                $html .= '</li>'; 

            }
        }

        return $html;
    }

    public function rightGenealogy($account, $countLevel , $levelLimit){
        
        $countLevel++;

        $html = '';

        if($countLevel<$levelLimit){

            $account = Account::where('id',$account->id)->first();

            if($account){

                $data = [
                    'account_name' => $account->account_name,
                    'position' => $account->position,
                    'placement' => $account->parent_account_name,
                    'level' => $countLevel,
                    'status' => $account->status
                ];

                array_push($GLOBALS["right_accounts"], $data);

                $html .= '<li>';
                $html .= '<div class="tree-node">';
                
                $html .= '<div class="tree-node-avatar">';

                $html .= "<img src='".url('favicon.png')."' class='img-circle user-img-circle".$account->owner_id."' style='height:50px; width:50px;'>";

                $html .= '</div>';

                
                $html .= '<div class="tree-node-info">';

                $html .= "<a href='?account=".$account->account_name."'><b>".$account->account_name."</b></a></div>";
                
                $html .= '<div class="tree-node-info-bottom" style="text-align:center">';
                $html .= $account->position;
                $html .= '</div></div>';     

                $html .= '<ul>';

                //left accounts
                $left_account = Account::where('parent_id',$account->id)->where('position','LEFT')->first();
                if($left_account){
                    $html .=  self::rightGenealogy($left_account,$countLevel , $levelLimit);
                }

                //right accounts
                $right_account = Account::where('parent_id',$account->id)->where('position','RIGHT')->first();
                if($right_account){
                    $html .= self::rightGenealogy($right_account,$countLevel , $levelLimit);
                }
                
                $html .= '</ul>';
                $html .= '</li>'; 

            }
        }

        return $html;
    }

    public function getHelperTransferCodes(){

        $user = Auth::user();
        $codes = Code::where('user_id', $user->id)->where('status','UNUSED')->orderBy('created_at','desc')->take(500)->get();
        
        return  view('helper.transfer-codes')->with('user',$user)->with('codes',$codes);       
    }

    public function getHelperTransferCodesData(Request $request){

        if($request->wantsJson()) {


            $user = Auth::user();
            
            $transfer_codes = TransferCodes::select('transfer_by_user_id','transfer_to_user_id','code','created_at')->where('transfer_by_user_id',$user->id)->orWhere('transfer_to_user_id',$user->id);

            return Datatables::of($transfer_codes)
                ->addColumn('message', function ($transfer_codes) {
                    if($transfer_codes->transfer_by_user_id == Auth::user()->id){
                        return '<span>You have <strong class="text-danger">transferred</strong> activation code to <strong class="text-danger">'.$transfer_codes->transfer_to->username.'</strong> ('.$transfer_codes->transfer_to->first_name .' '. $transfer_codes->transfer_to->last_name.')</strong></span>';
                    } elseif($transfer_codes->transfer_to_user_id == Auth::user()->id) {
                        return '<span>You have <strong class="text-success">received</strong> activation code from <strong class="text-success">'.$transfer_codes->transfer_by->username.'</strong> ('.$transfer_codes->transfer_to->first_name .' '. $transfer_codes->transfer_to->last_name.')</strong></span>';
                    }
                })
                ->addColumn('date', function ($transfer_codes) {
                    return $transfer_codes->created_at->format('F d, Y h:i A') . ' | ' . $transfer_codes->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['message','date'])
                ->make(true);
            
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postHelperTransferCodes(TransferCodesRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();

                if($user->username == $request->username){
                    return response()->json(array("result"=>false,"message"=>'Code\'s alread belong to you!'),422);
                }
                
                if($user->pin == $request->pin) {
                
                    $member = User::where('username',$request->username)->first();
                    if(!$member){
                        return response()->json(array("result"=>false,"message"=>'User doesnt exist.'),422);
                    }
                    
                    $quantity = $request->quantity;
                    $codes = Code::where('user_id',$user->id)->where('code_type',$request->code_type)->where('status','UNUSED')->orderBy('created_at','desc')->take($quantity)->get();

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
                    return response()->json(array("result"=>false,"message"=>'Incorrect Security Pin.'),422);
                }                       
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'.$e),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getHelperActivationCodes() {

        $user = Auth::user();
        
        return  view('helper.activation-codes')->with('user',$user);

    }

    public function getHelperActivationCodesData(Request $request) {

        if ($request->wantsJson()) {



            if($search_user = $request->search_user) {

                //find user 
                $users = User::where('username',$search_user)->orWhere('first_name','like', $search_user.'%' )->get();
                $user_array = array();
                foreach($users  as $user){
                    array_push($user_array,$user->id);
                }

                $codes = Code::with('user','account')->whereIn('user_id',$user_array)->orderBy('created_at','desc')->paginate(100);
            } elseif($search_code = $request->search_code) {

                $codes = Code::with('user','account')->where('code',$search_code)->orderBy('created_at','desc')->paginate(100);

            } else {

                $codes = Code::with('user','account')->orderBy('created_at','desc')->paginate(100);
            }

            return response()->json(['codes'=> $codes],200); 

         } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getHelperActivationCodesRetrieve($id, Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();

            $code = Code::where('id',$id)->where('status',"UNUSED")->first();
            if($code){ 

                $from = User::where('id',$code->user_id )->first();

                if($from){   
                
                    $code->user_id = $user->id;
                    $code->used_by_user_id = NULL;
                    $code->owned_at = Carbon::now();
                    $code->transfered_at = NULL;
                    $code->touch();
                    $code->save();

                    $retrieve = new RetrieveCodes;
                    $retrieve->retrieve_by_user_id = $user->id;
                    $retrieve->retrieve_from_user_id = $from->id;
                    $retrieve->code = $code->code;
                    $retrieve->save();  

                    return response()->json(array("result"=>true,"message"=> "Code ".$code->code." has been retrieve from ".$from->username) ,200);

                } else {

                    return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
                }

             } else {

                return response()->json(array("result"=>false,"message"=>'Code not found or already used!'),422);
            }
        }

    }


    public function getHelperEloadingTransfer(){

        $user = Auth::user();
        $total_load_wallet = getTotalLoadWallet($user->id);

        return  view('helper.eloading-transfer')->with('user',$user)->with('total_load_wallet',$total_load_wallet);
    }

    public function postHelperEloadingTransfer(HelperLoadTransferRequest $request){

        if($request->wantsJson()) {

            $user = Auth::user();
            
            $check_user = User::where('email',$request->user)->orWhere('username',$request->user)->first();
            if($check_user ) {
                if($user->pin == $request->pin) {
                    if($request->amount >= 10) {

                        if($check_user->id != $user->id){
                            if($request->mode == 0){

                                $total_load_wallet = getTotalLoadWallet($user->id);

                                if($total_load_wallet >= $request->amount){
                                    
                                    $amount = $request->amount;
                                    $adminfee = $amount * 0.02;
                                    $total = $amount + $adminfee;

                                    $load_transfer = new LoadTransfer;
                                    $load_transfer->transfer_by_user_id = $user->id;
                                    $load_transfer->transfer_to_user_id = $check_user->id;
                                    $load_transfer->amount = $amount;
                                    $load_transfer->total = $total;
                                    $load_transfer->wallet = 0;
                                    $load_transfer->save();

                                    return response()->json(array("result"=>true,"message"=>'Successfully Transferred.'), 200);

                                }else {
                                    return response()->json(array("result"=>false,"message"=>"Not enough load wallet. Balance: ".$total_load_wallet), 200);
                                }
                            }
                            
                        } else {
                            return response()->json(array("result"=>false,"message"=>"You cant transfer load wallet to yourself."), 200);
                        }
                            
                    } else {
                        return response()->json(array("result"=>false,"message"=>"Minimum transfer is 10"), 200);
                    }

                } else {
                    return response()->json(array("result"=>false,"message"=>"Incorrect Security Pin"), 200);
                }

            } else {
                return response()->json(array("result"=>false,"message"=>"Email / Username does not exist."), 200);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'.$e),422);
        }  

    }

    public function postHelperEloadingRetrieve($id,RetrieveEloadingWalletRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();

                    $load_transfer = LoadTransfer::where('id',$id)->where('transfer_by_user_id',$user->id)->first();

                    if(!$load_transfer){
                        return response()->json(array("result"=>false,"message"=>'Load Transfer not found or not belong to you!'),422);
                    } 

                    if($request->amount > $load_transfer->total){
                        return response()->json(array("result"=>false,"message"=>'Retrieving amount is greater than the current load wallet! '),422);
                    }

                    if($request->amount == $load_transfer->total) {
                        
                        $load_transfer->amount = 0;
                        $load_transfer->total = 0;
                        $load_transfer->save();

                    } else {

                        $amount = $load_transfer->total - $request->amount;
                        $adminfee = $amount * 0.02;
                        $total = $amount + $adminfee;

                        $load_transfer->amount = number_format($amount,2);
                        $load_transfer->total = number_format($total,2);
                        $load_transfer->save();
                    }

                    
                    
                    return response()->json(array("result"=>true,"message"=>'Successfully retrieve '.$request->amount.' load wallet.'),200);
                   
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getHelperEloadingHistory(){

        $user = Auth::user();
        $total_load_wallet = getTotalLoadWallet($user->id);

        return  view('helper.eloading-history')->with('user',$user)->with('total_load_wallet',$total_load_wallet);
    }

    public function getHelperEloadingHistoryData(Request $request){

        if($request->wantsJson()) {

            $user = Auth::user();
            $transfer_history = LoadTransfer::with('transfer_by','transfer_to')->where('transfer_by_user_id',$user->id)->orWhere('transfer_to_user_id',$user->id)->orderBy('created_at','DESC')->get();

            return response()->json(array('transfer_history'=>$transfer_history),200);

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }  

    }

    public function getHelperTransferMasterFund(){

        $user = Auth::user();

        return  view('helper.transfer-master-fund')->with('user',$user);  
    }

    public function getHelperTransferMasterFundData(Request $request) {

        if($request->wantsJson()) {


            $user = Auth::user();
            
            $transfer_fund = TransferMasterFund::select('id','transfer_by_user_id','transfer_to_user_id','amount','total','created_at')->where('transfer_by_user_id',$user->id)->orWhere('transfer_to_user_id',$user->id);

            return Datatables::of($transfer_fund)
                ->addColumn('message', function ($transfer_fund) {
                    if($transfer_fund->transfer_by_user_id == Auth::user()->id){
                        return '<span>You have <strong class="text-danger">transferred</strong> master fund to <strong class="text-danger">'.$transfer_fund->transfer_to->username.'</strong> ('.$transfer_fund->transfer_to->first_name .' '. $transfer_fund->transfer_to->last_name.')</span>';
                    } elseif($transfer_fund->transfer_to_user_id == Auth::user()->id) {
                        return '<span>You have <strong class="text-success">received</strong> master fund from <strong class="text-success">'.$transfer_fund->transfer_by->username.'</strong> ('.$transfer_fund->transfer_to->first_name .' '. $transfer_fund->transfer_to->last_name.')</span>';
                    }
                })
                ->editColumn('amount', function ($transfer_fund) {
                    return '<b>&#8369;'.number_format($transfer_fund->amount).'</b>';
                })
                ->editColumn('total', function ($transfer_fund) {
                    return '<b>&#8369;'.number_format($transfer_fund->total).'</b>';
                })
                ->addColumn('date', function ($transfer_fund) {
                    return $transfer_fund->created_at->format('F d, Y h:i A') . ' | ' . $transfer_fund->created_at->diffForHumans();
                })
                ->addColumn('action', function ($transfer_fund) {
                    if(Auth::user()->id == $transfer_fund->transfer_by_user_id){
                        return '<button class="btn btn-primary btn-sm" onclick="angular.element(this).scope().frm.retrieveFund('.$transfer_fund->id.')" >Retrieve</button>';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['message','amount','total','date','action'])
                ->make(true);
            
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
                        
    }

    public function postHelperTransferMasterFund(TransferMasterFundRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();
                $total_fund = getDealerTotalMasterFund($user->id);

                
                if($user->pin == $request->pin) {

                    $member = User::where('username',$request->username)->first();
                    if(!$member){
                        return response()->json(array("result"=>false,"message"=>'User doesnt exist!'),422);
                    }  

                    if($total_fund < $request->amount){
                        return response()->json(array("result"=>false,"message"=>'Not enough master fund to transfer!'),422);
                    }

                    if($member->role == 4){

                        $percentage = $request->amount * 0.05; 

                        if($total_fund < $request->amount + $percentage){

                            return response()->json(array("result"=>false,"message"=>'Not enough master fund to transfer!'),422);
                        }
                            
                        $transfer = new TransferMasterFund;
                        $transfer->transfer_by_user_id = $user->id;
                        $transfer->transfer_to_user_id = $member->id;
                        $transfer->amount = $request->amount;
                        $transfer->total = $request->amount + $percentage;
                        $transfer->save();

                    } else {

                        if($total_fund < $request->amount){
                            return response()->json(array("result"=>false,"message"=>'Not enough master fund to transfer!'),422);
                        }

                        $transfer = new TransferMasterFund;
                        $transfer->transfer_by_user_id = $user->id;
                        $transfer->transfer_to_user_id = $member->id;
                        $transfer->amount = $request->amount;
                        $transfer->total = $request->amount;
                        $transfer->save();
                    }

                    
                    return response()->json(array("result"=>true,"message"=>'Master fund successfully transferred.'),200);

                } else{
                    return response()->json(array("result"=>false,"message"=>'Incorrect Security Pin.'),422);
                }                       
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'.$e),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postHelperMasterFundRetrieve($id,RetrieveMasterFundRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();

                //if($user->pin == $request->pin) {

                    $master_fund = TransferMasterFund::where('id',$id)->where('transfer_by_user_id',$user->id)->first();

                    if(!$master_fund){
                        return response()->json(array("result"=>false,"message"=>'Master Fund not found or not belong to you!'),422);
                    } 

                    if($request->amount > $master_fund->total){
                        return response()->json(array("result"=>false,"message"=>'Retrieving amount is greater than the current fund! '),422);
                    }

                    if($master_fund->transfer_to->role == 4){

                        $new_amount = $master_fund->amount - $request->amount;

                        $percentage = $new_amount * 0.05; 
                    
                        $master_fund->amount = $new_amount;
                        $master_fund->total = $new_amount + $percentage;
                        $master_fund->save();  

                    } else {
                    
                        $new_amount = $master_fund->amount - $request->amount;
                    
                        $master_fund->amount = $new_amount;
                        $master_fund->total = $new_amount;
                        $master_fund->save();  
                    }
                    
                    
                    return response()->json(array("result"=>true,"message"=>'Successfully retrieve '.$request->amount.' master fund!'),200);

                // } else{
                //     return response()->json(array("result"=>false,"message"=>'Incorrect Security Pin.'),422);
                // }                       
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'.$e),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getTickets(){

        $user = Auth::user();

        return  view('helper.support.tickets')->with('user',$user);  
    }

    public function getTicketsData(Request $request) {

        if ($request->wantsJson()) {
                
            $user = Auth::user();

            $tickets =  Tickets::where('agent_id',$user->id)->orderBy('status','ASC')->orderBy('updated_at','DESC');

            return Datatables::of($tickets)
                // ->addColumn('details', function ($tickets) {
                //     return $tickets->html;

                // })
                ->editColumn('subject', function ($tickets) {
                    return '<a href="/helper/customer-support/ticket/'.$tickets->id.'" target="_blank">'.$tickets->subject.'</a>';
                })
                ->editColumn('status', function ($tickets) {
                    if($tickets->status == 'OPEN'){
                        return '<span class="label label-sm label-warning ">'.$tickets->status.'</span>'; 
                    } else {
                        return '<span class="label label-sm label-success">'.$tickets->status.'</span>'; 
                    }
                })
                ->addColumn('member', function ($tickets) {
                    return $tickets->user->full_name.'<br><small>'.$tickets->user->username.'</small>';

                })
                ->addColumn('category', function ($tickets) {
                    return '<span style="color:'.$tickets->category->color.'"><b>'.$tickets->category->name.'</b></span>';

                })
                ->editColumn('updated_at', function ($tickets) {
                    return $tickets->updated_at->diffForHumans();
                })

                ->addIndexColumn()
                ->rawColumns(['subject','details','status','category','member'])
                ->make(true); 
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    } 

     public function getViewTicket($id, Request $request){

        $user = Auth::user();
        
        $tickets = Tickets::where('id',$id)->where('agent_id',$user->id)->first();

        if(!$tickets){
            Session::flash('danger', "Ticket not found or not belong to you!");
            return redirect('/helper/customer-support');
        }


        return  view('helper.support.view-ticket')->with('user',$user)->with('tickets',$tickets);
    }

    public function getMarkCompleted($id, Request $request){

        $user = Auth::user();
        
        $tickets = Tickets::where('id',$id)->where('agent_id',$user->id)->first();

        if(!$tickets){
            Session::flash('danger', "Ticket not found or not belong to you!");
            return redirect('/helper/customer-support');
        }

        $tickets->status = 'COMPLETED';
        $tickets->save();

        Session::flash('success', "Ticket successfully marked as completed.");
        return Redirect::back();
    
    }

    public function postCreateComments(CommentsRequest $request){

        $user = Auth::user();   

        $comments = $request->comments;
        $dom = new \DomDocument();
        $dom->loadHtml($comments, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);    
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/tickets/" . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', url($image_name));
        }

        $comments = $dom->saveHTML();

        $ticket_comment = new TicketComments;
        $ticket_comment->user_id = $user->id;
        $ticket_comment->ticket_id = $request->ticket_id;
        $ticket_comment->content = $request->comments;
        $ticket_comment->html = $comments;
        $ticket_comment->save();

        Session::flash('success', "Comment has been added successfully!");

        return Redirect::back();

    }

    public function postHelperBan($id) {

        //find user
        $user = User::find($id);

        if($user){

            $user->suspended = 0;
            $user->banned = 1;
            $user->save();
            
            return redirect('/helper/members');
            
        } else {

            return response()->json(array("result"=>false,"message"=>'User not found!'),422);

        }

    }

    public function postHelperRetrieve($id) {

        //find user
        $user = User::find($id);

        if($user){

            $user->suspended = 0;
            $user->banned = 0;
            $user->save();

            return redirect('/helper/members');
            
        } else {

            return response()->json(array("result"=>false,"message"=>'User not found!'),422);

        }

    }

    //Leads
    public function getAddProperty() {

        $user = Auth::user();

        return view('helper.property.add')->with('user',$user);
    }

    public function postAddProperty(AddPropertyRequest $request) {

        try {

            $user = Auth::user();

            $available_at_date = Carbon::parse($request->available_from)->format('Y-m-d');
            $property = new Property;
            $property->user_id = $user->id;
            $property->offer_type = $request->offer_type;
            $property->property_type = $request->property_type;
            $property->sub_type = $request->sub_type;
            $property->title = $request->title;
            $property->description = $request->description;
            $property->bedrooms = $request->bedrooms;
            $property->baths = $request->baths;
            $property->floor_area = $request->floor_area;
            $property->floor_number = $request->floor_number;
            $property->condominium_name = $request->condominium_name;
            $property->price = $request->price;
            $property->available_from = $available_at_date;
            $property->object_id = $request->object_id;
            $property->video_url = $request->video_url;
            $property->province = $request->province;
            $property->city = $request->city;
            $property->barangay = $request->barangay;
            $property->address = $request->address;
            $property->map = $request->map;
            $property->name = $request->name;
            $property->email = $request->email;
            $property->mobile = $request->mobile;
            $property->is_featured = $request->is_featured;

            $property->save();

            if($request->file('photos')) {

                foreach($request->file('photos') as $photo){
                    $photos = new Photos;

                    $photoName = strtotime("now").'-'.str_replace(' ', '', $photo->getClientOriginalName());
                    $photo->move(public_path('media'.'/'.$property->id), $photoName);
                    $photos->property_id = $property->id;
                    $photos->filename = URL::asset('/media').'/'.$property->id.'/'.$photoName;
                    $photos->save();
                }
            }

            Session::flash('success', 'Property Successfully added.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function getProperties() {

        $user = Auth::user();

        return view('helper.property.list')->with('user',$user);
    }

    public function getPropertiesData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();

            $properties = Property::where('user_id',$user->id)->orderBy('created_at','desc');
            
            if($properties){

                return Datatables::of($properties)
                ->editColumn('title', function ($properties) {
                    return $properties->title;
                })
                ->editColumn('price', function ($properties) {
                    return $properties->price; 
                })
                ->addColumn('offer_type', function ($properties) {
                    return $properties->offer_type;
                })
                ->editColumn('property_type', function ($properties) {
                    return $properties->property_type;
                })
                ->addColumn('action', function ($properties) {
                    return '<a class="btn btn-danger btn-sm" href="/helper/property/edit/'.$properties->id.'">Edit</a>';  
                })
                ->addColumn('date', function ($properties) {
                    return date('F j, Y g:i a', strtotime($properties->created_at)) . ' | ' . $properties->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['title','price','offer_type','property_type','action','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getEditProperty($id) {

        $user = Auth::user();

        $property = Property::with('photos')->where('user_id',$user->id)->where('id',$id)->first();

        if($property) {

            return view('helper.property.edit')->with('user',$user)->with('property',$property);
        } else {
            
            return redirect('/helper/properties');
        }

    }

    public function postEditProperty($id, EditPropertyRequest $request) {

        try {

            $user = Auth::user();

            $property = Property::where('user_id',$user->id)->find($id);

            $available_at_date = Carbon::parse($request->available_from)->format('Y-m-d');
            
            $property->offer_type = $request->offer_type;
            $property->property_type = $request->property_type;
            $property->sub_type = $request->sub_type;
            $property->title = $request->title;
            $property->description = $request->description;
            $property->bedrooms = $request->bedrooms;
            $property->baths = $request->baths;
            $property->floor_area = $request->floor_area;
            $property->floor_number = $request->floor_number;
            $property->condominium_name = $request->condominium_name;
            $property->price = $request->price;
            $property->available_from = $available_at_date;
            $property->object_id = $request->object_id;
            $property->video_url = $request->video_url;
            $property->province = $request->province;
            $property->city = $request->city;
            $property->barangay = $request->barangay;
            $property->address = $request->address;
            $property->latitude = $request->latitude;
            $property->longitude = $request->longitude;
            $property->map = $request->map;
            $property->name = $request->name;
            $property->email = $request->email;
            $property->mobile = $request->mobile;
            $property->is_featured = $request->is_featured;
            
            $property->save();

            if($request->file('photos')) {

                foreach($request->file('photos') as $photo){

                    $photos = Photos::where('property_id', $id)->first();
                    $photoName = strtotime("now").'-'.str_replace(' ', '', $photo->getClientOriginalName());
                    $photo->move(public_path('media'.'/'.$property->id), $photoName);
                    $photos->property_id = $property->id;
                    $photos->filename = URL::asset('/media').'/'.$property->id.'/'.$photoName;
                    $photos->save();

                }
            }

            Session::flash('success', 'Property Successfully updated.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function getLeads() {

        $user = Auth::user();

        return view('helper.leads.list')->with('user',$user);
    }

    public function getLeadsData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();

            $properties = Inquiry::with('property')->orderBy('created_at','desc');
            
            if($properties){

                return Datatables::of($properties)
                ->editColumn('property', function ($properties) {
                    return $properties->property->title;
                })
                ->editColumn('name', function ($properties) {
                    return $properties->name; 
                })
                ->addColumn('phone', function ($properties) {
                    return $properties->phone;
                })
                ->editColumn('status', function ($properties) {
                    if($properties->status == "PENDING"){

                        return '<strong class="text-danger">'.$properties->status.'</strong>';
                    } elseif($properties->status == "TO FOLLOW") {

                        return '<strong class="text-warning">'.$properties->status.'</strong>';
                    } elseif($properties->status == "COMPLETED") {

                        return '<strong class="text-success">'.$properties->status.'</strong>';
                    }
                })
                ->addColumn('action', function ($properties) {
                    return '<a class="btn btn-success btn-sm" href="/helper/leads/'.$properties->id.'">View</a>';  
                })
                ->addColumn('date', function ($properties) {
                    return date('F j, Y g:i a', strtotime($properties->created_at)) . ' | ' . $properties->created_at->diffForHumans();
                })
                ->addIndexColumn()
                ->rawColumns(['property','name','phone','status','action','date'])
                ->make(true);

            }else{

                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again.'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getLeadDetails($id) {

        try {

            $user = Auth::user();

            $detail = Inquiry::with('property')->where('id',$id)->first();

            if(!$detail) {

                return redirect('/helper/leads');
            }

            return view('helper.leads.details')->with('user',$user)->with('detail',$detail);

        } catch(\Exception $e) {

            return redirect('/helper/leads');
        }
        
    }

    public function postLeadDetails($id, Request $request) {

        try {

            $user = Auth::user();

            $detail = Inquiry::find($id);

            if(!$detail) {

                return redirect('/helper/leads');
            }
            
            $detail->note = $request->note;
            $detail->status = $request->status;
            
            $detail->save();

            Session::flash('success', 'Lead Successfully updated.');
            return Redirect::back();

        } catch(\Exception $e) {

            return redirect('/helper/leads');
        }
        
    }

}
