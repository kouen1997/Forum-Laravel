<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Auth;
use Crypt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Trivia;
use App\TriviaViews;
use App\Http\Requests\Trivia\AddTriviaRequest;
use App\Http\Requests\Trivia\EditTriviaRequest;

class TriviaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrivia()
    {
        try{

            $user = Auth::user();

            if($user){

                $trivias = Trivia::latest()->paginate(20);

                $mostViewed = TriviaViews::select('trivia_id')
                                    ->groupBy('trivia_id')
                                    ->orderBy(DB::raw('count(trivia_id)'), 'DESC')
                                    ->take(10)
                                    ->get();

                return view('trivia.trivia', compact('trivias','mostViewed'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getViewTrivia($slug)
    {
        try{

            $user = Auth::user();

            if($user){

                $trivia = Trivia::where('slug', $slug)->first();
                $views = TriviaViews::where('user_id', $user->id)->where('trivia_id', $trivia->id)->first();

                if($trivia){

                    if(!$views){

                        $view = new TriviaViews;
                        $view->user_id = $user->id;
                        $view->trivia_id = $trivia->id;
                        $view->save();

                    }

                    return view('trivia.view_trivia', compact('trivia'));

                }else{

                    return abort(404);
                    
                }

            }

        } catch(\Exception $e) {

           return abort(404);
            
        }
    }
    public function getTriviaList()
    {
        try{

            $user = Auth::user();

            if($user){

                $trivias = Trivia::latest()->paginate(20);

                return view('trivia.trivia_listing', compact('trivias'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getAddTrivia()
    {
        try{

            $user = Auth::user();

            if($user){

                return view('trivia.add_trivia');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postAddTrivia(AddTriviaRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $trivia = new Trivia;
                $trivia->title = $request->title;
                $trivia->content = $request->content;
                $trivia->save();

                return redirect('/trivia/list');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

    public function getEditTrivia($id)
    {
        try{

            $user = Auth::user();

            if($user){

                $trivia = Trivia::where('id', Crypt::decrypt($id))->first();

                return view('trivia.edit_trivia', compact('trivia'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postEditTrivia(EditTriviaRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $trivia = Trivia::where('id', $request->id)->first();
                $trivia->title = $request->title;
                $trivia->content = $request->content;
                $trivia->save();

                return redirect('/trivia/list');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postDeleteTrivia($trivia_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $trivia = Trivia::find($trivia_id);
                $trivia->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }

}
