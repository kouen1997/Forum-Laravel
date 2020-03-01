<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ArchitecturalDesign;
use App\Http\Requests\ArchitecturalDesign\AddArchitecturalDesignRequest;
use App\Http\Requests\ArchitecturalDesign\EditArchitecturalDesignRequest;

class ArchitecturalDesignController extends Controller
{
	public function __construct()
    {   
        $this->middleware('auth');
    }

	public function getArchitecturalDesignListing()
    {
        try{

            $user = Auth::user();

            if($user){

            	$architectural_designs = ArchitecturalDesign::where('user_id', $user->id)->latest()->paginate(20);
               	return view('member.architectural_design_listing', compact('architectural_designs'));

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

              $architectural_designs = ArchitecturalDesign::where('user_id', $user->id)->latest()->paginate(20);

              $responseHtml = view('member.architectural_design_data', compact('architectural_designs'))->render();

              return response()->json(['status' => 'success', 'responseHtml' => $responseHtml]);

            }

        }catch(\Exception $e){

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
        }
        
    }

    public function getAddArchitecturalDesign()
    {
        try{

            $user = Auth::user();

            if($user){

               	return view('member.architectural_design_add', compact('user'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postAddArchitecturalDesign(AddArchitecturalDesignRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

            	$architectural_design = new ArchitecturalDesign;
            	$architectural_design->user_id = $user->id;
            	$architectural_design->contact = $request->mobile;
            	$architectural_design->property_type = $request->property_type;
            	$architectural_design->save();

               
            	Session::flash('success', 'Architectural Design Successfully added.');
            	return Redirect::back();

            }

        } catch(\Exception $e) {

          	Session::flash('danger', $e->getMessage());
            return Redirect::back();
            
        }
    }

    public function getEditArchitecturalDesign($id)
    {
        try{

            $user = Auth::user();

            if($user){

                $architectural_design = ArchitecturalDesign::where('id', $id)->first();
                return view('member.architectural_design_edit', compact('user','architectural_design'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function postEditArchitecturalDesign(EditArchitecturalDesignRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $architectural_design = ArchitecturalDesign::where('id', $request->id)->first();
                $architectural_design->contact = $request->mobile;
                $architectural_design->property_type = $request->property_type;
                $architectural_design->save();

               
                Session::flash('success', 'Architectural Design Successfully edited.');
                return Redirect::back();

            }

        } catch(\Exception $e) {

            Session::flash('danger', $e->getMessage());
            return Redirect::back();
            
        }
    }

    public function postDeleteArchitecturalDesign($architectural_design_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $deleteArchi = ArchitecturalDesign::where('id', $architectural_design_id);

                $deleteArchi->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
}