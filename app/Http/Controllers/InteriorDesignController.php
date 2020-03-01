<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\InteriorDesign;
use App\Http\Requests\InteriorDesign\AddInteriorDesignRequest;
use App\Http\Requests\InteriorDesign\EditInteriorDesignRequest;

class InteriorDesignController extends Controller
{
	public function __construct()
    {   
        $this->middleware('auth');
    }

	public function getInteriorDesignListing()
    {
        try{

            $user = Auth::user();

            if($user){

            	$interior_designs = InteriorDesign::where('user_id', $user->id)->latest()->paginate(20);
               	return view('member.interior_design_listing', compact('interior_designs'));

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

              $interior_designs = InteriorDesign::where('user_id', $user->id)->latest()->paginate(20);

              $responseHtml = view('member.interior_design_data', compact('interior_designs'))->render();

              return response()->json(['status' => 'success', 'responseHtml' => $responseHtml]);

            }

        }catch(\Exception $e){

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
        
    }

    public function getAddInteriorDesign()
    {
        try{

            $user = Auth::user();

            if($user){

               	return view('member.interior_design_add', compact('user'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postAddInteriorDesign(AddInteriorDesignRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

            	$interior_design = new InteriorDesign;
            	$interior_design->user_id = $user->id;
            	$interior_design->contact = $request->mobile;
            	$interior_design->property_type = $request->property_type;
            	$interior_design->save();

               
            	Session::flash('success', 'Interior Design Successfully added.');
            	return Redirect::back();

            }

        } catch(\Exception $e) {

          	Session::flash('danger', $e->getMessage());
            return Redirect::back();
            
        }
    }
    public function getEditInteriorDesign($id)
    {
        try{

            $user = Auth::user();

            if($user){

                $interior_design = InteriorDesign::where('id', $id)->first();
                return view('member.interior_design_edit', compact('user','interior_design'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function postEditInteriorDesign(EditInteriorDesignRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $interior_design = InteriorDesign::where('id', $request->id)->first();
                $interior_design->contact = $request->mobile;
                $interior_design->property_type = $request->property_type;
                $interior_design->save();

               
                Session::flash('success', 'Interior Design Successfully edited.');
                return Redirect::back();

            }

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
            
        }
    }
    public function postDeleteInteriorDesign($interior_design_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $deleteinterior = InteriorDesign::where('id', $interior_design_id);

                $deleteinterior->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
}