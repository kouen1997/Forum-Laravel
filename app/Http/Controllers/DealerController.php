<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Account\TransferCodesRequest;
use App\Http\Requests\Account\TransferMasterFundRequest;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\User;
use App\Code;
use App\TransferCodes;
use App\MasterFund;
use App\TransferMasterFund;
use Hash;
use DB;

class DealerController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('dealer');
    }

    public function getDealer(){

        $user = Auth::user();

        return  view('dealer.dashboard')->with('user',$user);  
    }

    public function getDealerData(Request $request) {

        if ($request->wantsJson()) {
                
            $user = Auth::user();

            $total_fund = getDealerTotalMasterFund($user->id);
            $total_fund_transferred = getDealerTotalTransferredMasterFund($user->id);
            $total_codes = Code::where('user_id', $user->id)->where('status','UNUSED')->count();
            $total_codes_transferred = TransferCodes::select('transfer_by_user_id','transfer_to_user_id','code','created_at')->where('transfer_by_user_id',$user->id)->count();
            
            return response()->json(['total_fund'=> $total_fund, 'total_fund_transferred'=> $total_fund_transferred, 'total_codes'=> $total_codes,'total_codes_transferred'=> $total_codes_transferred],200); 
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getDealerTransferMasterFund(){

        $user = Auth::user();

        return  view('dealer.transfer-master-fund')->with('user',$user);  
    }

    public function getDealerTransferMasterFundData(Request $request) {

        if($request->wantsJson()) {


            $user = Auth::user();
            
            $transfer_fund = TransferMasterFund::select('transfer_by_user_id','transfer_to_user_id','amount','total','created_at')->where('transfer_by_user_id',$user->id)->orWhere('transfer_to_user_id',$user->id);

            return Datatables::of($transfer_fund)
                ->addColumn('message', function ($transfer_fund) {
                    if($transfer_fund->transfer_by_user_id == Auth::user()->id){
                        return '<span>You transfered master fund to <strong class="text-danger">'.$transfer_fund->transfer_to->username.'</strong></span>';
                    } elseif($transfer_fund->transfer_to_user_id == Auth::user()->id) {
                        return '<span>You received master fund from  <strong class="text-success">'.$transfer_fund->transfer_by->username.'</strong></span>';
                    }
                })
                ->editColumn('amount', function ($transfer_fund) {
                    return '<b>&#8369;'.number_format($transfer_fund->amount,2).'</b>';
                })
                ->editColumn('total', function ($transfer_fund) {
                    return '<b>&#8369;'.number_format($transfer_fund->total,2).'</b>';
                })
                ->addIndexColumn()
                ->rawColumns(['message','amount','total'])
                ->make(true);
            
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
                        
    }

    public function postDealerTransferMasterFund(TransferMasterFundRequest $request){
        if($request->wantsJson()) {

            try {   

                $user = Auth::user();
                $total_fund = getDealerTotalMasterFund($user->id);

                
                if($user->pin == $request->pin) {
                
                    $member = User::where('username',$request->username)->first();
                    if(!$member){
                        return response()->json(array("result"=>false,"message"=>'User doesnt exist.'),422);
                    } 
                        
                    if($total_fund < $request->amount){
                        return response()->json(array("result"=>false,"message"=>'Not enough master fund to transfer!'),422);
                    }
                        
                    $transfer = new TransferMasterFund;
                    $transfer->transfer_by_user_id = $user->id;
                    $transfer->transfer_to_user_id = $member->id;
                    $transfer->amount = $request->amount;
                    $transfer->total = $request->total;
                    $transfer->save();  

                    
                    return response()->json(array("result"=>true,"message"=>'Master fund successfully transferred!'),200);

                } else{
                    return response()->json(array("result"=>false,"message"=>'Wrong PIN! In case you forgot your PIN, email us at support@paysbook.co together with your login username (1-2 days processing)'),422);
                }                       
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'.$e),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getDealerTransferCodes(){

        $user = Auth::user();
        $codes = Code::where('user_id', $user->id)->where('status','UNUSED')->orderBy('created_at','desc')->take(500)->get();
        
        return  view('dealer.transfer-codes')->with('user',$user)->with('codes',$codes);       
    }

    public function getDealerTransferCodesData(Request $request){

        if($request->wantsJson()) {


            $user = Auth::user();
            
            $transfer_codes = TransferCodes::select('transfer_by_user_id','transfer_to_user_id','code','created_at')->where('transfer_by_user_id',$user->id)->orWhere('transfer_to_user_id',$user->id);

            return Datatables::of($transfer_codes)
                ->addColumn('message', function ($transfer_codes) {
                    if($transfer_codes->transfer_by_user_id == Auth::user()->id){
                        return '<span>You transfered activation code to <strong class="text-danger">'.$transfer_codes->transfer_to->username.'</strong></span>';
                    } elseif($transfer_codes->transfer_to_user_id == Auth::user()->id) {
                        return '<span>You received activation code from  <strong class="text-success">'.$transfer_codes->transfer_by->username.'</strong></span>';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['message'])
                ->make(true);
            
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function postDealerTransferCodes(TransferCodesRequest $request){
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
                        
                    
                    $code = Code::where('user_id',$user->id)->where('code',$request->activation_code)->where('status','UNUSED')->first();
                    if(!$code){
                        return response()->json(array("result"=>false,"message"=>'Something went wrong with your activation code.'),422);
                    }
                    
                    $quantity = $request->quantity;
                    $codes = Code::where('user_id',$user->id)->where('status','UNUSED')->orderBy('created_at','desc')->take($quantity)->get();

                    if($quantity > count($codes)){
                        return response()->json(array("result"=>false,"message"=>'Not enough available codes.'),422);
                    }     

                    if($quantity > 1){
                    
                        foreach($codes as $code){
                        
                            $code = Code::find($code->id);
                            $code->user_id = $member->id;
                            $code->owned_at = Carbon::now();;
                            $code->transfered_at = Carbon::now();;
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
                        $code->owned_at = Carbon::now();;
                        $code->transfered_at = Carbon::now();;
                        $code->touch();
                        $code->save();
                        
                        $transfer = new TransferCodes;
                        $transfer->transfer_by_user_id = $user->id;
                        $transfer->transfer_to_user_id = $member->id;
                        $transfer->code = $code->code;
                        $transfer->save();  
                    }
                    
                    return response()->json(array("result"=>true,"message"=>'Activation Code Successfully transfered!'),200);

                } else{
                    return response()->json(array("result"=>false,"message"=>'Wrong PIN! In case you forgot your PIN, email us at support@paysbook.co together with your login username (1-2 days processing)'),422);
                }                       
                
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'.$e),422);
            }
                
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }


}
