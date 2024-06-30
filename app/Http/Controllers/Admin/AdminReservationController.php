<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\User;
use App\Http\Requests\CreateAdminReservationRequest;
use App\Http\Requests\UpdateAdminReservationRequest;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations =
            Reservation::with(['schedule.movie', 'user'])
            ->whereHas('schedule', function($query) {
                $query->where('end_time', '>', now());
            })->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $schedules = Schedule::with('movie')->get();
        $sheets = Sheet::all();
        $users = User::all();
        return view('admin.reservations.create', compact('schedules', 'sheets', 'users'));
    }

    public function store(CreateAdminReservationRequest $request)
    {
        Reservation::create($request->validated());
        return redirect('/admin/reservations')->with('message', '予約を追加しました');
    }

    public function show(Reservation $reservation)
    {
        $sheets = Sheet::all();
        $schedules = Schedule::with('movie')->get();
        $users = User::all();
        return view('admin.reservations.show', compact('reservation', 'sheets', 'schedules', 'users'));
    }

    public function update(Reservation $reservation, UpdateAdminReservationRequest $request)
    {
        $reservation->update($request->validated());
        return redirect('/admin/reservations')->with('message', '予約を更新しました');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect('/admin/reservations')->with('message', '予約を削除しました');
    }
}
