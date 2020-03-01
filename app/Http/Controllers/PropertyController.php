<?php

namespace App\Http\Controllers;

use DB;
use URL;
use File;
use Session;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\User;
use App\Property;
use App\Photos;
use App\Inquiry;
use App\Http\Requests\Property\AddPropertyRequest;
use App\Http\Requests\Property\EditPropertyRequest;


class PropertyController extends Controller
{

    public function getSearchProperty(Request $request) {

        $user = Auth::user();

        $search_type = $request->property_type;
        $search_where = $request->address;
        $search_min_price = $request->from;
        $search_max_price = $request->to;

        if($search_type != NULL && $search_where == NULL) {

            $properties = Property::with('photos','user')
                ->where('property_type',$search_type)
                ->whereBetween('price', [$search_min_price, $search_max_price])
                ->orderBy('created_at', 'DESC')
                ->paginate(6);
            if($properties->isEmpty()) {
                return redirect('/');
            }

        } elseif($search_where) {

            $properties = Property::with('photos','user')
                ->where('property_type',$search_type)
                ->whereBetween('price', [$search_min_price, $search_max_price])
                ->where('address','like', '%'.$search_where.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate(6);
            if($properties->isEmpty()) {
                return redirect('/');
            }

        } else {
            
            //$properties = Property::with('photos','user')->where('offer_type','Sell')->orderBy('created_at', 'DESC')->paginate(6);
            
            //if($properties->isEmpty()) {
                return redirect('/');
            //}
        }

        $random_property = Property::with('photos')->take(3)->inRandomOrder()->get();

        return view('properties.search')->with('user',$user)->with('properties',$properties)->with('random_property',$random_property);
    }

    public function getForSaleProperties(Request $request) {

        $user = Auth::user();

        $search_type = $request->property_type;
        $search_where = $request->address;
        $search_min_price = $request->from;
        $search_max_price = $request->to;

        if($search_type != NULL && $search_where == NULL) {

            $properties = Property::with('photos','user')
                ->where('offer_type','Sell')
                ->where('property_type',$search_type)
                ->whereBetween('price', [$search_min_price, $search_max_price])
                ->orderBy('created_at', 'DESC')
                ->paginate(6);
            if($properties->isEmpty()) {
                return redirect('/');
            }

        } elseif($search_where) {

            $properties = Property::with('photos','user')
                ->where('offer_type','Sell')
                ->where('property_type',$search_type)
                ->whereBetween('price', [$search_min_price, $search_max_price])
                ->where('address','like', '%'.$search_where.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate(6);
            if($properties->isEmpty()) {
                return redirect('/');
            }

        } else {
            
            $properties = Property::with('photos','user')->where('offer_type','Sell')->orderBy('created_at', 'DESC')->paginate(6);
            
            if($properties->isEmpty()) {
                return redirect('/');
            }
        }

        $random_property = Property::with('photos')->take(3)->inRandomOrder()->get();

        return view('properties.for-sale')->with('user',$user)->with('properties',$properties)->with('random_property',$random_property);
    }

    public function getForRentProperties(Request $request) {

        $user = Auth::user();

        $search_type = $request->property_type;
        $search_where = $request->address;
        $search_min_price = $request->from;
        $search_max_price = $request->to;

        if($search_type != NULL && $search_where == NULL) {

            $properties = Property::with('photos','user')
                ->where('offer_type','Rent')
                ->where('property_type',$search_type)
                ->whereBetween('price', [$search_min_price, $search_max_price])
                ->orderBy('created_at', 'DESC')
                ->paginate(6);
            if($properties->isEmpty()) {
                return redirect('/');
            }

        } elseif($search_where) {

            $properties = Property::with('photos','user')
                ->where('offer_type','Rent')
                ->where('property_type',$search_type)
                ->whereBetween('price', [$search_min_price, $search_max_price])
                ->where('address','like', '%'.$search_where.'%')
                ->orderBy('created_at', 'DESC')
                ->paginate(6);
            if($properties->isEmpty()) {
                return redirect('/');
            }

        } else {
            
            $properties = Property::with('photos','user')->where('offer_type','Rent')->orderBy('created_at', 'DESC')->paginate(6);
            
            if($properties->isEmpty()) {
                return redirect('/');
            }
        }

        $random_property = Property::with('photos')->take(3)->inRandomOrder()->get();

        return view('properties.for-rent')->with('user',$user)->with('properties',$properties)->with('random_property',$random_property);
    }

    public function getSingleProperty($slug) {

        $user = Auth::user();
        
        $property = Property::with('photos','user')->where('slug',$slug)->first();

        if($property){

            $random_property = Property::with('photos')->where('id', '!=', $property->id)->take(3)->inRandomOrder()->get();

            return view('properties.detail')->with('user',$user)->with('property',$property)->with('random_property',$random_property);
        }else{

            return abort(404);
        }
    }

    //public function getSearchProperties(Request $request) {

    //    $user = Auth::user();
    //    
    //    $properties = Property::with('photos','user')->orderBy('created_at', 'DESC')->paginate(6);
    //    $search = $request->q;
    //    $user = User::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'email', 'LIKE', '%' . $q . '%' )->get ();
    //    $random_property = Property::with('photos')->take(3)->inRandomOrder()->get();

    //    if($properties->isEmpty()) {
    //        return redirect('/');
    //    }

    //    return view('properties.searcj')->with('user',$user)->with('properties',$properties)->with('random_property',$random_property);
    //}

    public function postPropertyInquiry($id, Request $request) {

        try {

            $user_id = (Auth::user()) ? auth()->user()->id : NULL;

            $property = Property::where('id',$id)->first();
            
            if(!$property) {

                return redirect('/');
            }

            $inquiry = new Inquiry;
            $inquiry->user_id = $user_id;
            $inquiry->property_id = $property->id;
            $inquiry->name = $request->name;
            $inquiry->email = $request->email;
            $inquiry->phone = $request->phone;
            $inquiry->message = $request->message;
            $inquiry->status = 'PENDING';

            $inquiry->save();

            return redirect('/');

        } catch(\Exception $e) {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getuserListingProperty() {

        try {
            
            $user = Auth::user();

            if($user){

                return view('member.property_listing');

            }

        } catch(\Exception $e) {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function getuserListingPropertyData(Request $request) {

        if ($request->wantsJson()) {

            $user = Auth::user();

            $properties = Property::where('user_id', $user->id)->orderBy('created_at','desc');
            
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
                    return '<a class="btn btn-info btn-sm" href="/profile/property/edit/'.$properties->id.'">Edit</a>

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


    public function getuserAddProperty() {

        try {
            
            $user = Auth::user();

            if($user){

                return view('member.add_property')->with('user', $user);

            }

        } catch(\Exception $e) {

            return response()->json(array("result"=>false,"message"=>'Something went wrong. Please try again!'),422);
        }

    }

    public function postuserAddProperty(AddPropertyRequest $request) {

        try {

            $user = Auth::user();

            if(!empty($user->suffix)){

                $name = $user->first_name.' '.$user->middle_name.' '.$user->last_name.' '.$user->suffix;

            }else{

                $name = $user->first_name.' '.$user->middle_name.' '.$user->last_name;

            }
            


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
            $property->name = $name;
            $property->email = $user->email;
            $property->mobile = $user->mobile;
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
    public function getuserEditProperty($id) {

        $user = Auth::user();

        $property = Property::with('photos')->where('id',$id)->first();

        if($property) {

            return view('member.edit_property')->with('user',$user)->with('property',$property);

        } else {
            
            return redirect('/profile/property/listing');
        }

    }
    public function postuserEditProperty(EditPropertyRequest $request) {

        try {

            $user = Auth::user();

            if(!empty($user->suffix)){

                $name = $user->first_name.' '.$user->middle_name.' '.$user->last_name.' '.$user->suffix;

            }else{

                $name = $user->first_name.' '.$user->middle_name.' '.$user->last_name;

            }
            


            $available_at_date = Carbon::parse($request->available_from)->format('Y-m-d');
            $property = Property::where('id', $request->property_id)->first();
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
            $property->name = $name;
            $property->email = $user->email;
            $property->mobile = $user->mobile;
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

    public function postuserDeleteImage(Request $request, $image_id) {

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

    public function postuserDeleteProperty(Request $request, $property_id)
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

}
