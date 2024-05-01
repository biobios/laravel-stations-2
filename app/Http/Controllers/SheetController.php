<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Sheet;

class SheetController extends Controller
{
    public function index()
    {
        return view('sheets.index', ['sheetsByGrid' => Sheet::fetchSheetsByGrid()]);
    }

    public function showForReservation(Movie $movie, Schedule $schedule)
    {
        $sheetsByGrid = Sheet::fetchSheetsByGrid();
        return view('sheets.show', compact('movie', 'schedule', 'sheetsByGrid'));
    }
}