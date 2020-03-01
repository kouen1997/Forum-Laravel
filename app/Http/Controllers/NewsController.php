<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Input;
use File;
use Auth;
use Crypt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\News;
use App\NewsViews;
use App\Http\Requests\News\AddNewsRequest;
use App\Http\Requests\News\EditNewsRequest;

class NewsController extends Controller
{
    
    public function getNews()
    {
        
        $newss = News::latest()->paginate(20);
        
        if($newss){

            $mostViewed = NewsViews::select('news_id')
                            ->groupBy('news_id')
                            ->orderBy(DB::raw('count(news_id)'), 'DESC')
                            ->take(10)
                            ->get();

            return view('news.news')->with('newss', $newss)->with('mostViewed', $mostViewed);

        }else{

            return abort(404);

        }
            
    }
    public function getViewNews($slug)
    {
        
        try{

            $news = News::where('slug', $slug)->first();

            if($news){

                $lnewss = News::latest()->paginate(10);

                $user = Auth::user();

                if($user){

                    $views = NewsViews::where('user_id', $user->id)->where('news_id', $news->id)->first();

                    if(!$views){

                        $view = new NewsViews;
                        $view->user_id = $user->id;
                        $view->news_id = $news->id;
                        $view->save();

                    }
                }
                
                return view('news.view_news')->with('news', $news)->with('lnewss', $lnewss);

            }else{

                return abort(404);

            }

        } catch(\Exception $e) {

           return abort(404);
            
        }

            
    }
    public function getNewsList()
    {
        try{

            $user = Auth::user();

            if($user){

                $newss = News::latest()->paginate(20);

                return view('news.news_listing', compact('newss'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getAddNews()
    {
        try{

            $user = Auth::user();

            if($user){

                return view('news.add_news');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postAddNews(AddNewsRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $news = new News;
                $news->title = $request->title;
                if (!File::exists(public_path()."/news")) {
                    File::makeDirectory(public_path()."/news");
                }
                
                if ($request->hasFile('cover_image')) {

                    $newsImage = $request->file('cover_image');
                    $strippedName = str_replace(' ', '', $newsImage->getClientOriginalName());
                    $photoName = date('Y-m-d-H-i-s').$strippedName;

                    $news_image = Image::make($newsImage->getRealPath());
                    $news_image->resize(400, 400)->save(public_path().'/news/'.$photoName, 60);

                    $news->cover_image = $photoName;
                }
                $news->content = $request->description;
                $news->save();

                return redirect('/news/list');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function getEditNews($id)
    {
        try{

            $user = Auth::user();

            if($user){

                $news = News::where('id', Crypt::decrypt($id))->first();

                return view('news.edit_news', compact('news'));

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postEditNews(EditNewsRequest $request)
    {
        try{

            $user = Auth::user();

            if($user){

                $news = News::where('id', $request->id)->first();
                $news->title = $request->title;
                if (!File::exists(public_path()."/news")) {
                    File::makeDirectory(public_path()."/news");
                }
                
                if ($request->hasFile('cover_image')) {

                    $file_path = public_path().'/news/'.$news->cover_image;

                    if(file_exists($file_path)){

                        if(!empty($news->cover_image)){
                            unlink($file_path);
                        }
                        
                    }

                    $newsImage = $request->file('cover_image');
                    $strippedName = str_replace(' ', '', $newsImage->getClientOriginalName());
                    $photoName = date('Y-m-d-H-i-s').$strippedName;

                    $news_image = Image::make($newsImage->getRealPath());
                    $news_image->resize(400, 400)->save(public_path().'/news/'.$photoName, 60);

                    $news->cover_image = $photoName;
                }
                $news->content = $request->description;
                $news->save();

                return redirect('/news/list');

            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
    public function postDeleteNews($news_id)
    {
        try{

            $user = Auth::user();

            if($user){

                $news = News::find($news_id);

                $file_path = public_path().'/news/'.$news->cover_image;

                if(file_exists($file_path)){

                    if(!empty($news->cover_image)){
                        unlink($file_path);
                    }
                    
                }

                $news->delete();

                return response()->json(['status' => 'success']);
            }

        } catch(\Exception $e) {

           return response()->json(['status'=>false, 'message'=>$e->getMessage()], 422);
            
        }
    }
}
