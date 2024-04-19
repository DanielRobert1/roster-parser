<?php

use App\Http\Controllers\Api\RosterEvent\RosterEventController;
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


Route::prefix('roster')->group(function(){
    Route::get('/', [RosterEventController::class, 'index'])->name('api.roster');
    Route::post('/upload', [RosterEventController::class, 'uploadRoster'])->name('api.roster.upload');
});
