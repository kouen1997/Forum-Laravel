<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Member;
use App\Account;
use App\LoginHistory;
use App\WalletMove;
use App\Reward;
use App\BuyCode;
use App\Genealogy;
use App\PairingBonus;
use App\LevelingBonus;
use App\Withdrawal;
use App\TruemoneyWithdrawal;
use App\Wallet;
use App\Code;
use App\CodeRequest;
use App\Points;
use App\Truemoney;
use App\TransferCodes;
use App\PostingReward;
use App\LoadWallet;
use App\LoadCharge;
use App\LoadTransfer;
use App\RetrieveCodes;
use App\Product;
use App\Order;
use App\OrderProduct;
use DB;
use Carbon\Carbon;

class OptimizeController extends Controller
{
    public function optimize_users()
	{

		DB::table('usersw')->select('usersw.username','usersw.password','usersw.active','usersw.account_pin','usersw.social_id','member_tbl.id','member_tbl.fname','member_tbl.lname','member_tbl.email','member_tbl.active as member_active','member_tbl.is_retailer','member_tbl.mobile','member_tbl.bday','member_tbl.sponsor','member_tbl.last_login','member_tbl.activated_at','member_tbl.created_at','member_tbl.updated_at')
		->join('member_tbl','usersw.login_id','=','member_tbl.id')
		->orderBy('member_tbl.id')->chunk(5000, function ($users) {
		    foreach ($users as $key => $value) {

		        $sponsor_name = str_replace('"', '', $value->sponsor);

	    		//$sponor = User::where('username',$sponsor_name)->first();
	    	
		    	$user = new User;
		    	$user->id = $value->id;
	            $user->username = $value->username;
	            $user->password = $value->password;
	            $user->role = 1;
	            $user->pin = $value->account_pin;
	            $user->social_id = $value->social_id;

	        
	            $user->first_name = $value->fname;
	            $user->last_name = $value->lname;

	            //if(!$duplicate_email){
		            $user->email = $value->email;
		        //}

	            $user->mobile = $value->mobile;

	            if($value->bday != "0000-00-00"){
	            	$user->birth_date = $value->bday;
	            }

	            // if($sponor){
		           //  $user->sponsor_id = $sponor->id;
		            $user->sponsor_username = $sponsor_name;
		        //}

	            $user->active = $value->member_active;
	            $user->retailer = $value->is_retailer;
	            $user->last_login_at = $value->last_login;
	            $user->activated_at = $value->activated_at;
	            $user->created_at = $value->created_at;
	            $user->updated_at = $value->updated_at;
	            $user->save();
		    }

		    echo "Successfully Optimize Users!!!!";
		});
	    

	}

	public function optimize_users_sponsor()
	{

		
		User::select('id','sponsor_username')->where('id','>', 1)->where('sponsor_id', NULL)->orderBy('id')->chunk(5000, function ($users) {
		    foreach ($users as $key => $value) {

		    	$sponsor_name = str_replace('https://paysbook.co/auth/register?id=', '', $value->sponsor_username);

	    		$sponor = User::where('username',$sponsor_name)->first();

	            if($sponor){
	               $user = User::find($value->id);
		           $user->sponsor_id = $sponor->id;
		           $user->save();
		        }
	            
		    }

		    echo "Successfully Optimize Users Sponsors!!!!";
		});
	    

	}

	public function optimize_accounts()
	{


	    DB::table('accounts_new_tbl')->orderBy('id')->chunk(5000, function ($accounts) {
		    foreach ($accounts as $key => $value) {

	    	
		    	$account = new Account;
		    	$account->id = $value->id;
		    	$account->user_id = $value->owner_id;
		    	$account->account_name = $value->account_name;
		    	$account->activation_code = $value->activation_code;
		    	$account->account_name = $value->account_name;
		    	$account->parent_id = $value->parent;
		    	$account->parent_user_id = $value->parent_member_id;
		    	$account->parent_account_name = $value->parent_name;
		    	$account->position = $value->position;
		    	$account->total_left = $value->total_left;
		    	$account->account_name = $value->account_name;
		    	$account->total_left = $value->total_left;
		    	$account->total_right = $value->total_right;
		    	$account->waiting_left = $value->waiting_left;
		    	$account->waiting_right = $value->waiting_right;
		    	$account->status = $value->status;
		    	$account->optimize = $value->optimizes;
	            $account->created_at = $value->created_at;
	            $account->updated_at = $value->updated_at;
	            $account->save();

	    }

		    echo "Successfully Optimize Accounts!!!!";
		});

	}

	public function optimize_pairing()
	{

	    $accounts = DB::table('pairing_bonus')->get();

	    foreach ($accounts as $key => $value) {

	    	
		    	$pairing = new PairingBonus;
		    	$pairing->user_id = $value->member_id;
		    	$pairing->account_id = $value->account_id;
		    	$pairing->downline_id = $value->downline_id;
		    	$pairing->amount = $value->amount;
		    	$pairing->status = $value->status;
	            $pairing->created_at = $value->created_at;
	            $pairing->updated_at = $value->updated_at;
	            $pairing->save();

	    }

	    echo "Successfully Optimize pairing!!!!";

	}

	public function optimize_leveling()
	{

	    $accounts = DB::table('leveling_bonus')->get();

	    foreach ($accounts as $key => $value) {

	    	
		    	$leveling = new LevelingBonus;
		    	$leveling->user_id = $value->member_id;
		    	$leveling->account_id = $value->account_id;
		    	$leveling->downline_id = $value->downline_id;
		    	$leveling->amount = $value->amount;
		    	$leveling->level = $value->level;
		    	$leveling->status = $value->status;
	            $leveling->created_at = $value->created_at;
	            $leveling->updated_at = $value->updated_at;
	            $leveling->save();

	    }

	    echo "Successfully Optimize leveling!!!!";

	}

	public function optimize_genealogy()
	{

		DB::table('genealogy')->orderBy('id')->chunk(5000, function ($genealogy) {
		    foreach ($genealogy as $key => $value) {

	    		$genealogy = new Genealogy;
		    	$genealogy->user_id = $value->member_id;
		    	$genealogy->account_id = $value->account_id;
		    	$genealogy->downline_id = $value->downline_id;
		    	$genealogy->position = $value->position;
		    	$genealogy->level = $value->level;
		    	$genealogy->status = $value->status;
	            $genealogy->created_at = $value->created_at;
	            $genealogy->updated_at = $value->updated_at;
	            $genealogy->save();
	            
		    }

		    echo "Successfully Optimize Genealogy!!!!";
		});

	    

	}

	public function optimize_login_history()
	{

		DB::table('login_history_tbl')->orderBy('id')->chunk(1000, function ($history) {
		    foreach ($history as $key => $value) {

	    		$login = new LoginHistory;
		    	$login->user_id = $value->login_by;
	            $login->created_at = $value->created_at;
	            $login->updated_at = $value->updated_at;
	            $login->save();
	            
		    }

		    echo "Successfully Optimize Login History!!!!";
		});

	    

	}

	public function optimize_wallet_move()
	{

	    $history = DB::table('pwalletmove_tbl')->get();

	    foreach ($history as $key => $value) {

	    	
		    	$move = new WalletMove;
		    	$move->user_id = $value->member_id;
		    	$move->amount = $value->amount;
	            $move->created_at = $value->created_at;
	            $move->updated_at = $value->updated_at;
	            $move->save();

	    }

	    echo "Successfully Optimize Wallet Move!!!!";

	}

	public function optimize_reward()
	{

	    $history = DB::table('pwallet_tbl')->get();

	    foreach ($history as $key => $value) {

	    	
		    	$reward = new Reward;
		    	$reward->user_id = $value->member_id;
		    	$reward->amount = $value->amount;
	            $reward->created_at = $value->created_at;
	            $reward->updated_at = $value->updated_at;
	            $reward->save();

	    }

	    echo "Successfully Optimize Reward!!!!";

	}

	public function optimize_codes()
	{

	    $codes = DB::table('epins_tbl')->get();

	    foreach ($codes as $key => $value) {

	    		$owner = User::where('id',$value->owned_by)->first();
	    		$used_by = User::where('id',$value->used_by)->first();

		    	$code = new Code;

		    	if(!$owner){
		    	  	$code->user_id = NULL;
		    	} else {
		    		$code->user_id = $value->owned_by;
		    	}

		    	if(!$used_by){
		    	  	$code->used_by_user_id = NULL;
		    	} else {
		    		$code->used_by_user_id = $value->used_by;
		    	}
		    	
		    	$code->code = $value->code;
		    	$code->status = $value->status;
		    	$code->owned_at = $value->owned_at;
		    	$code->used_at = $value->used_at;
		    	$code->transfered_at = $value->transfered_at;
	            $code->created_at = $value->created_at;
	            $code->updated_at = $value->updated_at;
	            $code->save();

	    }

	    echo "Successfully Optimize Code!!!!";

	}

	public function optimize_code_request()
	{

	    $codes = DB::table('code_request_tbl')->get();

	    foreach ($codes as $key => $value) {


		    	$request = new CodeRequest;
		    	$request->requested_by_user_id = $value->request_by;
		    	$request->quantity = $value->quantity;
		    	$request->status = $value->status;
	            $request->created_at = $value->created_at;
	            $request->updated_at = $value->updated_at;
	            $request->save();

	    }

	    echo "Successfully Optimize Code Request!!!!";

	}

	public function optimize_buy_code()
	{

	    $history = DB::table('buycode_tbl')->get();

	    foreach ($history as $key => $value) {

	    	
		    	$reward = new BuyCode;
		    	$reward->user_id = $value->member_id;
		    	$reward->code = $value->code;
		    	$reward->status = $value->status;
	            $reward->created_at = $value->created_at;
	            $reward->updated_at = $value->updated_at;
	            $reward->save();

	    }

	    echo "Successfully Optimize Buy Code!!!!";

	}

	public function optimize_retrieve_code()
	{

	    $history = DB::table('retrieve_code_tbl')->get();

	    foreach ($history as $key => $value) {

			if(User::where('id',$value->retrieve_by)->exists() && User::where('id',$value->retrieve_to)->exists()){

		    	$retrieve = new RetrieveCodes;
		    	$retrieve->retrieve_by_user_id = $value->retrieve_by;
		    	$retrieve->retrieve_from_user_id = $value->retrieve_to;
	            $retrieve->created_at = $value->created_at;
	            $retrieve->updated_at = $value->updated_at;
	            $retrieve->save();

    		}
	    	

	    }

	    echo "Successfully Optimize Retrieve Code!!!!";

	}

	public function optimize_raffle_points()
	{

	    $points = DB::table('tbl_raffle_points')->get();

	    foreach ($points as $key => $value) {

	    	
		    	$point = new Points;;
		    	$point->user_id = $value->member_id;
		    	$point->referred_user_id = $value->referred_id;
		    	$point->points = $value->points;
	            $point->created_at = $value->created_at;
	            $point->updated_at = $value->updated_at;
	            $point->save();

	    }

	    echo "Successfully Optimize Points!!!!";

	}

	public function optimize_withdrawal()
	{

	    $withdrawals = DB::table('withdrawal_tbl')->get();

	    foreach ($withdrawals as $key => $value) {

	    	
		    	$withdrawal = new Withdrawal;
		    	$withdrawal->user_id = $value->member_id;
		    	$withdrawal->user_username = $value->member_username;
		    	$withdrawal->amount = $value->amount;
		    	$withdrawal->card_type = $value->cardtype;
		    	$withdrawal->details = $value->details;
		    	$withdrawal->mode = $value->mode;
		    	$withdrawal->dealer_name = $value->dealer;
		    	$withdrawal->location = $value->location;
		    	$withdrawal->transact_by_id = $value->transact_byid;
		    	$withdrawal->transact_by_username = $value->transact_byname;
		    	$withdrawal->transact_at = $value->transact_at;
		    	$withdrawal->cancelled_at = $value->cancelled_at;
		    	$withdrawal->cancelled_by = $value->cancelled_by;
		    	$withdrawal->status = $value->status;

	            $withdrawal->created_at = $value->created_at;
	            $withdrawal->updated_at = $value->updated_at;
	            $withdrawal->save();

	    }

	    echo "Successfully Optimize Withdrawals!!!!";

	}

	public function optimize_truemoney_withdrawal()
	{

	    $withdrawals = DB::table('truemoneywithdrawal_tbl')->get();

	    foreach ($withdrawals as $key => $value) {

	    	
		    	$withdrawal = new TruemoneyWithdrawal;
		    	$withdrawal->user_id = $value->member_id;
		    	$withdrawal->user_username = $value->member_username;
		    	$withdrawal->amount = $value->amount;
		    	$withdrawal->details = $value->details;
		    	$withdrawal->mode = $value->mode;
		    	$withdrawal->transact_by_id = $value->transact_byid;
		    	$withdrawal->transact_by_username = $value->transact_byname;
		    	$withdrawal->transact_at = $value->transact_at;
		    	$withdrawal->cancelled_at = $value->cancelled_at;
		    	$withdrawal->cancelled_by = $value->cancelled_by;
		    	$withdrawal->status = $value->status;

	            $withdrawal->created_at = $value->created_at;
	            $withdrawal->updated_at = $value->updated_at;
	            $withdrawal->save();

	    }

	    echo "Successfully Optimize Withdrawals!!!!";

	}

	public function optimize_wallet()
	{

	    $wallets = DB::table('wallet_tbl')->get();

	    foreach ($wallets as $key => $value) {

	    	$account = Account::where('id',$value->account_id)->first();
	    	if($account){
	    		$wallet = new Wallet;
		    	$wallet->user_id = $value->member_id;
		    	$wallet->user_username = $value->member_username;
		    	$wallet->account_id = $value->account_id;
		    	$wallet->account_name = $value->account_name;
		    	$wallet->amount = $value->amount;
	            $wallet->created_at = $value->created_at;
	            $wallet->updated_at = $value->updated_at;
	            $wallet->save();
	    	}

	    }

	    echo "Successfully Optimize Wallet!!!!";

	}

	public function optimize_truemoney()
	{

	    $wallets = DB::table('withdrawal_truemoney')->get();

	    foreach ($wallets as $key => $value) {

	    		$truemoney = new Truemoney;
		    	$truemoney->user_id = $value->member_id;
		    	$truemoney->first_name = $value->truefirstname;
		    	$truemoney->middle_name = $value->truemiddlename;
		    	$truemoney->last_name = $value->truelastname;
		    	$truemoney->name_suffix = $value->truenamesuffix;
		    	$truemoney->email = $value->trueemail;
		    	$truemoney->card_number = $value->truecardnumber;
		    	$truemoney->mobile_number = $value->truemobileno;
		    	$truemoney->gender = $value->truegender;
		    	$truemoney->birth_date = $value->truebirthdate;
		    	$truemoney->birth_place = $value->truebirthplace;
		    	$truemoney->nationality = $value->truenationality;
		    	$truemoney->mother_name = $value->truemothersmaidenname;
		    	$truemoney->house_no = $value->truehousenumber;
		    	$truemoney->street = $value->truestreetname;
		    	$truemoney->village = $value->truevillage;
		    	$truemoney->barangay = $value->truebrgy;
		    	$truemoney->city = $value->truetowncity;
		    	$truemoney->province = $value->trueprovince;
		    	$truemoney->affiliated = $value->trueaffiliated;
		    	$truemoney->occupation = $value->trueoccupation;
		    	$truemoney->source_of_fund = $value->truesourceoffunds;
		    	$truemoney->employer_username = $value->trueemployeridnumber;
		    	$truemoney->gov_id = $value->truegovid;
		    	$truemoney->gov_id_number = $value->truegovidnumber;
		    	$truemoney->order_address = $value->ordercardaddress;

	            $truemoney->created_at = $value->created_at;
	            $truemoney->updated_at = $value->updated_at;
	            $truemoney->save();

	    }

	    echo "Successfully Optimize Truemoney!!!!";

	}

	public function optimize_transfer_codes()
	{

		DB::table('transfer_code_tbl')->where('transfer_by','!=',0)->orWhere('transfer_to','!=',0)->orderBy('id')->chunk(1000, function ($transfers) {
		    foreach ($transfers as $key => $value) {

	    		if(User::where('id',$value->transfer_by)->exists() && User::where('id',$value->transfer_to)->exists()){

		    		$transfer = new TransferCodes;
		    		
			    	$transfer->transfer_by_user_id = $value->transfer_by;
			    	$transfer->transfer_to_user_id = $value->transfer_to;
			    	
			    	$transfer->code = $value->code;
		            $transfer->created_at = $value->created_at;
		            $transfer->updated_at = $value->updated_at;
		            $transfer->save();

	    		}
		    }

		    echo "Successfully Optimize Transfer Codes!!!!";
		});	    

	}

	public function optimize_posting_reward()
	{

	    $postings = DB::table('posting_rewards')->get();

	    foreach ($postings as $key => $value) {

    		$reward = new PostingReward;
    		if($value->member_id != NULL){
    			$reward->user_id = $value->member_id;
    		}
	    	$reward->amount = $value->amount;
	    	$reward->status = $value->status;
            $reward->created_at = $value->created_at;
            $reward->updated_at = $value->updated_at;
            $reward->save();
	    	

	    }

	    echo "Successfully Optimize Posting Reward!!!!";

	}

	public function optimize_load_wallet()
	{

	    $wallet = DB::table('loadwallet_tbl')->get();

	    foreach ($wallet as $key => $value) {

    		$load = new LoadWallet;
    		
    		$load->user_id = $value->member_id;
	    	$load->amount = $value->amount;
	    	$load->total = $value->total;
            $load->created_at = $value->created_at;
            $load->updated_at = $value->updated_at;
            $load->save();
	    	

	    }

	    echo "Successfully Optimize Load Wallet!!!!";

	}

	public function optimize_load_transfer()
	{

	    $transfer = DB::table('loadtransfer_tbl')->get();

	    foreach ($transfer as $key => $value) {

    		$load = new LoadTransfer;
    		$load->transfer_by_user_id = $value->transferred_by;
    		$load->transfer_to_user_id = $value->member_id;
	    	$load->amount = $value->amount;
	    	$load->total = $value->total;
	    	$load->wallet = $value->fromwallet;
            $load->created_at = $value->datecreated;
            $load->updated_at = $value->datecreated;
            $load->save();
	    	

	    }

	    echo "Successfully Optimize Load Transfer!!!!";

	}

	public function optimize_load_charge()
	{

	    $charge = DB::table('tbl_loading')->get();

	    foreach ($charge as $key => $value) {

    		$load = new LoadCharge;
    		$load->user_id = $value->member_id;
	    	$load->amount = $value->amount;
	    	$load->network = $value->network;
	    	$load->mobile = $value->mobile;
	    	$load->code = $value->code;
	    	$load->reference_no = $value->referenceno;
            $load->created_at = $value->datecreated;
            $load->updated_at = $value->datecreated;
            $load->save();
	    	

	    }

	    echo "Successfully Optimize Load Charge!!!!";

	}


	public function clean_dealer_payout()
	{

	    $payouts = DB::select(DB::raw("SELECT w.id, u.username, u.first_name, u.middle_name, u.last_name, w.details, w.amount, w.status FROM tbl_withdrawals as w INNER JOIN tbl_users as u ON w.user_id=u.id WHERE w.mode = 'DEALER' AND w.status = 'PENDING' AND w.details NOT LIKE CONCAT('%', u.first_name, '%')"));


	    foreach ($payouts as $key => $value) {

	    	$withdrawal = Withdrawal::find($value->id);

            if($withdrawal){

                $withdrawal->status = 'CANCELLED';
                $withdrawal->transact_at = Carbon::now();
                $withdrawal->save();

            }

	    }

	    echo "Successfully CLEAN DEALER!!!!";

	}


	public function unsuspend()
	{

	    $suspend = DB::select(DB::raw("SELECT * FROM `tbl_suspended` WHERE `details` LIKE 'SAME BDO ACCOUNT<br>526727003'"));


	    foreach ($suspend as $key => $value) {

	    	$user = User::find($value->user_id);

            if($user){

                $user->suspended = 0;
                $user->save();
            }

	    }

	    echo "Successfully UNSUSPENDED ".count($suspend);

	}

	public function payout_test()
	{

		$array = array(
			'message'=>array(
			    array(
			          'username'=>'paysbook',
			          'password'=>'SZBYWNZ50I8NgPxzp3YeFwfEywIYI2wXKK_O85hA1Yk'
			      )
			  ),
			'company'=>array(
			    'name'=>'PAYSBOOK',
			    'motheraccount'=>'8572511619215150'
			  ),
			'employee'=>array(
			    array(
			        'name'=>'Leonard Pacis Biano',
			        'ecard'=>'6364010005000100',
			        'salary'=>'500.00',
			        'service_fee'=>'0.00'
			      ),
			 
			  )
		);

		$json =  stripslashes(json_encode($array));

        $ch = curl_init();

        curl_setopt_array($ch, array(
          CURLOPT_URL =>"https://paymaster.com.ph/api/php/incoming/controller/payroll.php",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_POST =>'1',
          CURLOPT_POSTFIELDS => $json,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_HTTPHEADER => array(
            "access-control-allow-origin: *",
            "content-type: application/json;charset=utf-8"
          ),
        ));

        $result = json_decode(curl_exec($ch));
        if (curl_errno($ch)) {
            return response()->json(['result' => false, 'message'=> curl_error($ch)],500);
        }
        curl_close ($ch);

        dd($result);

	}


	public function bdo_hold()
	{

	    $encashments = DB::select(DB::raw("SELECT * FROM `tbl_suspended` WHERE `details` LIKE 'SAME BDO ACCOUNT<br>526727003913'"));

	    foreach ($encashments as $key => $value) {

    		$user = User::find($value->user_id);

            if($user){

                $user->suspended = 0;
                $user->save();
            }

	    }

	    echo "Successfully Unsuspended Accounts!!!!";

	}

	public function total_available_wallet()
	{
		
	    $users = DB::select(DB::raw("SELECT user_id, SUM(amount) as total FROM `tbl_withdrawals` WHERE STATUS = 'PAID' group by user_id ORDER BY `total` DESC LIMIT 8000"));

	    $total_available_wallet = 0;

	    foreach ($users as $key => $value) {

	    	$available_wallet = getTotalWallet($value->user_id);

	    	$total_available_wallet += $available_wallet; 

	    }

	    echo $total_available_wallet;

	}

	public function optimize_product_orders()
	{

	    $product_orders = DB::table('tbl_product_orders')->get();

	    foreach ($product_orders  as $key => $value) {

	    	$order = new Order;
            $order->user_id = $value->user_id;
            $order->name = $value->name;
            $order->contact_number = $value->contact_number;
            $order->delivery_address = $value->delivery_address;
            $order->total_price = $value->total_price;
            $order->total_points = $value->total_points;
            $order->receipt = $value->receipt;
            $order->status = $value->status;
            $order->save();

            $product = Product::find($value->product_id);

            $order_product = new OrderProduct;
            $order_product->product_id = $product->id;
            $order_product->price = $product->price;
            $order_product->points = $product->points;
            $order_product->quantity = $value->quantity;
            $order_product->order_id = $order->id;
            $order_product->save();
      	

	    }

	    echo "Successfully Optimize Orders!!!!";

	}
}
