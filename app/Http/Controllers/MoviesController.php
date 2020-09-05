<?php

namespace App\Http\Controllers;

use App\Movies;
use Illuminate\Http\Request;
use DB;
class MoviesController extends Controller
{
   public function getAll(){
       $res = DB::table('movies')->get();
       return response()->json($res);
   }

   public function addMovie(Request $request){
    //    dd($request->all());
       DB::table('movies')->insert([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'genre' => $request->genre
       ]);
       return response()->json('movie created');
   }

   public function updateMovie(Request $request){
       DB::table('movies')->where('id',$request->id)
            ->update([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'duration' => $request->duration,
            'genre' => $request->genre
        ]);

        return response()->json('updated');
   }

   public function deleteMovie(Request $request){
       DB::table('movies')->where('id',$request->id)->delete();
       return response()->json('deleted!');
   }
}
