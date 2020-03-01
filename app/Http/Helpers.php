<?php

function getSignupRewards($user_id){
	
	$signup_reward_points = 500;
	$signup_reward_voucher = 500;

	return array(
		"signup_reward_points" => $signup_reward_points,
		"signup_reward_voucher" => $signup_reward_voucher
	);
}

function getEarnings($user_id){
	
	$user = App\User::where('id', $user_id)->first();

	$id = $user->id;
	$active = $user->active;
	$username = $user->username;
	$signup_bonus = 500; //change nalang sa 500 pag final na lahat
	
	$dateActivated = $user->activated_at;
	if($dateActivated == null) {
		$dateActivated = '2017-10-23';
	}

	$login_bonus = 0;
	$watch_bonus = 0;
	$date = new DateTime($dateActivated);
	$now = new DateTime('2017-11-09');
	if($date < $now) {
		$login_bonus = 0;
	}else{
		$login_bonus = $user->login_history()->count() * 50;
	}

	$watch_bonus = $user->watch_history()->count() * 200;

	if($active!=1){
		$login_bonus = 0;
		$watch_bonus = 0;
	}
		
	//sponsor
	$sponsored_bonus = 0;
	$members =  App\User::withCount('paid_account')->where('sponsor_id', $id)->where('active', 1)->get();
	foreach($members as $member){
		$sponsored_bonus = $sponsored_bonus + ($member->paid_account_count * 100);
	}

	$total_leveling_bonus = 0;
	$total_pairing_bonus = 0;
	$accounts = App\Account::where('user_id', $id)->get();
	foreach($accounts as $account){

		$pairing_bonus = $account->pairing_bonus()->sum('amount');
		$leveling_bonus = $account->leveling_bonus()->sum('amount');

		$total_leveling_bonus = $total_leveling_bonus + $leveling_bonus;
		$total_pairing_bonus = $total_pairing_bonus + $pairing_bonus;
	}

	$total_wallet_move =  $user->wallet_move()->sum('amount');
	$total_reward =  $user->reward()->sum('amount');
	$total_buy_code = $user->code_buy()->where('status', 0)->count() * 1000;
	$total_withdrawal = $user->encashment()->whereIn('status',['PAID','PENDING'])->sum('amount');
	$total_posting_rewards = $user->posting_reward()->where('status',1)->sum('amount');
	$total_payments = $user->payment()->where('status',1)->sum('amount');
	$total_wallet_converted = $user->wallet_efund()->sum('amount');


	if($date < $now) {
		$total_earnings = $total_leveling_bonus + $total_pairing_bonus + $sponsored_bonus + $total_wallet_move + $total_posting_rewards - $total_reward;
	}else{
		$total_earnings = $total_leveling_bonus + $total_pairing_bonus  + $sponsored_bonus + $total_wallet_move + $total_posting_rewards - $total_reward;
	}

	$total_balance =  $total_earnings - ($total_withdrawal + $total_buy_code + $total_payments + $total_wallet_converted);
	if($total_balance<0){
		$total_balance = 0;
	}
		
	return array(
		"total_balance" => $total_balance,
		"total_leveling_bonus" => $total_leveling_bonus,
		"total_pairing_bonus" => $total_pairing_bonus,
		"login_bonus" => $login_bonus,
		"watch_bonus" => $watch_bonus,
		"signup_bonus" => $signup_bonus,
		"sponsored_bonus" => $sponsored_bonus,
		"total_withdrawal" => $total_withdrawal,
		"total_buy_code" => $total_buy_code,
		"total_earnings" => $total_earnings,
		"total_posting_rewards" => $total_posting_rewards,
		"total_wallet_converted" => $total_wallet_converted,
		"available_wallet" => getTotalWallet($user->id)
	);
}

function getDashboardCounts($user_id){

	$user = App\User::where('id', $user_id)->first();

	$login_count = $user->login_history()->count();
	$watch_count = $user->watch_history()->count();
	$referrals_count = $user->sponsored()->count();
	$accounts_count = $user->account()->count();
	$codes_count = $user->code()->where('status','UNUSED')->count();
	$paid_codes_count = $user->paid_code_unused()->count();
	$free_codes_count = $user->free_code_unused()->count();
	$code_request_count = $user->code_request()->count();
	$encashment_count = $user->encashment()->count();
	$buy_code_count = $user->code_buy()->count();
	$points_count = $user->points()->whereDate('created_at', '>=', '2019-01-22')->count();

	$homebook_gold = 0;
	$share_reward = 0;

	if($accounts_count == 1) {

		$homebook_gold = 2000;

		if($share_reward >= 150) {

			$share_reward = 1500;
		} else {

			$share_reward = $watch_count * 10;
		}

	}elseif($accounts_count == 7) {
		
		$homebook_gold = 28000;

		if($share_reward >= 15) {

			$share_reward = 1500;
		} else {

			$share_reward = $watch_count * 150;
		}
	}

	return array(
		"login_count" => $login_count,
		"watch_count" => $watch_count,
		"referrals_count" => $referrals_count,
		"accounts_count" => $accounts_count,
		"codes_count" => $codes_count,
		"paid_codes_count" => $paid_codes_count,
		"free_codes_count" => $free_codes_count,
		"code_request_count" => $code_request_count,
		"encashment_count" => $encashment_count,
		"buy_code_count" => $buy_code_count,
		"points_count" => $points_count,
		"homebook_gold" => $homebook_gold,
		"share_reward" => $share_reward
	);
}

function getTotalWallet($user_id){

	$user =  App\User::where('id', $user_id)->first();

	$total_wallet =  $user->wallet()->sum('amount');

	$total_load_transferred =  $user->load_transfer()->where('wallet',1)->sum('amount');

	$total_withdrawal = $user->encashment()->whereIn('status',['PAID','PENDING'])->sum('amount');

	//$total_reward_transferred = $user->reward()->sum('amount');
	$total_reward_transferred = 0;

	$total_posting_rewards = $user->posting_reward()->where('status',1)->sum('amount');

	$total_payments = $user->payment()->where('status',1)->sum('amount');

	$total_wallet_converted = $user->wallet_efund()->sum('amount');

	$singup_bonus = 0; //change nalang sa 500 pag final na lahat
	$login_bonus = 0;

	$dateActivated = $user->activated_at;
	if($dateActivated == null) {
		$dateActivated = '2017-10-23';
	}

	$login_bonus = 0;
	$date = new DateTime($dateActivated);
	$now = new DateTime('2017-11-09');
	if($date < $now) {
		$login_bonus = 0;
	}else{
		$login_bonus = $user->login_history()->count() * 50;
	}

	if($user->active!=1){
		$login_bonus = 0;
	}

	//sponsor
	$sponsored_bonus = 0;
	$members =  App\User::withCount('paid_account')->where('sponsor_id', $user_id)->where('active', 1)->get();
	foreach($members as $member){
		$sponsored_bonus = $sponsored_bonus + ($member->paid_account_count * 100);
	}

	$total_wallet_move =  $user->wallet_move()->sum('amount');
	$total_buy_code = $user->code_buy()->where('status', 0)->count() * 1000;

	if($date < $now) {
		$total_wallet = ( ( ( $sponsored_bonus * 1 ) + $total_wallet ) - $total_withdrawal - $total_buy_code ) - $total_reward_transferred + $total_wallet_move;
		$total_wallet = $total_wallet + ( ( $login_bonus + $singup_bonus ) * 1 ) - $total_reward_transferred + $total_wallet_move;
	}else{
		$total_wallet = ( ( ( $sponsored_bonus * 1 ) + $total_wallet ) - $total_withdrawal - $total_buy_code ) - $total_reward_transferred + $total_wallet_move;
		
	}

	return $total_wallet + $total_posting_rewards - ( $total_load_transferred + $total_payments + $total_wallet_converted );
}

function getTotalPoints($user_id){
	$user =  App\User::where('id', $user_id)->first();
	
	$singup_bonus = 500;
	$watch_count = 0;

	$dateActivated = $user->activated_at;
	if($dateActivated == null) {
		$dateActivated = '2017-10-23';
	}

	$watch_count = 0;
	$date = new DateTime($dateActivated);
	$now = new DateTime('2017-11-09');
	if($date < $now) {
		$watch_count = 1500;
	}else{
		$watch_count = $user->watch_history()->count() * 200;
	}

	if($user->active!=1){
		$watch_count = 0;
	}

	//$total_reward_transferred = $user->reward()->sum('amount');
	$total_wallet_move =  $user->wallet_move()->sum('amount');
	
	$points = ( ($singup_bonus + $watch_count) * 1 ) - $total_wallet_move;
	if($points<0){
		$points = 0;
	}

	return $points;
}

function getTotalBuyCode($user_id){
	
	$buyCode =  App\BuyCode::where('user_id', $user_id)->where('status', '=', 0)->count();
	$buyCode = $buyCode * 1000;
	return $buyCode;
}

function getTotalWithdrawals($user_id){

	$total_withdrawals =  App\Withdrawal::where('user_id',$user_id)->whereIn('status',['PAID','PENDING'])->sum('amount');
	return $total_withdrawals;
}

function getPwTotalBuyCode($user_id){
	
	$pwbuyCode =  App\BuyCode::where('user_id', $user_id)->count();
	$pwbuyCode = $pwbuyCode * 1000;
	return $pwbuyCode;
}

function getTotalTransferReward($user_id){

	$totalRewards = 0;
	$rewards =  App\Reward::where('user_id', $user_id)->get();
	foreach($rewards as $rwd){
		$totalRewards = floatval($totalRewards) + floatval($rwd->amount);
	}
	return $totalRewards;
}

function getTotalLoadWallet($user_id){
	$user =  App\User::where('id', $user_id)->first();

	$total_load_wallet = $user->load_wallet()->sum('amount');
	$total_received_load_wallet = $user->load_receive()->sum('total');

	$total_load_charge = $user->load_charge()->where('status', 1)->sum('amount');
	$total_transfer_load_wallet = $user->load_transfer()->where('wallet',0)->sum('amount');

	$total_wallet_converted = $user->wallet_efund()->where('fund_type','LOAD')->sum('amount');


	$remaining_load_wallet = ($total_load_wallet + $total_received_load_wallet + $total_wallet_converted) - ($total_load_charge + $total_transfer_load_wallet);
	return $remaining_load_wallet;
}

function getTotalMasterFund($user_id){
	$user =  App\User::where('id', $user_id)->first();

	$total_fund = $user->master_fund()->sum('total');
	$total_receive_fund = $user->master_fund_receive()->sum('total');
	$total_booking = $user->booking()->where('status','CONFIRMED')->sum('total_fare');
	$total_booking_extra_fee = $user->booking_extra_fee()->sum('amount');
	$total_wallet_converted = $user->wallet_efund()->where('fund_type','TNT')->sum('amount');

	$remaining_master_fund = ($total_fund + $total_receive_fund + $total_wallet_converted) - ($total_booking + $total_booking_extra_fee);
	return $remaining_master_fund;
}

function getDealerTotalMasterFund($user_id){
	$user =  App\User::where('id', $user_id)->first();

	$total_fund = $user->master_fund()->sum('total');
	$total_receive_fund = $user->master_fund_receive()->sum('total');
	$total_fund_transferred =  $user->master_fund_transfer()->sum('total');

	$remaining_master_fund = ($total_fund + $total_receive_fund) - $total_fund_transferred;
	return $remaining_master_fund;
}

function getDealerTotalTransferredMasterFund($user_id){
	$user =  App\User::where('id', $user_id)->first();

	$total_fund_transferred =  $user->master_fund_transfer()->sum('total');

	return $total_fund_transferred;
}


function getPayout($user_id, $mode){
	$user =  App\User::where('id', $user_id)->first();

	$pending = 0;
	$cancelled = 0;
	$paid = 0;	$withdrawals = $user->encashment()->where('mode', $mode)->orderBy('created_at','desc')->get();

	foreach($withdrawals as $withdrawal){
		if($withdrawal->status == "PAID"){
			$paid++;
		}elseif($withdrawal->status == "PENDING"){
			$pending++;
		}elseif($withdrawal->status == "CANCELLED"){
			$cancelled++;
		}
		
	}
	
	return array(
		"PAID" => $paid,
		"PENDING" => $pending,
		"CANCELLED" => $cancelled,
		"DATA" => $withdrawals
	);
}

function getSettings($key){

	$settings =  App\Settings::select('value')->where('key', $key)->first();
	return $settings->value;
}

function generateRandomNumber(){
	$random_number = mt_rand(1000, 9999);
	return $random_number;
}

function generateAccountName($user_id){
	$user = App\User::where('id', $user_id)->first();
	
	$accounts_count = intval($user->account()->count()) + 1;

	$pref_username = strToUpper(substr($user->username, 0, 3));

	return 'HB'.$pref_username.''.$accounts_count;
}

function generateVoucher(){

	$alphabet = '1qw2e?rtyu(io3pasd4f*ghj5]klzx+6c)vbnmP7?OIUYT8R@EWQLK9JHGFD#SAMN[BVC%XZ0';
	$pass = array();
	$alphaLength = strlen($alphabet) - 1;
	for ($i = 0; $i < 7; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}

	$voucher_code = App\Voucher::where('code',implode($pass))->first();
	if(!$voucher_code){
		return implode($pass);
	}
}

?>