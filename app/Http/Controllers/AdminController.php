<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\CreateMemberRequest;
use App\Http\Requests\Admin\UpdateMemberProfileRequest;
use App\Http\Requests\Admin\UpdateMemberPasswordRequest;
use App\Http\Requests\Admin\UpdateMemberPinRequest;
use App\Http\Requests\Admin\UpdateMemberSponsorRequest;
use App\Http\Requests\Admin\UpdateMemberBdoAccountRequest;
use App\Http\Requests\Admin\UpdateMemberYazzAccountRequest;
use App\Http\Requests\Admin\UpdateMemberBdoAttemptRequest;
use App\Http\Requests\Admin\TransferCodesRequest;
use App\Http\Requests\Admin\SetTruemoneyCardRequest;
use App\Http\Requests\Admin\AddLoadWalletRequest;
use App\Http\Requests\Admin\MasterFundRequest;
use App\Http\Requests\Admin\RetrieveMasterFundRequest;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\EditProductRequest;
use App\Http\Requests\Admin\AddPropertyRequest;
use App\Http\Requests\Admin\EditPropertyRequest;
use App\Http\Requests\Support\CommentsRequest;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Excel;
use Carbon\Carbon;
use App\User;
use App\Account;
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
use App\WithdrawalBDOExport;
use App\Truemoney;
use App\TruemoneyWithdrawal;
use App\LoadWallet;
use App\LoadCharge;
use App\Suspended;
use App\BdoAccount;
use App\AtmKyc;
use App\AtmAccount;
use App\Payment;
use App\MasterFund;
use App\Booking;
use App\BookingSettings;
use App\Settings;
use App\Tickets;
use App\TicketComments;
use App\Product;
use App\Order;
use App\YazzAccount;
use App\Property;
use App\Photos;
use App\InteriorDesign;
use App\ArchitecturalDesign;
use Session;
use Redirect;
use Cache;
use Hash;
use DB;
use PDF;
use URL;
use File;
use DateTime;

class AdminController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function getAdmin(){

        $user = Auth::user();
        
        return  view('admin.dashboard')->with('user',$user);      
    }

    public function getAdminData(Request $request) {

        if ($request->wantsJson()) {
             
            $user = Auth::user();       

            $total_users = User::where('role',1)->count();
            $total_accounts = Account::where('status','PAID')->count();
            $total_code_request = CodeRequest::where('status','PENDING')->count();
            $total_unused_codes = Code::where('user_id', NULL)->where('status','UNUSED')->count();


            $withdrawal_paid = Withdrawal::where('status','PAID');
            $count_withrawal_paid = $withdrawal_paid->count();
            $sum_withrawal_paid = $withdrawal_paid->sum('amount');

            $withdrawal_pending = Withdrawal::where('status','PENDING');
            $count_withrawal_pending = $withdrawal_pending->count();
            $sum_withrawal_pending = $withdrawal_pending->sum('amount');

            $truemoney_withdrawal_paid = TruemoneyWithdrawal::where('status','PAID');
            $count_truemoney_withrawal_paid = $truemoney_withdrawal_paid->count();
            $sum_truemoney_withrawal_paid = $truemoney_withdrawal_paid->sum('amount');

            $truemoney_withdrawal_pending = TruemoneyWithdrawal::where('status','PENDING');
            $count_truemoney_withrawal_pending = $truemoney_withdrawal_pending->count();
            $sum_truemoney_withrawal_pending = $truemoney_withdrawal_pending->sum('amount');

            
            $total_buy_code = BuyCode::where('status',0)->count();
            
            //$top_ten_month = DB::select(DB::raw("SELECT f.id, f.first_name, f.last_name, x.amount FROM ( SELECT user_id,created_at, SUM(amount) AS amount FROM tbl_withdrawals WHERE status = 'PAID' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY user_id ) AS x INNER JOIN tbl_users as f ON f.id = x.user_id ORDER BY amount DESC LIMIT 10"));
            

            //$top_ten_all = DB::select(DB::raw("SELECT f.id, f.first_name, f.last_name, x.amount FROM ( SELECT user_id,created_at, SUM(amount) AS amount FROM tbl_withdrawals WHERE status = 'PAID' GROUP BY user_id ) AS x INNER JOIN tbl_users as f ON f.id = x.user_id ORDER BY amount DESC LIMIT 10"));

            $open = Tickets::where('agent_id',$user->id)->where('status','OPEN')->count();
            $completed = Tickets::where('agent_id',$user->id)->where('status','COMPLETED')->count();

            return response()->json(['total_users' => $total_users, 'total_accounts' => $total_accounts, 'total_buy_code' => $total_buy_code, 'total_code_request' => $total_code_request, 'total_unused_codes' => $total_unused_codes,
                'paid' => [
                    'count' => $count_withrawal_paid,
                    'sum' => $sum_withrawal_paid
                ],
                'pending' => [
                    'count' => $count_withrawal_pending,
                    'sum' => $sum_withrawal_pending
                ],
                'total_net_sale' => ($total_accounts * 900) - ($sum_withrawal_paid + ($total_buy_code * 1000)),
                //'top_ten_month' => $top_ten_month,
                //'top_ten_all' => $top_ten_all,
                'open' => $open,
                'completed' => $completed

            ],200);
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getSuspended() {

        $user = Auth::user();
        
        return  view('admin.suspended')->with('user',$user);  
    }

    public function postAdminSuspendedRetrieve(Request $request) {

        if ($request->wantsJson()) {

                //find user
                $user = User::find($request->user_id);

                if($user){

                    $user->suspended = 0;
                    $user->verified = 1;
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Account successfully retrieved and marked as verified.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found!'),422);
                }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function postAdminSuspendedBan(Request $request) {

        if ($request->wantsJson()) {

                //find user
                $user = User::find($request->user_id);

                if($user){

                    $user->suspended = 0;
                    $user->banned = 1;
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Account successfully banned.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'User not found.'),422);
                }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getAdminSuspendedData(Request $request) {

        if ($request->wantsJson()) {

            $suspended =  User::whereSuspended(1)->get();

            return Datatables::of($suspended)
                ->addColumn('member', function ($suspended) {
                    return $suspended->full_name;
                })
                ->addColumn('username', function ($suspended) {
                    return $suspended->username;
                })
                ->addColumn('action', function ($suspended) {
                    return '<button class="btn btn-lime btn-sm" onclick="angular.element(this).scope().frm.retrieve('.$suspended->id.')" >Retrieve</button>
                            <button class="btn btn-danger btn-sm" onclick="angular.element(this).scope().frm.ban('.$suspended->id.')" >Ban</button>';
                })
                ->addIndexColumn()
                ->rawColumns(['member','username','action'])
                ->make(true); 

         } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getAdminMembers(){

        $user = Auth::user();
        
        return  view('admin.members')->with('user',$user);      
    }

    public function getAdminMembersInfo($id) {

        $user = User::find($id);

        if(!BdoAccount::where('user_id',$user->id)->first()){
            $bdo_account = new BdoAccount;
            $bdo_account->user_id = $user->id;
            $bdo_account->save(); 
        }

        if(!YazzAccount::where('user_id',$user->id)->first()){
            $yazz_account = new YazzAccount;
            $yazz_account->user_id = $user->id;
            $yazz_account->save(); 
        }

        $ecomnnect_wallet = getTotalPoints($user->id);
        
        return  view('admin.members-info')->with('user',$user)->with('ecomnnect_wallet',$ecomnnect_wallet);  
    }

    public function getAdminMembersInfoData($id, Request $request) {

        if ($request->wantsJson()) {

            $user = User::find($id);

            $earnings = getEarnings($user->id);
            $dashboard_count = getDashboardCounts($user->id); 
            
            return response()->json(['earnings'=> $earnings, 'dashboard_count'=> $dashboard_count],200); 

         } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getAdminMembersData(Request $request) {

        if ($request->wantsJson()) {
                

            if($sponsor = $request->sponsor){   

                $members = User::with('code','code_unused','sponsor','sponsored','paid_account','free_account')->where('role',1)
                            ->where('sponsor_username',$sponsor)->orderBy('created_at','DESC')->take(200)->get();               
            } else {
        
                if($username = $request->username) {

                    $members = User::with('code','code_unused','sponsor','sponsored','paid_account','free_account')->where('role',1)->where('username', $username)->orderBy('created_at','DESC')->get();
                } else if($name = $request->name) {

                    $search = '%'.$name.'%';

                    $members = User::with('code','code_unused','sponsor','sponsored','paid_account','free_account')->where('role',1)->where(DB::raw('concat(first_name," ",last_name)') , 'LIKE' , $search)->orderBy('created_at','DESC')->get();

                } else {
                    $members = User::with('code','code_unused','sponsor','sponsored','paid_account','free_account')->where('role',1)
                                ->orderBy('created_at','DESC')->take(200)->get();
                }
            }

            return response()->json(['members'=> $members],200); 
            
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postAdminMembersCreate(CreateMemberRequest $request) {

        if ($request->wantsJson()) {
                

            try {

                //find sponsor
                $sponsor = User::where('username',$request->sponsor)->first();

                if($sponsor){

                    $user = new User;
                    $user->first_name = $request->first_name;
                    $user->last_name = $request->last_name;
                    $user->email = $request->email;
                    $user->mobile = $request->mobile;
                    $user->username = $request->username;
                    $user->password = bcrypt($request->password);
                    $user->sponsor_id = $sponsor->id;
                    $user->sponsor_username = $sponsor->username;
                    $user->role = $request->role;
                    $user->pin = $request->pin;
                    $user->save();

                    return response()->json(array("result"=>true,"message"=>'Member Successfully created.'),200);
                    
                } else {

                    return response()->json(array("result"=>false,"message"=>'Sponsor not found!'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function postAdminMembersProfile($id, UpdateMemberProfileRequest $request) {

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

    public function postAdminMembersPassword($id, UpdateMemberPasswordRequest $request) {

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

    public function postAdminMembersPin($id, UpdateMemberPinRequest $request) {

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

    public function postAdminMembersSponsor($id, UpdateMemberSponsorRequest $request) {

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

    public function getAdminAccounts(){

        $user = Auth::user();
        
        return  view('admin.accounts')->with('user',$user);      
    }

    public function getAdminAccountsData(Request $request) {

        if ($request->wantsJson()) {
        
            if($user_id = $request->user_id){

                $accounts = Account::with('user')->where('user_id', $user_id)->orderBy('created_at','desc')->get();
                
            } else {
        
                if($search = $request->search) {
                    $accounts = Account::with('user')
                    ->where(function($query) use($search){
                        $query->where('account_name', 'LIKE', '%'.$search.'%' )
                        ->orWhere('activation_code', 'LIKE', '%'.$search.'%')
                        ->orWhere('parent_account_name', 'LIKE', '%'.$search.'%');
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

    public function getSubscribers(){

        $user = Auth::user();
        
        return  view('admin.subscribers')->with('user',$user);       
    }

    public function getSubscribersData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();
    
            $subscribers = User::orderBy('created_at','desc');
            
            if($subscribers){

                return Datatables::of($subscribers)
                ->editColumn('name', function ($subscribers) {
                    return ucwords($subscribers->full_name);
                })
                ->editColumn('username', function ($subscribers) {
                    return $subscribers->username; 
                })
                ->addColumn('mobile', function ($subscribers) {
                    return $subscribers->mobile;
                })
                ->editColumn('status', function ($subscribers) {
                    if($subscribers->active == 1){
                        return '<span class="text-success">ACTIVE</span>';
                    } elseif($subscribers->active == 0) {
                        return '<span class="text-danger">INACTIVE</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($subscribers) {
                    return 'no actiion';
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

    public function getAdminTransferCodes(){

        $user = Auth::user();
        $codes = Code::where('user_id', NULL)->where('status','UNUSED')->orderBy('created_at','desc')->take(500)->get();
        
        return  view('admin.transfer-codes')->with('user',$user)->with('codes',$codes);       
    }

    public function getAdminTransferCodesHistory(){

        $user = Auth::user();
        $codes = Code::where('user_id', NULL)->where('status','UNUSED')->orderBy('created_at','desc')->take(500)->get();
        
        return  view('admin.activation-codes-history')->with('user',$user)->with('codes',$codes);       
    }

    public function getAdminTransferCodesData(Request $request){

        if($request->wantsJson()) {

            $transfer_codes = TransferCodes::with('transfer_by','transfer_to')->orderBy('created_at','desc')->take(100);

            return Datatables::of($transfer_codes)
                ->editColumn('details', function ($transfer_codes) {
                    return '<span><b>'. $transfer_codes->transfer_by->username .'</b> transferred code to <strong class="text-danger">'.$transfer_codes->transfer_to->username.'</strong></span>';
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

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postAdminTransferCodes(TransferCodesRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();

                if($user->username == $request->username){
                    return response()->json(array("result"=>false,"message"=>'Code\'s alread belong to you.'),422);
                }
                
                if($user->pin == $request->pin) {
                
                    $member = User::where('username',$request->username)->orWhere('email',$request->username)->first();
                    if(!$member){
                        return response()->json(array("result"=>false,"message"=>'User not found.'),422);
                    }
                    
                    $quantity = $request->quantity;
                    $codes = Code::where('user_id',NULL)->where('status','UNUSED')->where('code_type',$request->code_type)->orderBy('created_at','desc')->take($quantity)->get();

                    if($quantity > count($codes)){
                        return response()->json(array("result"=>false,"message"=>'Not enough available codes.'),422);
                    }
                    
                    $code = Code::where('user_id',NULL)->where('code_type',$request->code_type)->where('status','UNUSED')->first();
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

    public function getAdminGenerateCodes() {

        $user = Auth::user();
        
        return  view('admin.generate-codes')->with('user',$user);

    }

    public function postAdminGenerateCodes(Request $request) {

        if ($request->wantsJson()) {

            if($request->code_type == 'PAID'){

                for($x = 1; $x <= $request->quantity; $x++){
                    $alphabet = '1qw2e?rtyu(io3pasd4f*ghj5]klzx+6c)vbnmP7?OIUYT8R@EWQLK9JHGFD#SAMN[BVC%XZ0';
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 10; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }

                    $code = Code::where('code', implode($pass))->first();
                    if(!$code){
                        $code = new Code;
                        $code->code = implode($pass);
                        $code->save();
                        $code = substr(md5(uniqid(mt_rand(), true)) , 0, 10);
                        $code = strToUpper($code);
                    }
                    
                }
            } elseif($request->code_type == 'FREE') {

                for($x = 1; $x <= $request->quantity; $x++){
                    $alphabet = '1qw2e?rtyu(io3pasd4f*ghj5]klzx+6c)vbnmP7?OIUYT8R@EWQLK9JHGFD#SAMN[BVC%XZ0';
                    $pass = array(); //remember to declare $pass as an array
                    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                    for ($i = 0; $i < 10; $i++) {
                        $n = rand(0, $alphaLength);
                        $pass[] = $alphabet[$n];
                    }

                    $code = Code::where('code', 'F-'.implode($pass))->first();
                    if(!$code){
                        $code = new Code;
                        $code->code_type = 'FREE';
                        $code->code = 'F-'.implode($pass);
                        $code->save();
                        $code = substr(md5(uniqid(mt_rand(), true)) , 0, 10);
                        $code = strToUpper($code);
                    }
                    
                }
            }

            return response()->json(array("result"=>true,"message"=> "Successfully generated ".$request->quantity." codes.") ,200);

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getAdminActivationCodes() {

        $user = Auth::user();
        
        return  view('admin.activation-codes')->with('user',$user);

    }

    public function getAdminActivationCodesData(Request $request) {

        if ($request->wantsJson()) {



            if($search_user = $request->search_user) {

                //find user 
                $users = User::where('username',$search_user)->orWhere('first_name','like', '%'.$search_user.'%' )->get();
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

    public function getAdminActivationCodesRetrieve($id, Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();

            $code = Code::where('id',$id)->where('status',"UNUSED")->first();
            if($code){ 

                $from = User::where('id',$code->user_id )->first();

                if($from){   
                
                    $code->user_id = NULL;
                    $code->used_by_user_id = NULL;
                    $code->owned_at = NULL;
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

    public function getAdminSettings() {

        $user = Auth::user();

        return  view('admin.settings')->with('user',$user);

    }

    public function postAdminSettings(UpdateSettingRequest $request) {

        if ($request->wantsJson()) {

            $settings = $request->except('_token');

            Settings::set($settings);

            return response()->json(array("result"=>true,"message"=>'Setting successfully updated.'),200);


         } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function postHelperBan($id) {

        //find user
        $user = User::find($id);

        if($user){

            $user->suspended = 0;
            $user->banned = 1;
            $user->save();
            
            return redirect('/admin/members');
            
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

            return redirect('/admin/members');
            
        } else {

            return response()->json(array("result"=>false,"message"=>'User not found.'),422);

        }

    }

    //Leads
    public function getAddProperty() {

        $user = Auth::user();

        return view('admin.property.add')->with('user',$user);
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
                    
                    $photos->property_id = $property->id;
                    $photos->filename = '/media/'.$property->id.'/'.$photoName;

                    $phototoUpload = count($request->file('photos'));

                    if($phototoUpload > 10){
                        
                        Session::flash('danger', 'You can only upload 10 images');
                        $property->delete();

                    }else{


                        $photo->move(public_path('media'.'/'.$property->id), $photoName);
                        Session::flash('success', 'Property Successfully added.');
                        $photos->save();
                    }

                }
            }

            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function getProperties() {

        $user = Auth::user();

        return view('admin.property.list')->with('user',$user);
    }

    public function getPropertiesData(Request $request) {

        if ($request->wantsJson()) {

            $properties = Property::orderBy('created_at','desc');
            
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
                    return '<a class="btn btn-info btn-sm" href="/admin/property/edit/'.$properties->id.'"><i class="fa fa-edit"></i> Edit</a>

                        <div class="btn btn-danger btn-sm delete_properties_'.$properties->id.'" style="color: #fff; cursor: pointer;" ng-click="frm.deleteProperty('.$properties->id.')"><i class="fa fa-times-circle"></i> Delete</div>';  
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

        $property = Property::with('photos')->where('id',$id)->first();

        if($property) {

            return view('admin.property.edit')->with('user',$user)->with('property',$property);
        } else {
            
            return redirect('/admin/properties');
        }

    }

    public function postEditProperty($id, EditPropertyRequest $request) {

        try {

            $user = Auth::user();

            $property = Property::where('id', $id)->first();

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

                    $photos = new Photos;

                    $photoName = strtotime("now").'-'.str_replace(' ', '', $photo->getClientOriginalName());
                    
                    $photos->property_id = $property->id;
                    $photos->filename = '/media/'.$photos->property_id.'/'.$photoName;

                    $photoCount = 10 - $property->photos->count();

                    $phototoUpload = count($request->file('photos'));

                    if($phototoUpload > $photoCount){

                        Session::flash('danger', 'image not successfully uploaded you can only upload '.$photoCount.' photos/s');
                        

                    }else{

                        $photo->move(public_path('media'.'/'.$property->id), $photoName);

                        $photos->save();

                    }
                }
            }

            Session::flash('success', 'Property Successfully edited.');
            return Redirect::back();

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
        }
    }

    public function postDeleteProperty(Request $request, $property_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $photos = Photos::where('property_id', $property_id)->get();

                foreach ($photos as $key => $photo) {
                    
                    $file_path = public_path().$photo->filename;

                    if(file_exists($file_path)){

                        if(!empty($photo->filename)){
                            unlink($file_path);
                        }
                        
                    }

                    $photo->delete();

                }

                File::deleteDirectory(public_path('media/'.$property_id.'/'));

                $property = Property::find($property_id);

                $property->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
    }
    public function getInteriorDesignListing()
    {
        try{

            $user = Auth::user();

            if($user){

                $interior_designs = InteriorDesign::latest()->paginate(20);
                return view('admin.interior_design_listing', compact('interior_designs'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }


    public function getInteriorDesignListingPage()
    {
        try{

            $user = Auth::user();

            if($user){

              $interior_designs = InteriorDesign::latest()->paginate(20);

              $responseHtml = view('admin.interior_design_data', compact('interior_designs'))->render();

              return response()->json(['status' => 'success', 'responseHtml' => $responseHtml]);

            }

        }catch(\Exception $e){

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
        
    }

    public function getInteriorDesignListingSearch(Request $request){

        try{

            $user = Auth::user();

            if($user){

                if($request->wantsJson()) {

                    $interior_designs = InteriorDesign::where('property_type', 'LIKE', "%$request->search%")->latest()->paginate(20);

                    $responseHtml = view('admin.interior_design_data', compact('interior_designs'))->render();

                    return response()->json(['status' => 'success', 'responseHtml' => $responseHtml]);

                }
            }

        }catch(\Exception $e){

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
        

    }
    
    public function getArchitecturalDesignListing()
    {
        try{

            $user = Auth::user();

            if($user){

                $architectural_designs = ArchitecturalDesign::latest()->paginate(20);
                return view('admin.architectural_design_listing', compact('architectural_designs'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function getArchitecturalDesignListingPage()
    {
        try{

            $user = Auth::user();

            if($user){

              $architectural_designs = ArchitecturalDesign::latest()->paginate(20);

              $responseHtml = view('admin.architectural_design_data', compact('architectural_designs'))->render();

              return response()->json(['status' => 'success', 'responseHtml' => $responseHtml]);

            }

        }catch(\Exception $e){

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
        
    }

    public function getArchitecturalDesignListingSearch(Request $request){

        try{

            $user = Auth::user();

            if($user){

                if($request->wantsJson()) {

                    $architectural_designs = ArchitecturalDesign::where('property_type', 'LIKE', "%$request->search%")->latest()->paginate(20);

                    $responseHtml = view('admin.architectural_design_data', compact('architectural_designs'))->render();

                    return response()->json(['status' => 'success', 'responseHtml' => $responseHtml]);

                }
            }

        }catch(\Exception $e){

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
        

    }

    public function postDeleteImage(Request $request, $image_id) {

        try{

            $user = Auth::user();

            if($user){

                $photos = Photos::find($image_id);

                $file_path = public_path().$photos->filename;

                if(file_exists($file_path)){

                    if(!empty($photos->filename)){
                        unlink($file_path);
                    }
                    
                }

                $photos->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }


}
