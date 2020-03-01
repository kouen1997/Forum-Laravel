<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Support\CommentsRequest;
use App\Http\Requests\Support\BookingExtraFeeRequest;
use App\Http\Requests\Payout\ReceiptRequest;
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
use App\WithdrawalExport;
use App\WithdrawalBDOExport;
use App\WithdrawalYazzExport;
use App\Truemoney;
use App\TruemoneyWithdrawal;
use App\LoadWallet;
use App\LoadCharge;
use App\Tickets;
use App\TicketComments;
use App\AtmKyc;
use App\AtmAccount;
use App\Product;
use App\Order;
use App\Settings;
use App\ResellerKyc;
use App\Booking;
use App\BookingSettings;
use App\BookingExtraFee;
use Session;
use Redirect;
use Hash;
use DB;
use URL;
use Cache;
use PDF;
use DateTime;

class SupportController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('support');
    }

    public function getSupport(){

        $user = Auth::user();

        return  view('support.dashboard')->with('user',$user);  
    }

    public function getSupportData(Request $request) {

        if ($request->wantsJson()) {
                
            $user = Auth::user();
            $open = Tickets::where('agent_id',$user->id)->where('status','OPEN')->count();
            $completed = Tickets::where('agent_id',$user->id)->where('status','COMPLETED')->count();

            $withdrawal_paid = Withdrawal::where('mode','REMITTANCE')->where('status','PAID');
            $count_withrawal_paid = $withdrawal_paid->count();
            $sum_withrawal_paid = $withdrawal_paid->sum('amount');

            $withdrawal_pending = Withdrawal::where('mode','REMITTANCE')->where('status','PENDING');
            $count_withrawal_pending = $withdrawal_pending->count();
            $sum_withrawal_pending = $withdrawal_pending->sum('amount');

            $withdrawal_bdo_paid = Withdrawal::where('mode','BDO')->where('status','PAID');
            $count_withrawal_bdo_paid = $withdrawal_bdo_paid->count();
            $sum_withrawal_bdo_paid = $withdrawal_bdo_paid->sum('amount');

            $withdrawal_bdo_pending = Withdrawal::where('mode','BDO')->where('status','PENDING');
            $count_withrawal_bdo_pending = $withdrawal_bdo_pending->count();
            $sum_withrawal_bdo_pending = $withdrawal_bdo_pending->sum('amount');

            $paid_orders = Order::where('status','PAID');
            $count_paid_orders = $paid_orders->count();
            $sum_paid_orders = $paid_orders->sum('total_price');

            $pending_orders = Order::where('status','PENDING');
            $count_pending_orders = $pending_orders->count();
            $sum_pending_orders = $pending_orders->sum('total_price');


            return response()->json(['open'=> $open, 'completed'=> $completed,
                'paid' => [
                    'count' => $count_withrawal_paid,
                    'sum' => $sum_withrawal_paid,
                    'bdo_count' => $count_withrawal_bdo_paid,
                    'bdo_sum' => $sum_withrawal_bdo_paid
                ],
                'pending' => [
                    'count' => $count_withrawal_pending,
                    'sum' => $sum_withrawal_pending,
                    'bdo_count' => $count_withrawal_bdo_pending,
                    'bdo_sum' => $sum_withrawal_bdo_pending
                ],
                'orders' => [
                    'pending' => [
                        'count' => $count_pending_orders,
                        'sum' => $sum_pending_orders
                    ],
                    'paid' => [
                        'count' => $count_paid_orders,
                        'sum' => $sum_paid_orders
                    ]
                ]
            ],200); 

        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }  

     public function getTickets(){

        $user = Auth::user();

        return  view('support.tickets')->with('user',$user);  
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
                    return '<a href="/support/customer-support/ticket/'.$tickets->id.'" target="_blank">'.$tickets->subject.'</a>';
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
            return redirect('/support/customer-support');
        }


        return  view('support.view-ticket')->with('user',$user)->with('tickets',$tickets);
    }     

    public function getMarkCompleted($id, Request $request){

        $user = Auth::user();
        
        $tickets = Tickets::where('id',$id)->where('agent_id',$user->id)->first();

        if(!$tickets){
            Session::flash('danger', "Ticket not found or not belong to you!");
            return redirect('/support/customer-support');
        }

        $tickets->status = 'COMPLETED';
        $tickets->save();

        Session::flash('success', "Ticket successfully marked as completed!");
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

    public function getSupportEncashments(){

        $user = Auth::user();
        
        return  view('support.encashments')->with('user',$user);      
    }

    public function getSupportBDOEncashments(){

        $user = Auth::user();
        
        return  view('support.bdo-encashments')->with('user',$user);      
    }

    public function postSupportEncashmentsPaidAll(){

       $withdrawals = Withdrawal::where('mode','YAZZ')->where('status','PENDING')->get();

       foreach ($withdrawals as $key => $withdrawal) {
            $withdrawal->status = 'PAID';
            $withdrawal->transact_at = Carbon::now();
            $withdrawal->save();
       }

       return response()->json(array("result"=>true,"message"=>'Successfully Paid All Pending Payouts!'),200);
    }

    public function postSupportBDOEncashmentsPaidAll(){

        $withdrawals = Withdrawal::where('mode','BDO')->where('status','PENDING')->get();
 
        foreach ($withdrawals as $key => $withdrawal) {
             $withdrawal->status = 'PAID';
             $withdrawal->transact_at = Carbon::now();
             $withdrawal->save();
        }
 
        return response()->json(array("result"=>true,"message"=>'Successfully Paid All Pending Payouts!'),200);
     }

    public function postSupportEncashmentsStatus($id, Request $request) {

        if ($request->wantsJson()) {

                //find encashment
                $withdrawal = Withdrawal::find($id);

                if($withdrawal){


                    if($withdrawal->mode == "PAYSBOOK ATM"){

                    } else {

                        $withdrawal->status = $request->status;
                        $withdrawal->transact_at = Carbon::now();
                        $withdrawal->save();

                        return response()->json(array("result"=>true,"message"=>'Status Successfully Updated'),200);

                    }
                                        
                } else {

                    return response()->json(array("result"=>false,"message"=>'Encashment not found!'),422);
                }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function postSupportEncashmentsReceipt($id, ReceiptRequest $request) {

        if ($request->wantsJson()) {

            $withdrawal = Withdrawal::find($id);

            if($withdrawal){


                if($request->file('receipt')) {


                    $receipt = $request->file('receipt');

                    $strippedName = str_replace(' ', '', $receipt->getClientOriginalName());
                    $photoName = $withdrawal->id.'-'.$strippedName;

                    $receipt->move(public_path('receipt'), $photoName);

                    $withdrawal->receipt = URL::asset('/receipt').'/'.$photoName;
                    $withdrawal->save();


                    return response()->json(array("result"=>true,"message"=>'Receipt Successfully Uploaded!'),200);

                } else {

                    return response()->json(array("result"=>false,"message"=>'Receipt photo not found!'),422);
                }
                                    
            } else {

                return response()->json(array("result"=>false,"message"=>'Encashment not found!'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getSupportEncashmentsData(Request $request) {

        if ($request->wantsJson()) {
                
            if ($request->has('mid_by')) {
                
                $mid =$request->mid_by;
                if ($request->has('sort_by')) {
                    $sort = $request->sort_by;
                    $withdrawal = Withdrawal::with('user')->where('user_id',$mid)->where('mode','REMITTANCE')->where('status',$sort)->orderBy('created_at','desc');
                }else{
                    $withdrawal = Withdrawal::with('user')->where('mode','REMITTANCE')->where('user_id',$mid)->orderBy('created_at','desc');
                }   

            } elseif($request->has('sort_by')) {
                $sort = $request->sort_by;
                if ($request->has('order_by')) {
                    $order = $request->order_by;
                    $withdrawal = Withdrawal::with('user')->where('mode','REMITTANCE')->where('status',$sort)->orderBy('created_at','desc');

                } else {

                    if($sort == 'RECENT'){
                        $withdrawal = Withdrawal::with('user')->where('mode','REMITTANCE')->orderBy('created_at','desc');
                    } else {
                        $withdrawal = Withdrawal::with('user')->where('mode','REMITTANCE')->where('status', $sort)->orderBy('created_at','desc');
                    }
                    
                }                   
            } elseif($request->has('order_by')) {

                $order = $request->order_by;
                $withdrawal = Withdrawal::with('user')->where('mode','REMITTANCE')->where('details', 'LIKE', '%'. $order .'%')->orderBy('created_at','desc');

            } else {

                $withdrawal = Withdrawal::with('user')->where('mode','REMITTANCE')->orderBy('created_at','desc'); 
            }

            return Datatables::of($withdrawal)
                ->editColumn('amount', function ($withdrawal) {
                    return 'Sub Total: &#8369;<strong>'.number_format($withdrawal->amount).'</strong>
                        <p>10% withholding tax: <span class="text-danger">&#8369;'. number_format((10 / 100  * $withdrawal->amount)) .'</span><br>
                        Service Charge: <span class="text-danger">&#8369;100</span></p>
                        <strong>TOTAL: &#8369;'.number_format($withdrawal->amount - (( 10 / 100 ) * $withdrawal->amount ) - 100).'</span></strong>';
                })
                ->editColumn('status', function ($withdrawal) {
                    if($withdrawal->status == "PENDING"){
                        return '<strong class="text-warning">'.$withdrawal->status.'</strong>'; 
                    } elseif ($withdrawal->status == "PAID") {
                        return '<strong class="text-success">'.$withdrawal->status.'</strong>'; 
                    } else {
                        return '<strong class="text-danger">'.$withdrawal->status.'</strong>'; 
                    }
                })
                ->editColumn('mode', function ($withdrawal) {
                    if($withdrawal->mode == "DEALER OFW"){
                        return $withdrawal->mode.'<br><strong class="text-info">'.$withdrawal->dealer_name.'</strong><br>Location: '.$withdrawal->location;
                    } else {
                        return $withdrawal->mode.'<br><strong class="text-info">'.$withdrawal->dealer_name.'</strong>';
                    }
                })
                ->editColumn('details', '{!! nl2br($details) !!}') 
                ->editColumn('transact_at', function ($withdrawal) {
                    if($withdrawal->transact_at == null){
                        return '';
                    } else {
                        return $withdrawal->transact_at;
                    }
                })
                ->addColumn('action', function ($withdrawal) {
                    if($withdrawal->status == 'PENDING'){
                        if($withdrawal->receipt == NULL || $withdrawal->receipt  == ''){
                            return '
                        <small id="processing'.$withdrawal->id.'" style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option selected="selected" value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>
                        <br>
                        <button id="receipt_btn_'.$withdrawal->id.'" class="btn btn-lime btn-sm"  onclick="angular.element(this).scope().frm.selectFile('.$withdrawal->id.')" >Upload Receipt</button>
                         <input type="file" style="display:none" 
                            id="file_'.$withdrawal->id.'" name="file_'.$withdrawal->id.'" accept="image/jpeg,image/png,image/gif" onchange="angular.element(this).scope().frm.fileNameChanged('.$withdrawal->id.')" />
                        <br>
                        <br> 
                        <button class="btn btn-lime btn-sm"  onclick="angular.element(this).scope().frm.midby('.$withdrawal->user_id.')" >view all</button> 
                        <div class="clearfix"></div>
                        <br>
                        <a class="btn btn-lime btn-sm" href="/support/encashments/'.$withdrawal->id.'" target="_blank"><div class="clearfix"></div>open</a>';

                        } else {
                            return '
                        <small id="processing'.$withdrawal->id.'" style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option selected="selected" value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>
                        
                        <br> 
                        <button class="btn btn-lime btn-sm"  onclick="angular.element(this).scope().frm.midby('.$withdrawal->user_id.')" >view all</button> 
                        <div class="clearfix"></div>
                        <br>
                        <a class="btn btn-lime btn-sm" href="/support/encashments/'.$withdrawal->id.'" target="_blank"><div class="clearfix"></div>open</a>';
                        }
                    
                    } elseif ($withdrawal->status == "CANCELLED") {
                    return '
                        <small id="processing'.$withdrawal->id.'"style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option value="PENDING">PENDING</option> 
                            <option selected="selected"  value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>
                        <br>
                        <button class="btn btn-lime btn-sm"  onclick="angular.element(this).scope().frm.midby('.$withdrawal->user_id.')" >view all</button> 
                        <div class="clearfix"></div>
                        <br>
                        <a class="btn btn-lime btn-sm" href="/support/encashments/'.$withdrawal->id.'" target="_blank"><div class="clearfix"></div>open</a>';

                    } else {

                    return '
                        <small id="processing'.$withdrawal->id.'"style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option  selected="selected" value="PAID">PAID</option>
                        </select>
                        <br>
                        <button class="btn btn-lime btn-sm"  onclick="angular.element(this).scope().frm.midby('.$withdrawal->user_id.')" >view all</button> 
                        <div class="clearfix"></div>
                        <br>
                        <a class="btn btn-lime btn-sm" href="/support/encashments/'.$withdrawal->id.'" target="_blank"><div class="clearfix"></div>open</a>';

                    } 
                })
                ->addColumn('checkbox', function ($withdrawal) {

                    if($withdrawal->status == 'PENDING'){
                        return '<input type="checkbox" id="'.$withdrawal->id.'" name="withdrawal_id" value="'.$withdrawal->id.'" />';
                    } else {
                        return '<input type="checkbox" disabled/>';
                    }
                })
                ->addColumn('date', function ($withdrawal) {
                    if($withdrawal->transact_at == NULL){
                        return '<strong>Requested At:</strong><br>'.$withdrawal->created_at;
                    } else {
                        return '<strong>Requested:</strong><br>'.$withdrawal->created_at.'<br><strong>Processed At:</strong><br>'.$withdrawal->transact_at;
                    }
                    
                })
                //->editColumn('receipt', function ($withdrawal) {
                //    if($withdrawal->receipt != NULL){
                //        return '<img src="'.$withdrawal->receipt.'" class="img img-responsive img-thumbail" height="100px;">';
                //    } else {
                //        return '';
                //    }
                //})
                ->addIndexColumn()
                ->rawColumns(['amount','status','mode','details','action','checkbox','date'])
                ->make(true);
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getSupportBDOEncashmentsData(Request $request) {

        if ($request->wantsJson()) {
                
            if ($request->has('mid_by')) {
                
                $mid =$request->mid_by;
                if ($request->has('sort_by')) {
                    $sort = $request->sort_by;
                    $withdrawal = Withdrawal::with('user')->where('user_id',$mid)->where('mode','BDO')->where('status',$sort)->orderBy('created_at','desc');
                }else{
                    $withdrawal = Withdrawal::with('user')->where('user_id',$mid)->where('mode','BDO')->orderBy('created_at','desc');
                }   

            } elseif($request->has('sort_by')) {
                $sort = $request->sort_by;

                if($sort == 'RECENT'){
                    $withdrawal = Withdrawal::with('user')->where('mode','BDO')->orderBy('created_at','desc');
                } else {
                    $withdrawal = Withdrawal::with('user')->where('mode','BDO')->where('status', $sort)->orderBy('created_at','desc');
                }
                                  
            } elseif($request->has('card_type')) {
                
                $cardtype = $request->card_type;
                $withdrawal = Withdrawal::with('user')->where('card_type', $cardtype)->orderBy('created_at','desc');

            } else {

                $withdrawal = Withdrawal::with('user')->where('mode','BDO')->orderBy('created_at','desc'); 
            }

            return Datatables::of($withdrawal)
                ->editColumn('amount', function ($withdrawal) {
                    return 'Sub Total: &#8369;<strong>'.number_format($withdrawal->amount).'</strong>
                        <p>10% withholding tax: <span class="text-danger">&#8369;'. number_format((10 / 100  * $withdrawal->amount)) .'</span><br>
                        Service Charge: <span class="text-danger">&#8369;100</span></p>
                        <strong>TOTAL: &#8369;'.number_format($withdrawal->amount - (( 10 / 100 ) * $withdrawal->amount ) - 100).'</span></strong>';
                })
                ->editColumn('status', function ($withdrawal) {
                    if($withdrawal->status == "PENDING"){
                        return '<strong class="text-warning">'.$withdrawal->status.'</strong>'; 
                    } elseif ($withdrawal->status == "PAID") {
                        return '<strong class="text-success">'.$withdrawal->status.'</strong>'; 
                    } else {
                        return '<strong class="text-danger">'.$withdrawal->status.'</strong>'; 
                    }
                })
                ->editColumn('mode', function ($withdrawal) {
                    if($withdrawal->mode == "BDO") {
                        if($withdrawal->card_type == "cash"){
                            return $withdrawal->mode . ' - ' . 'Cash Card';
                        }elseif($withdrawal->card_type == "bdo"){
                            return $withdrawal->mode . ' - ' . 'BDO Account';
                        }else {
                            return $withdrawal->mode;
                        }
                    }
                })
                ->editColumn('details', '{!! nl2br($details) !!}') 
                ->editColumn('transact_at', function ($withdrawal) {
                    if($withdrawal->transact_at == null){
                        return '';
                    } else {
                        return $withdrawal->transact_at;
                    }
                })
                ->addColumn('action', function ($withdrawal) {
                    if($withdrawal->status == 'PENDING'){
                    return '
                        <small id="processing'.$withdrawal->id.'" style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option selected="selected" value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>';
                    } elseif ($withdrawal->status == "CANCELLED") {
                    return '
                        <small id="processing'.$withdrawal->id.'"style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option value="PENDING">PENDING</option> 
                            <option selected="selected"  value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>';

                    } else {

                    return '
                        <small id="processing'.$withdrawal->id.'"style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option  selected="selected" value="PAID">PAID</option>
                        </select>';

                    } 
                })
                ->addColumn('checkbox', function ($withdrawal) {

                    if($withdrawal->status == 'PENDING'){
                        return '<input type="checkbox" id="'.$withdrawal->id.'" name="withdrawal_id" value="'.$withdrawal->id.'" />';
                    } else {
                        return '<input type="checkbox" disabled/>';
                    }
                })
                ->addColumn('date', function ($withdrawal) {
                    if($withdrawal->transact_at == NULL){
                        return '<strong>Requested at:</strong><br>'. date('F j, Y g:i a', strtotime($withdrawal->created_at)) . ' | ' . $withdrawal->created_at->diffForHumans();
                    } else {
                        return '<strong>Requested at:</strong><br>'. date('F j, Y g:i a', strtotime($withdrawal->created_at)) . ' <br><strong>Processed at:</strong><br>' . date('F j, Y g:i a', strtotime($withdrawal->transact_at));
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['amount','status','mode','details','action','checkbox','date'])
                ->make(true);
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getSupportEncashmentsExport(Request $request) {   

        $withdrawals = Withdrawal::with('user')->where('mode','REMITTANCE')->where('status','PENDING')->where('details', 'LIKE', '%'. $request->remittance .'%')->count();

        if($withdrawals > 0){
            
            return (new WithdrawalExport($request->remittance,$withdrawals))->download('Remittance Payout - '.$request->remittance.'.xlsx');

        
        } else {

            return response()->json(["result"=>false,"message" => "No Pending Palawan Express Remittance Payout!"],200);
        }
    }  

    public function getSupportBDOEncashmentsExport(Request $request) {   

        $withdrawals = Withdrawal::with('user')->where('mode','BDO')->where('status','PENDING')->where('card_type',$request->bdo)->count();

        if($withdrawals > 0){
            
            return (new WithdrawalBDOExport($request->bdo,$withdrawals))->download('BDO Payout - '.$request->bdo.'.xlsx');

        
        } else {

            return response()->json(["result"=>false,"message" => "No Pending BDO Payout!"],200);
        }
    }

    public function getSupportViewEncashment($id, Request $request){

        $user = Auth::user();
        
        $encashment = Withdrawal::with('user')->where('mode','REMITTANCE')->where('id',$id)->first();

        if(!$encashment){
            Session::flash('danger', "Encashment not found!");
            return redirect('/support/encashments');
        }

        return  view('support.view-encashment')->with('user',$user)->with('encashment',$encashment);
    }  

    public function postSupportViewEncashment($id, Request $request){

        if ($request->wantsJson()) {

            $withdrawal = Withdrawal::find($id);

            if($withdrawal){

                $withdrawal->status = $request->status;
                $withdrawal->remittance_transaction_code = $request->transaction_code;
                $withdrawal->remittance_amount = $request->amount;
                $withdrawal->remittance_sender_name = $request->sender_name;
                $withdrawal->transact_at = Carbon::now();
                $withdrawal->save();

                return response()->json(array("result"=>true,"message"=>'Successfully Updated!'),200);               
            } else {

                return response()->json(array("result"=>false,"message"=>'Encashment not found!'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }  


    public function getSupportProductOrders(){

        $user = Auth::user();
        
        return  view('support.product-orders')->with('user',$user);   
    }

    public function getSupportProductOrdersData(Request $request){

        if ($request->wantsJson()) {

            if($request->has('sort_by')){

                $sort = $request->sort_by;

                if($request->has('order_by')){

                    $order = $request->order_by;

                    if($order != 'ALL'){

                        if($sort == 'WITHOUT'){

                            $orders = Order::with('user','products','products.product')->whereNull('receipt')->where('status',$request->order_by)->get();                    

                        } elseif($sort == 'WITH') {

                            $orders = Order::with('user','products','products.product')->whereNotNull('receipt')->where('status',$request->order_by)->get();

                        } else {

                            $orders = Order::with('user','products','products.product')->where('status',$request->order_by)->get();
                        }
                        

                    } else {

                        if($sort == 'WITHOUT'){

                            $orders = Order::with('user','products','products.product')->whereNull('receipt')->get();                    

                        } elseif($sort == 'WITH') {

                            $orders = Order::with('user','products','products.product')->whereNotNull('receipt')->get();

                        } else {

                            $orders = Order::with('user','products','products.product')->get();
                        }
                    }

                } else {

                    if($sort == 'WITHOUT'){

                        $orders = Order::with('user','products','products.product')->whereNull('receipt')->get();                    

                    } elseif($sort == 'WITH') {

                        $orders = Order::with('user','products','products.product')->whereNotNull('receipt')->get();

                    } else {

                        $orders = Order::with('user','products','products.product')->get();
                    }

                }

            } else {

                $orders = Order::with('user','products','products.product')->get();
            }


            return response()->json(['orders'=> $orders],200); 

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    } 

    public function postSupportProductOrdersStatus(Request $request){

        if ($request->wantsJson()) {

            $product_order = Order::find($request->id);

            if($product_order){

                $product_order->status = $request->status;
                $product_order->save();

                return response()->json(array("result"=>true,"message"=>'Product Order status successfully set to '.$request->status.'!'),200);
                  
            } else {

                return response()->json(array("result"=>false,"message"=>'Product Order not found!'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }   

    public function getSupportResellerKYC() {

        $user = Auth::user();
        
        return  view('support.kyc.reseller')->with('user',$user);

    }

    public function getSupportViewResellerKYC($id) {

        $user = Auth::user();
        $kyc = ResellerKyc::with('user')->where('id',$id)->first();
        
        return  view('support.kyc.view')->with('user',$user)->with('kyc',$kyc);

    }

    public function postSupportResellerKYCStatus($id,Request $request) {

        if ($request->wantsJson()) {

            $kyc = ResellerKyc::find($id);

            if($kyc){

                $kyc->status = $request->status;
                $kyc->note = $request->note;
                $kyc->save();

                return response()->json(array("result"=>true,"message"=>'Reseller KYC status successfully updated.'),200);


            } else {

                return response()->json(array("result"=>false,"message"=>'Reseller KYC Not Found!'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getSupportResellerKYCData(Request $request) {

        if ($request->wantsJson()) {

            if($sort_by = $request->sort_by) {

                $kyc = ResellerKyc::with('user')->where('status',$sort_by);

            } else {

                $kyc = ResellerKyc::with('user');
            }

            return Datatables::of($kyc)
                ->addColumn('member', function ($kyc) {
                    return '<b>'.$kyc->user->full_name.'</b><br>('.$kyc->user->username.')';
                })
                ->addColumn('username', function ($kyc) {
                    return $kyc->user->username;
                })
                ->addColumn('submitted_id', function ($kyc) {
                    return '<img src="'.$kyc->submitted_id.'" class="img img-responsive img-thumbnail text-center  center-block" style="height: 100px;margin:0 auto;">
                                   <p><b>ID #:</b>'.$kyc->submitted_id_no.'</p>';
                })
                ->addColumn('date', function ($kyc) {
                    return $kyc->created_at;
                })
                ->editColumn('status', function ($kyc) {
                    if($kyc->status == 'PROCESSING'){
                         return '<b class="text-warning">PROCESSING</b>';
                    } elseif ($kyc->status == 'DENIED') {
                        return '<b class="text-danger">DENIED</b>';
                    } else {
                        return '<b class="text-success">APPROVED</b>';
                    }
                })
                ->editColumn('action', function ($kyc) {
                    return '<a href="/support/reseller-kyc/'.$kyc->id.'" class="btn btn-success btn-sm btn-block" target="_blank">View</a>';
                })
                ->addIndexColumn()
                ->rawColumns(['member','submitted_id','username','status','action'])
                ->make(true);

         } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getSupportTravelAndTourBooking(){

        $user = Auth::user();
        
        
        return  view('support.tnt.booking')->with('user',$user);       
    }

    public function getSupportTravelAndTourBookingData(Request $request){

        if($request->wantsJson()) {

            if($request->has('user_id')){

                $booking = Booking::with('user')->where('user_id',$request->user_id)->orderBy('created_at','desc');

            } else {

                $booking = Booking::with('user')->orderBy('created_at','DESC');
            }

            

            return Datatables::of($booking)
                ->addColumn('member', function ($booking) {

                    if($booking->email == NULL){
                        return '<b>'.$booking->user->full_name.'</b><br>'.$booking->user->username.'<br><b>Email:</b>'.$booking->user->email.'<br><b>Contact # :</b>'.$booking->user->mobile;
                    } else {
                        return '<b>'.$booking->user->full_name.'</b><br>'.$booking->user->username.'<br><b>Email:</b>'.$booking->email.'<br><b>Contact # :</b>'.$booking->mobile;
                    }
                    
                })
                ->addColumn('info', function ($booking) {

                    if($booking->type == "FLIGHT"){

                         if($booking->return_date == NULL){
                            return '<img src="https://cdn.via.com/static/img/v1/newui/all/airlines/logos/'.$booking->carrier_code.'-v12.gif" alt="carrier_logo"><br><small>'.$booking->carrier_name.'</small><br><p><b>'.$booking->source.' <i class="fa fa-long-arrow-right"></i> '.$booking->destination.'</b><br><small><i class="fa fa-calendar"></i> '.$booking->departure_date .'</small></p><p><b>'.$booking->flight.'</b></p>';
                        } else {
                            return '<img src="https://cdn.via.com/static/img/v1/newui/all/airlines/logos/'.$booking->carrier_code.'-v12.gif" alt="carrier_logo"><br><small>'.$booking->carrier_name.'</small><br><p><b>'.$booking->source.' <i class="fa fa-exchange"></i> '.$booking->destination.'</b><br><small><i class="fa fa-calendar"></i> '.$booking->departure_date .' / '.$booking->return_date.'</small></p><p><b>'.$booking->flight.'</b></p>';
                        }
                    } else {
                        return '<small><b><i class="fa fa-hotel fa-2x"></i> </br>'.$booking->hotel_name.'</b> </br> '.$booking->hotel_city.'</small></br></br><small><i class="fa fa-calendar"></i> Check In/Out <br>'.$booking->departure_date .' / '.$booking->return_date.'</small>';
                    }

                   
                }) 
                ->addColumn('total_fare', function ($booking) {

                    if($booking->extra_fee()->count() > 0){

                        return '<b class="text-danger">&#8369; '.number_format($booking->total_fare,2).'</b><br><small class="text-info">( + Extra Fee<br> <b>&#8369;'.$booking->extra_fee()->sum('amount').'</b>)</small>';
                    } else {

                        return '<b class="text-danger">&#8369; '.number_format($booking->total_fare,2).'</b>';
                    }

                    
                })   
                ->editColumn('referrence_number', function ($booking) {

                    return '<b class="text-info">'.$booking->referrence_number.'</b>';
                })     
                ->addColumn('action', function ($booking) {
                    if ($booking->status == "CONFIRMED") {
                       return '<a href="'.$booking->url.'" target="_blank" class="btn btn-warning btn-sm">View Itinenary in Via</a><br>
                        <br>
                        <a href="/support/travelandtours/download-itinerary/'.$booking->referrence_number.'" target="_blank" class="btn btn-lime btn-sm">Download PDF Itinenary</a>
                        ';
                    } else {
                        return '<a href="'.$booking->url.'" target="_blank" class="btn btn-warning btn-sm">View Itinenary in Via</a>';
                    }

                    
                }) 
                ->editColumn('status', function ($booking) {
                    if ($booking->status == "CONFIRMED") {
                        return '<span class="label label-success">'.$booking->status.'</span>'; 
                    } else {
                        return '<span class="label label-warning">'.$booking->status.'</span>'; 
                    }
                })          
                ->addIndexColumn()
                ->rawColumns(['member','info','total_fare','status','action','referrence_number'])
                ->make(true);
            
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }           
    }

    public function getSupportTravelAndTourBookingItinerary($fmn){

        $booking = Booking::where('referrence_number',$fmn)->first();

        if($booking){

            $booking_settings = BookingSettings::where('user_id',$booking->user_id)->first();

            if($booking->type == "FLIGHT") {

                if($booking->flight == 'INTERNATIONAL'){
                    $affiliate_profit =  $booking_settings->flight_international;
                } else {
                    $affiliate_profit =  $booking_settings->flight_domestic;
                }

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://adminph.via.com/apiv2/booking/retrieve/".$fmn);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $headers = array();
                $headers[] = "Language: ENGISH";
                $headers[] = "Via-Access-Token: c51b5435-cec6-4de2-b133-419139123472";
                $headers[] = "Content-Type: application/json; charset=utf-8";
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $itinerary =  json_decode(curl_exec($ch));
                if (curl_errno($ch)) {
                    return response()->json(array("result"=>false,"message"=>curl_error($ch)),422);
                }
                curl_close ($ch);

                if($itinerary && isset($itinerary->status)){

                    if($itinerary->status == 'CONFIRMED'){
                        Cache::forever('itinerary-'.$fmn, $itinerary);
                    }


                    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'DefaultFont' => 'Helvetica', 'DPI' => 150])->loadView('admin.tnt.flight-itinerary', compact('itinerary','affiliate_profit'))->setPaper('legal', 'portrait');

                    return $pdf->stream();

                } else {
                    
                    return redirect('/travelandtours/booking/manage');
                }

            } else {

                if($booking->flight == 'INTERNATIONAL'){
                    $affiliate_profit =  $booking_settings->hotel_international;
                } else {
                    $affiliate_profit =  $booking_settings->hotel_domestic;
                }

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://adminph.via.com/apiv2/booking/retrieve/".$fmn);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $headers = array();
                $headers[] = "Language: ENGISH";
                $headers[] = "Via-Access-Token: dd7b0fb3-6546-06ed-1d4b-87ba5c2152f8";
                $headers[] = "Content-Type: application/json; charset=utf-8";
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $itinerary =  json_decode(curl_exec($ch));
                if (curl_errno($ch)) {
                    return response()->json(array("result"=>false,"message"=>curl_error($ch)),422);
                }
                curl_close ($ch);


                if($itinerary && isset($itinerary->status)){

                    if($itinerary->status == 'CONFIRMED'){
                        Cache::forever('itinerary-'.$fmn, $itinerary);
                    }


                    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'DefaultFont' => 'Helvetica', 'DPI' => 150])->loadView('admin.tnt.hotel-itinerary', compact('itinerary','booking','affiliate_profit'))->setPaper('legal', 'portrait');

                    return $pdf->stream();

                } else {
                    
                    return redirect('/travelandtours/booking/manage');
                }


            }

        } else {

            return redirect('/support/travelandtours/booking');
        }       
    }

    public function getSupportMember(){

        $user = Auth::user();
        
        return  view('support.members')->with('user',$user);      
    }

    public function getSupportViewMember($id, Request $request) {

        $user = User::with('booking')->find($id);

        return  view('support.member-info')->with('user',$user);      
    }

    public function postSupportMemberExtraFee($id, BookingExtraFeeRequest $request) {

        if ($request->wantsJson()) {

            $booking = Booking::where('referrence_number',$request->booking_id)->where('user_id',$id)->first();

            if($booking){

                $user = User::find($id);
                $total_master_fund = getTotalMasterFund($user->id);
                if($request->amount > $total_master_fund){
                    return response()->json(array("result"=>false,"message"=>'User doesnt have enough master fund!'),422);
                }

                $extra_fee = new BookingExtraFee;
                $extra_fee->user_id = $user->id;
                $extra_fee->booking_id = $booking->id;
                $extra_fee->amount = $request->amount;
                $extra_fee->description = $request->description;
                $extra_fee->save();

                return response()->json(array("result"=>true,"message"=>'Successfully save extra fee!'),200);

            } else {

                return response()->json(array("result"=>false,"message"=>'Booking ID doesnt exits or not belong to the user!'),422);
            }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
    }

    public function getSupportMemberData(Request $request) {

        if ($request->wantsJson()) {
                
        
            // if($username = $request->username) {

            //     $members = User::has('booking')->where('role',1)->where('username', $username)->orderBy('created_at','DESC')->get();
            // } else {

                $members = User::has('booking')->with('booking')->where('role',1)
                            ->orderBy('created_at','DESC')->get();
            //}


            $members_data = [];

            foreach ($members as $key => $value) {

                $data = [
                    'id' => $value->id,
                    'full_name' => $value->full_name,
                    'email' => $value->email,
                    'mobile' => $value->mobile,
                    'username' => $value->username,
                    'master_fund' => getTotalMasterFund($value->id),
                    'total_booked' => $value->booking()->where('status','CONFIRMED')->sum('total_fare')
                ];

                array_push($members_data, $data);
            }

            return response()->json(['members'=> $members_data],200); 
            
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }


    public function getSupportYazzEncashments(){

        $user = Auth::user();
        
        return  view('support.yazz-encashments')->with('user',$user);      
    }

    public function postSupportYazzEncashmentsPaidAll(){

       $withdrawals = Withdrawal::where('mode','YAZZ')->where('status','PENDING')->get();

       foreach ($withdrawals as $key => $withdrawal) {
            $withdrawal->status = 'PAID';
            $withdrawal->transact_at = Carbon::now();
            $withdrawal->save();
       }

       return response()->json(array("result"=>true,"message"=>'Successfully Paid All Pending Payouts!'),200);
    }

    public function postSupportYazzEncashmentsStatus($id, Request $request) {

        if ($request->wantsJson()) {

                //find encashment
                $withdrawal = Withdrawal::find($id);

                if($withdrawal){


                    if($withdrawal->mode == "YAZZ"){

                        $withdrawal->status = $request->status;
                        $withdrawal->transact_at = Carbon::now();
                        $withdrawal->save();

                        return response()->json(array("result"=>true,"message"=>'Status Successfully Updated'),200);

                    } else {

                        return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),200);
                    }
                                        
                } else {

                    return response()->json(array("result"=>false,"message"=>'Encashment not found!'),422);
                }

        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getSupportYazzEncashmentsData(Request $request) {

        if ($request->wantsJson()) {
                
            if ($request->has('mid_by')) {
                
                $mid =$request->mid_by;
                if ($request->has('sort_by')) {
                    $sort = $request->sort_by;
                    $withdrawal = Withdrawal::with('user')->where('user_id',$mid)->where('mode','YAZZ')->where('status',$sort)->orderBy('created_at','desc');
                }else{
                    $withdrawal = Withdrawal::with('user')->where('mode','YAZZ')->where('user_id',$mid)->orderBy('created_at','desc');
                }   

            } elseif($request->has('sort_by')) {
                $sort = $request->sort_by;
                if ($request->has('order_by')) {
                    $order = $request->order_by;
                    $withdrawal = Withdrawal::with('user')->where('mode','YAZZ')->where('status',$sort)->orderBy('created_at','desc');

                } else {

                    if($sort == 'RECENT'){
                        $withdrawal = Withdrawal::with('user')->where('mode','YAZZ')->orderBy('created_at','desc');
                    } else {
                        $withdrawal = Withdrawal::with('user')->where('mode','YAZZ')->where('status', $sort)->orderBy('created_at','desc');
                    }
                    
                }                   
            } else {

                $withdrawal = Withdrawal::with('user')->where('mode','YAZZ')->orderBy('created_at','desc'); 
            }

            return Datatables::of($withdrawal)
                ->editColumn('amount', function ($withdrawal) {
                    return 'Sub Total: &#8369;<strong>'.number_format($withdrawal->amount).'</strong>
                        <p>10% withholding tax: <span class="text-danger">&#8369;'. number_format((10 / 100  * $withdrawal->amount)) .'</span><br>
                        Service Charge: <span class="text-danger">&#8369;100</span></p>
                        <strong>TOTAL: &#8369;'.number_format($withdrawal->amount - (( 10 / 100 ) * $withdrawal->amount ) - 100).'</span></strong>';
                })
                ->editColumn('status', function ($withdrawal) {
                    if($withdrawal->status == "PENDING"){
                        return '<strong class="text-warning">'.$withdrawal->status.'</strong>'; 
                    } elseif ($withdrawal->status == "PAID") {
                        return '<strong class="text-success">'.$withdrawal->status.'</strong>'; 
                    } else {
                        return '<strong class="text-danger">'.$withdrawal->status.'</strong>'; 
                    }
                })
                ->editColumn('mode', function ($withdrawal) {
                    return $withdrawal->mode;
                })
                ->editColumn('details', '{!! nl2br($details) !!}') 
                ->editColumn('transact_at', function ($withdrawal) {
                    if($withdrawal->transact_at == null){
                        return '';
                    } else {
                        return $withdrawal->transact_at;
                    }
                })
                ->addColumn('action', function ($withdrawal) {
                    if($withdrawal->status == 'PENDING'){
                        if($withdrawal->receipt == NULL || $withdrawal->receipt  == ''){
                            return '
                        <small id="processing'.$withdrawal->id.'" style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option selected="selected" value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>';

                        } else {
                            return '
                        <small id="processing'.$withdrawal->id.'" style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option selected="selected" value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>';
                        }
                    
                    } elseif ($withdrawal->status == "CANCELLED") {
                    return '
                        <small id="processing'.$withdrawal->id.'"style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option value="PENDING">PENDING</option> 
                            <option selected="selected"  value="CANCELLED">CANCELLED</option> 
                            <option value="PAID">PAID</option>
                        </select>';

                    } else {

                    return '
                        <small id="processing'.$withdrawal->id.'"style="display:none">Processing... <i class="fa fa-spinner fa-spin"></i></small>
                        <br>
                        <select class="form-control form-control-sm form-control-round" name="status'.$withdrawal->id.'" id="status'.$withdrawal->id.'"  onchange="angular.element(this).scope().frm.changestatus('.$withdrawal->id.')" >
                            <option value="PENDING">PENDING</option> 
                            <option value="CANCELLED">CANCELLED</option> 
                            <option  selected="selected" value="PAID">PAID</option>
                        </select>';

                    } 
                })
                ->addColumn('checkbox', function ($withdrawal) {

                    if($withdrawal->status == 'PENDING'){
                        return '<input type="checkbox" id="'.$withdrawal->id.'" name="withdrawal_id" value="'.$withdrawal->id.'" />';
                    } else {
                        return '<input type="checkbox" disabled/>';
                    }
                })
                ->addColumn('date', function ($withdrawal) {
                    if($withdrawal->transact_at == NULL){
                        return '<b>Requested At:</b><br>'.$withdrawal->created_at;
                    } else {
                        return '<b>Requested:</b><br>'.$withdrawal->created_at.'<br><b>Processed At:</b><br>'.$withdrawal->transact_at;
                    }
                    
                })
                ->addIndexColumn()
                ->rawColumns(['amount','status','mode','details','action','checkbox','date'])
                ->make(true);
        
        } else {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }
                        
    }

    public function getSupportYazzEncashmentsExport(Request $request) {   

        $withdrawals = Withdrawal::with('user')->where('mode','YAZZ')->where('status','PENDING')->count();

        if($withdrawals > 0){
            
            return (new WithdrawalYazzExport($withdrawals))->download('Yazz Card Payout - '.Carbon::now()->format('Y-m-d').'.xlsx');

        
        } else {

            return response()->json(["result"=>false,"message" => "No Yazz Card Payout!"],200);
        }
    }


}
