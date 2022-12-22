<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Film;
use App\Models\Comment;
use Auth;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::get();
        return view('films', ["films" => $films]);
    }


    public function filmsSlug($slug)
    {
        $films = Film::where('slug',$slug)->get();
        return view('films', ["films" => $films]);
    }



    public function addComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'      => ['required', 'integer', 'exists:films,id'],
            'comment' => ['required', 'string']
        ]);
                    
        if($validator->fails()) {
            return response()->json(["success" => false,'message'=>'Invalid data',"errors" => $validator->errors()]);
        }
        try {
              $comment = Comment::create([
                'user_id' => auth()->id(),
                'flim_id' => $request->id,
                'comment' => $request->comment
            ]);
         
            return response()->json(["success" => true,'message'=>' comment save.']);
        }catch (\Throwable $th) {
            info($th);
            return response()->json(["success" => false,'message'=>'Unable to save comment']);
        }
    }
}
