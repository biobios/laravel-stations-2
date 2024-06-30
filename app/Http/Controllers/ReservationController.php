<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\Reservation;
use App\Http\Requests\ShowReservationPageRequest;
use App\Http\Requests\CreateReservationRequest;

class ReservationController extends Controller
{
    public function create(Movie $movie, Schedule $schedule, ShowReservationPageRequest $request)
    {
        $user = $request->user();
        $sheet = Sheet::findOrFail($request->sheet_id);

        if(Reservation::where('sheet_id', $sheet->id)->where('schedule_id', $schedule->id)->exists()) {
            //400エラーを返す
            abort(400);    
        }
        
        return view('reservations.create', compact('movie', 'schedule', 'sheet', 'user'));
    }

    public function store(CreateReservationRequest $request)
    {

        if(Reservation::where('sheet_id', $request->sheet_id)->where('schedule_id', $request->schedule_id)->exists()) {
            return redirect('/movies/'.$request->movie_id.'/schedules/'.$request->schedule_id.'/sheets?date='.$request->date)->with('message', 'その座席はすでに予約済みです');
        }

        try {
            Reservation::create($request->validated());
        } catch (\Exception $e) {
            return redirect('/movies/'.$request->movie_id.'/schedules/'.$request->schedule_id.'/sheets?date='.$request->date)->with('message', '予約に失敗しました');
        }

        return redirect('/movies')->with('message', '予約が完了しました');
    }

    public function sheets(Movie $movie, Schedule $schedule)
    {
        //もしパラメータdateが無ければ、400エラーを返す
        if (!request()->has('date')) {
            abort(400);
        }

        $reservations = Reservation::where('schedule_id', $schedule->id)->get();
        $sheetsByGrid = Sheet::fetchSheetsByGrid();
        $sheetsIsReserved = [];
        foreach ($sheetsByGrid as $row => $sheets) {
            foreach ($sheets as $column => $sheet) {
                $sheetsIsReserved[$sheet->id] = false;
            }
        }

        foreach ($reservations as $reservation) {
            $sheetsIsReserved[$reservation->sheet_id] = true;
        }

        return view('reservations.sheets', compact('movie', 'schedule', 'sheetsByGrid', 'sheetsIsReserved'));
    }
}