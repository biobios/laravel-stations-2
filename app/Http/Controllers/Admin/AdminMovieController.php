<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMovieController extends Controller
{
    public function index()
    {
        return view('admin.movies.index', ['movies' => Movie::all()]);
    }

    public function show(Movie $movie)
    {
        return view('admin.movies.show', ['movie' => $movie]);
    }

    public function create(Movie $movie)
    {
        return view('admin.movies.create');
    }

    public function store(CreateMovieRequest $request)
    {
        DB::transaction(function () use ($request) {
            Movie::create($request->validated());
        });

        return redirect('admin/movies');
    }

    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', ['movie' => $movie]);
    }

    public function update(Movie $movie, UpdateMovieRequest $request)
    {

        DB::transaction(function () use ($request, $movie) {
            $movie->update($request->validated());
        });

        return redirect('admin/movies');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect('admin/movies');
    }
}