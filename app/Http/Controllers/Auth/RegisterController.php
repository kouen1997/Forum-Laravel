<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\RegisterRequest;
use DB;
use Redirect;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRegister()
    {
        if (Auth::check()) {
            
            $role = Auth::user()->role;

            if ($role == 1) {
                return redirect('/dashboard');   
            } elseif ($role == 0) {
                return redirect('/admin');   
            } else {
                return view('auth.register');
            }

        } else {
            return view('auth.register');
        }
    }

    public function postRegister(RegisterRequest $request){

        if (Auth::check()) {

            $role = Auth::user()->role;

            if($role == 0){
                return redirect('/admin');
            } else {
                return redirect('/dashboard');
            }
        }

        //lets validate email first
        //$ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, "https://apilayer.net/api/check?access_key=f9ed04fcb3f320f46f88274d1f9cab60&email=".$request->email."&smtp=1&format=1");
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
//
        //$headers = array();
        //$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        //$headers[] = "Accept-Encoding: gzip, deflate, br";
        //$headers[] = "Accept-Language: en-US,en;q=0.9";
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
        //$result = json_decode(curl_exec($ch));
        //if (curl_errno($ch)) {
//
        //    Session::flash('danger', "Something went wrong. Please try again.");
        //    return Redirect::back();
//
        //}
        //curl_close ($ch);
//
        //if($result && isset($result->smtp_check) && $result->smtp_check == true){
   
            try {

                //find sponsor
                $sponsor = User::where('username',$request->sponsor)->first();

                if($sponsor){

                    $user = new User;
                    $user->first_name = ucwords(strtolower($request->first_name));
                    $user->middle_name = ucwords(strtolower($request->middle_name));
                    $user->last_name = ucwords(strtolower($request->last_name));
                    $user->email = $request->email;
                    $user->mobile = $request->mobile;
                    $user->username = $request->username;
                    $user->password = bcrypt($request->password);
                    $user->sponsor_id = $sponsor->id;
                    $user->pin = $request->pin;
                    $user->pin_attempt = DB::raw('pin_attempt+1');
                    $user->sponsor_username = $sponsor->username;
                    $user->role = 1;
                    $user->save();

                    Session::flash('success', "You have created your account. You may now login.");
                    return redirect('/login');
                    
                } else {
                    return response()->json(array("result"=>false,"message"=>'We couldn\'t find your sponsor. Please double-check and try again.'),422);
                }
                  
            }catch(\Exception $e){
                return response()->json(array("result"=>false,"msg"=>'Something went wrong. Please try again.'),422);
            }

        //} else {
//
        //    Session::flash('danger', "Invalid email, please make sure you email is working!");
        //    return Redirect::back();
        //}
        
   }
}
