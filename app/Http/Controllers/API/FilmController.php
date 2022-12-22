<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Film;
use App\Http\Resources\FilmRequestResource;

class FilmController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = Film::latest()->paginate(10);
        return $this->setPagination($film)->response(true, FilmRequestResource::collection($film), [], "Film request list", 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => ['required', 'string'],
            'description'  => ['required', 'string'],
            'release_date' => ['required', 'date_format:Y-m-d H:i'],
            'rating'       => ['required', 'integer'],
            'ticket_price' => ['required', 'numeric'],
            'country'      => ['required', 'string'],
            'genre'        => ['required', 'string'],
            'photo'        => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return $this->response(false, [], $validator->errors(), "Some parameters are missing. please provide them.", 422);
        }

        try {
            $photo = $request->file('photo');
            if ($photo) {
                $attachment = $photo->store('uploads/media');
            }

            $film = Film::create([
                'name'         => $request->name,
                'description'  => $request->description,
                'release_date' => $request->release_date,
                'rating'       => $request->rating,
                'ticket_price' => $request->ticket_price,
                'slug'         => Str::slug($request->name),
                'country'      => $request->country,
                'genre'        => $request->genre,
                'photo'        => $attachment??''
            ]);

            return $this->response(true, $film, [], "Film request has been submitted", 200);
        } catch (\Throwable $th) {
            info($th);
           return $this->response(false, [], ["error" => 'Unable to create Film!'], "We are sorry! Your Film cannot be created.", 400); 
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id'           => ['required', 'integer', 'exists:films,id'],
            'name'         => ['required', 'string'],
            'description'  => ['required', 'string'],
            'release_date' => ['required', 'date_format:Y-m-d H:i'],
            'rating'       => ['required', 'integer'],
            'ticket_price' => ['required', 'numeric'],
            'country'      => ['required', 'string'],
            'genre'        => ['required', 'string'],
            'photo'        => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
                    
        if($validator->fails()) {
            return response()->json(["success" => false,'message'=>'Invalid data',"errors" => $validator->errors()]);
        }
        try {

            $photo = $request->file('photo');
            if ($photo) {
                $attachment = $photo->store('uploads/media');
            }

            $film               = Film::find($request->id);
            $film->name         = $request->name;
            $film->description  = $request->description;
            $film->release_date = $request->release_date;
            $film->rating       = $request->rating;
            $film->ticket_price = $request->ticket_price;
            $film->slug         = Str::slug($request->name);
            $film->country      = $request->country;
            $film->genre        = $request->genre;
            $film->photo        = $attachment??'';
            $film->update();
         
            return response()->json(["success" => true]);
        }catch (\Throwable $th) {
            info($th);
            return response()->json(["success" => false,'message'=>'Unable to update']);
        }
    }
}
