<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password','role'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token','role', 'pin', 'social_id'];

    protected $appends = ['full_name'];

    // public function sponsor(){
    //      return $this->belongsTo('App\User', 'sponsor_username', 'username');
    // }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function category(){
         return $this->hasMany('App\TicketUserCategories', 'user_id', 'id');
    }


    public function account(){
         return $this->hasMany('App\Account', 'user_id', 'id');
    }

    public function paid_account(){
         return $this->account()->where('status','PAID');
    }
    
    public function free_account(){
         return $this->account()->where('status','FREE');
    }

    public function reseller_kyc(){
         return $this->hasOne('App\ResellerKyc', 'user_id', 'id');
    }


    public function atm_kyc(){
         return $this->hasOne('App\AtmKyc', 'user_id', 'id');
    }

    public function atm_account(){
         return $this->hasOne('App\AtmAccount', 'user_id', 'id');
    }

    public function master_fund(){
         return $this->hasMany('App\MasterFund', 'user_id', 'id');
    }

    public function booking_reward(){
         return $this->hasMany('App\BookingReward', 'user_id', 'id');
    }

    public function master_fund_transfer(){
         return $this->hasMany('App\TransferMasterFund', 'transfer_by_user_id', 'id');
    }

    public function master_fund_receive(){
         return $this->hasMany('App\TransferMasterFund', 'transfer_to_user_id', 'id');
    }


    public function booking(){
         return $this->hasMany('App\Booking', 'user_id', 'id');
    }

    public function booking_extra_fee(){
         return $this->hasMany('App\BookingExtraFee', 'user_id', 'id');
    }

    public function truemoney(){
         return $this->hasOne('App\Truemoney', 'user_id', 'id');
    }

    public function bdo(){
         return $this->hasOne('App\BdoAccount', 'user_id', 'id');
    }

    public function ctbc(){
         return $this->hasOne('App\CtbcAccount', 'user_id', 'id');
    }

    public function yazz(){
         return $this->hasOne('App\YazzAccount', 'user_id', 'id');
    }

    public function payment(){
         return $this->hasMany('App\Payment', 'user_id', 'id');
    }

    public function encashment(){
         return $this->hasMany('App\Withdrawal', 'user_id', 'id');
    }

    public function encashment_truemoney(){
         return $this->hasMany('App\TruemoneyWithdrawal', 'user_id', 'id');
    }

    public function transfer_by(){
         return $this->hasMany('App\TransferCodes', 'transfer_by_user_id', 'id');
    }

    public function transfer_to(){
         return $this->hasMany('App\TransferCodes', 'transfer_to_user_id', 'id');
    }

    public function wallet(){
         return $this->hasMany('App\Wallet', 'user_id', 'id');
    }

    public function load_wallet(){
         return $this->hasMany('App\LoadWallet', 'user_id', 'id');
    }

    public function load_charge(){
         return $this->hasMany('App\LoadCharge', 'user_id', 'id');
    }

    public function load_transfer(){
         return $this->hasMany('App\LoadTransfer', 'transfer_by_user_id', 'id');
    }

    public function load_receive(){
         return $this->hasMany('App\LoadTransfer', 'transfer_to_user_id', 'id');
    }

    public function points(){
         return $this->hasMany('App\Points', 'user_id', 'id');
    }

    public function code(){
         return $this->hasMany('App\Code', 'user_id', 'id');
    }

    public function code_unused(){
         return $this->code()->where('status','UNUSED');
    }

    public function paid_code_unused(){
          return $this->code()->where('code_type','PAID')->where('status','UNUSED');
    }

    public function free_code_unused(){
          return $this->code()->where('code_type','FREE')->where('status','UNUSED');
    }

    public function code_request(){
         return $this->hasMany('App\CodeRequest', 'requested_by_user_id', 'id');
    }

    public function code_buy(){
         return $this->hasMany('App\BuyCode', 'user_id', 'id');
    }

    public function sponsor(){
         return $this->belongsTo('App\User', 'sponsor_id', 'id');
    }

    public function sponsored(){
         return $this->hasMany('App\User', 'sponsor_id', 'id');
    }

    public function login_history(){
         return $this->hasMany('App\LoginHistory', 'user_id', 'id');
    }

    public function watch_history(){
         return $this->hasMany('App\WatchHistory', 'user_id', 'id');
    }

    public function wallet_move(){
         return $this->hasMany('App\WalletMove', 'user_id', 'id');
    }

    public function wallet_efund(){
         return $this->hasMany('App\WalletEFund', 'user_id', 'id');
    }

    public function reward(){
         return $this->hasMany('App\Reward', 'user_id', 'id');
    }

    public function posting_reward(){
         return $this->hasMany('App\PostingReward', 'user_id', 'id');
    }

    public function premium_ads(){
         return $this->hasMany('App\PremiumAds', 'user_id', 'id');
    }

    public function priority_ads(){
         return $this->hasMany('App\PriorityAds', 'user_id', 'id');
    }

    public function voucher(){
          return $this->hasMany('App\Voucher', 'user_id', 'id');
    }    
    
    public function voucher_unused(){
         return $this->voucher()->where('status','UNUSED');
    }

    public function property(){
         return $this->hasMany('App\Property', 'user_id', 'id');
    }

    public function inquiry(){
         return $this->hasMany('App\Inquiry', 'user_id', 'id');
    }
   
}
