<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use App\Http\Requests\SearchMovieRequest;

class MovieController extends Controller
{
    public function index(SearchMovieRequest $request)
    {
        //ページネーションする
        $query = Movie::query();
        $query = $request->search($query);
        $movies = $query->paginate(20);
        $movies->appends($request->getParams());
        return view('movies', ['movies' => $movies, 'search' => $request]);
    }

    public function show(Movie $movie)
    {
        $schedules = Schedule::where('movie_id', $movie->id)->orderBy('start_time')->get();
        return view('show', ['movie' => $movie, 'schedules' => $schedules]);
    }
}