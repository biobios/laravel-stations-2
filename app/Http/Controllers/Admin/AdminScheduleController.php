<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

class AdminScheduleController extends Controller
{

    public function index()
    {
        $movies = Movie::with('schedules')->get();
        return view('admin.schedules.index', ['moviesWithSchedules' => $movies]);
    }

    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    public function create(Movie $movie)
    {
        return view('admin.schedules.create', compact('movie'));
    }

    public function store(CreateScheduleRequest $request, Movie $movie)
    {
        Schedule::create($request->safe()->merge(['movie_id' => $movie->id])->all());

        return redirect('admin/schedules');
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return redirect('admin/schedules');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect('admin/schedules');
    }
}