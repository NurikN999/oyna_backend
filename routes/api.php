<?php

use App\Http\Controllers\Api\HospitalityVenueController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\EntertainmentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\PartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('cities')->group(function () {
        Route::get('/', [CityController::class, 'index']);
        Route::get('/{city}', [CityController::class, 'show']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('entertainments')->group(function () {
        Route::post('/', [EntertainmentController::class, 'store']);
        Route::get('/', [EntertainmentController::class, 'index']);
        Route::get('/{entertainment}', [EntertainmentController::class, 'show']);
        Route::patch('/{entertainment}', [EntertainmentController::class, 'update']);
        Route::delete('/{entertainment}', [EntertainmentController::class, 'destroy']);
    });

    Route::prefix('musics')->group(function () {
        Route::get('/genres', [MusicController::class, 'genres']);
        Route::post('/', [MusicController::class, 'store']);
        Route::get('/', [MusicController::class, 'index']);
        Route::get('/{music}', [MusicController::class, 'show']);
        Route::patch('/{music}', [MusicController::class, 'update']);
        Route::delete('/{music}', [MusicController::class, 'destroy']);
    });

    Route::prefix('hospitality-venues')->group(function () {
        Route::post('/', [HospitalityVenueController::class, 'store']);
        Route::get('/types', [HospitalityVenueController::class, 'types']);
        Route::get('/', [HospitalityVenueController::class, 'index']);
        Route::get('/{hospitalityVenue}', [HospitalityVenueController::class, 'show']);
        Route::patch('/{hospitalityVenue}', [HospitalityVenueController::class, 'update']);
        Route::delete('/{hospitalityVenue}', [HospitalityVenueController::class, 'delete']);
    });

    Route::prefix('partners')->group(function () {
        Route::post('/', [PartnerController::class, 'store']);
        Route::get('/', [PartnerController::class, 'index']);
        Route::get('/{partner}', [PartnerController::class, 'show']);
        Route::patch('/{partner}', [PartnerController::class, 'update']);
        Route::delete('/{partner}', [PartnerController::class, 'delete']);
    });

});
