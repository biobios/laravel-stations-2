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

Route::prefix('/movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{movie}', [MovieController::class, 'show']);
    Route::get('/{movie}/schedules/{schedule}/sheets', [ReservationController::class, 'sheets']);
    Route::get('/{movie}/schedules/{schedule}/reservations/create', [ReservationController::class, 'create']);
});

Route::get('/sheets', [SheetController::class, 'index']);

Route::post('/reservations/store', [ReservationController::class, 'store']);

Route::prefix('/admin')->group(function () {
    Route::prefix('/movies')->group(function () {
        Route::get('/', [AdminMovieController::class, 'index']);

        Route::get('/create', [AdminMovieController::class, 'create']);
        Route::post('/store', [AdminMovieController::class, 'store']);
        
        Route::get('/{movie}', [AdminMovieController::class, 'show']);
        Route::get('/{movie}/edit', [AdminMovieController::class, 'edit']);
        Route::post('/{movie}/update', [AdminMovieController::class, 'update']);
        Route::patch('/{movie}/update', [AdminMovieController::class, 'update']);
        Route::delete('/{movie}/destroy', [AdminMovieController::class, 'destroy']);
        
        Route::get('/{movie}/schedules/create', [AdminScheduleController::class, 'create']);
        Route::post('/{movie}/schedules/store', [AdminScheduleController::class, 'store']);        
    });

    Route::prefix('/schedules')->group(function () {
        Route::get('/', [AdminScheduleController::class, 'index']);
        Route::get('/{schedule}', [AdminScheduleController::class, 'show']);
        Route::get('/{schedule}/edit', [AdminScheduleController::class, 'edit']);
        Route::patch('/{schedule}/update', [AdminScheduleController::class, 'update']);
        Route::delete('/{schedule}/destroy', [AdminScheduleController::class, 'destroy']);
    });

    Route::prefix('/reservations')->group(function () {
        Route::get('/', [AdminReservationController::class, 'index']);
        Route::post('/', [AdminReservationController::class, 'store']);
        Route::get('/create', [AdminReservationController::class, 'create']);
        Route::get('/{reservation}', [AdminReservationController::class, 'show']);
        Route::get('/{reservation}/edit', [AdminReservationController::class, 'show']);
        Route::patch('/{reservation}', [AdminReservationController::class, 'update']);
        Route::delete('/{reservation}', [AdminReservationController::class, 'destroy']);
    });
});

