<?php

use App\Http\Controllers\Api\AdvertisingController;
use App\Http\Controllers\Api\HospitalityVenueController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DifferenceController;
use App\Http\Controllers\Api\EntertainmentController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PrizeController;
use App\Http\Controllers\Api\QuizQuestionController;
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
Route::prefix('cities')->group(function () {
    Route::get('/', [CityController::class, 'index']);
    Route::get('/{city}', [CityController::class, 'show']);
});
Route::prefix('entertainments')->group(function () {
    Route::get('/', [EntertainmentController::class, 'index']);
    Route::get('/types', [EntertainmentController::class, 'types']);
    Route::get('/{entertainment}', [EntertainmentController::class, 'show']);
});
Route::prefix('musics')->group(function () {
    Route::get('/genres', [MusicController::class, 'genres']);
    Route::get('/', [MusicController::class, 'index']);
    Route::get('/{music}', [MusicController::class, 'show']);
});
Route::prefix('hospitality-venues')->group(function () {
    Route::get('/types', [HospitalityVenueController::class, 'types']);
    Route::get('/', [HospitalityVenueController::class, 'index']);
    Route::get('/{hospitalityVenue}', [HospitalityVenueController::class, 'show']);
    Route::get('/{hospitalityVenue}/qr-code', [HospitalityVenueController::class, 'showQrCode']);
});
Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
    Route::get('/{banner}', [BannerController::class, 'show']);
});
Route::prefix('partners')->group(function () {
    Route::get('/', [PartnerController::class, 'index']);
    Route::get('/{partner}', [PartnerController::class, 'show']);
});
Route::prefix('offers')->group(function () {
    Route::get('/', [OfferController::class, 'index']);
    Route::get('/{offer}', [OfferController::class, 'show']);
});
Route::prefix('prizes')->group(function () {
    Route::get('/', [PrizeController::class, 'index']);
    Route::get('/{prize}', [PrizeController::class, 'show']);
});
Route::prefix('advertisings')->group(function () {
    Route::get('/', [AdvertisingController::class, 'index']);
    Route::get('/{advertising}', [AdvertisingController::class, 'show']);
});
Route::prefix('games')->group(function () {
    Route::get('/', [GameController::class, 'index']);
    Route::get('/{game}', [GameController::class, 'show']);
});

Route::prefix('quiz-questions')->group(function () {
    Route::get('/', [QuizQuestionController::class, 'index']);
    Route::get('/{quizQuestion}', [QuizQuestionController::class, 'show']);
});

Route::prefix('differences')->group(function () {
    Route::get('/', [DifferenceController::class, 'index']);
    Route::get('/{difference}', [DifferenceController::class, 'show']);
});

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('entertainments')->group(function () {
        Route::post('/', [EntertainmentController::class, 'store']);
        Route::patch('/{entertainment}', [EntertainmentController::class, 'update']);
        Route::delete('/{entertainment}', [EntertainmentController::class, 'destroy']);
    });

    Route::prefix('musics')->group(function () {
        Route::post('/', [MusicController::class, 'store']);
        Route::patch('/{music}', [MusicController::class, 'update']);
        Route::delete('/{music}', [MusicController::class, 'destroy']);
    });

    Route::prefix('hospitality-venues')->group(function () {
        Route::post('/', [HospitalityVenueController::class, 'store']);
        Route::patch('/{hospitalityVenue}', [HospitalityVenueController::class, 'update']);
        Route::delete('/{hospitalityVenue}', [HospitalityVenueController::class, 'delete']);
    });

    Route::prefix('partners')->group(function () {
        Route::post('/', [PartnerController::class, 'store']);
        Route::patch('/{partner}', [PartnerController::class, 'update']);
        Route::delete('/{partner}', [PartnerController::class, 'delete']);
    });

    Route::prefix('offers')->group(function () {
        Route::post('/', [OfferController::class, 'store']);
        Route::patch('/{offer}', [OfferController::class, 'update']);
        Route::delete('/{offer}', [OfferController::class, 'destroy']);
    });

    Route::prefix('prizes')->group(function () {
        Route::post('/', [PrizeController::class, 'store']);
        Route::patch('/{prize}', [PrizeController::class, 'update']);
        Route::delete('/{prize}', [PrizeController::class, 'destroy']);
    });

    Route::prefix('advertisings')->group(function () {
        Route::post('/', [AdvertisingController::class, 'store']);
        Route::patch('/{advertising}', [AdvertisingController::class, 'update']);
        Route::delete('/{advertising}', [AdvertisingController::class, 'destroy']);
    });

    Route::prefix('quiz-questions')->group(function () {
        Route::post('/', [QuizQuestionController::class, 'store']);
        Route::patch('/{quizQuestion}', [QuizQuestionController::class, 'update']);
        Route::delete('/{quizQuestion}', [QuizQuestionController::class, 'destroy']);
    });

    Route::prefix('differences')->group(function () {
        Route::post('/', [DifferenceController::class, 'store']);
        Route::patch('/{difference}', [DifferenceController::class, 'update']);
        Route::delete('/{difference}', [DifferenceController::class, 'destroy']);
    });

    Route::prefix('banneres')->group(function () {
        Route::post('/', [BannerController::class, 'store']);
        Route::patch('/{banner}', [BannerController::class, 'update']);
        Route::delete('/{banner}', [BannerController::class, 'destroy']);
    });

});
