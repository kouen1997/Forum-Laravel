<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Requests\Account\UpdateProfilePasswordRequest;
use App\Http\Requests\Account\UpdateProfilePinRequest;
use App\Http\Requests\Account\UpdateProfileTinRequest;
use App\Http\Requests\Account\SocialConnectRequest;
use App\Http\Requests\Account\EmallConnectRequest;
use App\Http\Requests\Account\AddAccountRequest;
use App\Http\Requests\Account\TransferCodesRequest;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\User;
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
use Hash;
use DB;

class DraftController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth');
        $this->middleware('member',['except' => ['getMemberImg']]);
    }

    public function getAnnouncements(){

        $user = Auth::user();
        
        return  view('draft.announcements')->with('user',$user);       
    }

    public function getGetSupport(){

        $user = Auth::user();
        
        return  view('draft.support')->with('user',$user);       
    }

    public function getEloading(){

        $user = Auth::user();
        
        return  view('draft.eloading')->with('user',$user);       
    }

    public function getHotelBooking(){

        $user = Auth::user();
        
        return  view('draft.hotel-booking')->with('user',$user);       
    }

    public function getAirlineTicketing(){

        $user = Auth::user();
        
        return  view('draft.airline-ticketing')->with('user',$user);       
    }

    public function getEcommerce(){

        $user = Auth::user();
        
        return  view('draft.ecommerce')->with('user',$user);       
    }

    public function getActivateAccount(){

        $user = Auth::user();
        
        return  view('draft.account.activate')->with('user',$user);       
    }

    public function getAddAccount(){

        $user = Auth::user();
        
        return  view('draft.account.add')->with('user',$user);       
    }

    public function getMyAccounts(){

        $user = Auth::user();
        
        return  view('draft.account.accounts')->with('user',$user);       
    }

    public function getGenealogy(){

        $user = Auth::user();
        
        return  view('draft.network.genealogy')->with('user',$user);       
    }

    public function getSubscribers(){

        $user = Auth::user();
        
        return  view('draft.network.subscribers')->with('user',$user);       
    }

    public function getEWalletWithdrawal(){

        $user = Auth::user();
        
        return  view('draft.e-wallet.withdrawal')->with('user',$user);       
    }

    public function getEWalletWithdrawalRequests(){

        $user = Auth::user();
        
        return  view('draft.e-wallet.requests')->with('user',$user);       
    }

    public function getEwalletSummary(){

        $user = Auth::user();
        
        return  view('draft.e-wallet.summary')->with('user',$user);       
    }

    public function getTerms(){

        $user = Auth::user();
        
        return  view('draft.terms')->with('user',$user);       
    }

    public function getSecurityPin(){

        $user = Auth::user();
        
        return  view('draft.security.pin')->with('user',$user);       
    }

}
