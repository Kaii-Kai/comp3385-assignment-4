<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;


class MovieController extends Controller
{
     public function index() {
		$movies = Movie::all();
		
		return response()->json([
			'movies' => $movies
		]);
	}
	
	 public function store(Request $request){
		 $validator = Validator::make($request->all(), [
		 'title' => 'required',
         'description' => 'required',
         'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    if ($validator->fails()) {
        return response()->json([
		'message' => 'Validation failed',
		'errors' => $validator->errors(),
		], 422);
    }

	if ($request->hasFile('poster')) {
        $posterPath = $request->file('poster')->store('posters', 'public'); 
        $posterUrl = Storage::url($posterPath); 
    } else {
        $posterUrl = null; 
		
    }
    $movie = Movie::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'poster' => $imagePath,
    ]);

    return response()->json([
		'message' => 'Movie created successfully', 
		'movie' => $movie, 
	]201);
		
	}
}
