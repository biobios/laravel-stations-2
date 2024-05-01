<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminReservationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{movie}', [MovieController::class, 'show']);
Route::get('/movies/{movie}/schedules/{schedule}/sheets', [ReservationController::class, 'sheets']);
Route::get('/movies/{movie}/schedules/{schedule}/reservations/create', [ReservationController::class, 'create']);

Route::get('/sheets', [SheetController::class, 'index']);

Route::post('/reservations/store', [ReservationController::class, 'store']);

Route::get('/admin/movies', [AdminMovieController::class, 'index']);

Route::get('/admin/movies/create', [AdminMovieController::class, 'create']);
Route::post('/admin/movies/store', [AdminMovieController::class, 'store']);

Route::get('/admin/movies/{movie}', [AdminMovieController::class, 'show']);
Route::get('/admin/movies/{movie}/edit', [AdminMovieController::class, 'edit']);
Route::post('/admin/movies/{movie}/update', [AdminMovieController::class, 'update']);
Route::patch('/admin/movies/{movie}/update', [AdminMovieController::class, 'update']);

Route::delete('/admin/movies/{movie}/destroy', [AdminMovieController::class, 'destroy']);

Route::get('/admin/movies/{movie}/schedules/create', [AdminScheduleController::class, 'create']);
Route::post('/admin/movies/{movie}/schedules/store', [AdminScheduleController::class, 'store']);

Route::get('/admin/schedules', [AdminScheduleController::class, 'index']);
Route::get('/admin/schedules/{schedule}', [AdminScheduleController::class, 'show']);
Route::get('/admin/schedules/{schedule}/edit', [AdminScheduleController::class, 'edit']);
Route::patch('/admin/schedules/{schedule}/update', [AdminScheduleController::class, 'update']);
Route::delete('/admin/schedules/{schedule}/destroy', [AdminScheduleController::class, 'destroy']);

Route::get('/admin/reservations', [AdminReservationController::class, 'index']);
Route::post('/admin/reservations', [AdminReservationController::class, 'store']);
Route::get('/admin/reservations/create', [AdminReservationController::class, 'create']);
Route::get('/admin/reservations/{reservation}', [AdminReservationController::class, 'show']);
Route::get('/admin/reservations/{reservation}/edit', [AdminReservationController::class, 'show']);
Route::patch('/admin/reservations/{reservation}', [AdminReservationController::class, 'update']);
Route::delete('/admin/reservations/{reservation}', [AdminReservationController::class, 'destroy']);