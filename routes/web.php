<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipantTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('layouts.frontend.inc.master');
});


Route::prefix('admin/events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/create', [EventController::class, 'create']);
    Route::post('/', [EventController::class, 'store']);
    Route::get('/{id}/edit', [EventController::class, 'edit']);
    Route::put('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'destroy']);
});


Route::prefix('admin/events')->group(function () {
    Route::get('/{event_id}/participant-types', [ParticipantTypeController::class, 'index']);
    Route::get('/{event_id}/participant-types/create', [ParticipantTypeController::class, 'create']);
    Route::post('/{event_id}/participant-types', [ParticipantTypeController::class, 'store']);
    Route::get('/{event_id}/participant-types/{id}/edit', [ParticipantTypeController::class, 'edit']);
    Route::put('/{event_id}/participant-types/{id}', [ParticipantTypeController::class, 'update']);
    Route::delete('/{event_id}/participant-types/{id}', [ParticipantTypeController::class, 'destroy']);
});


Route::prefix('admin/participants')->group(function () {
    Route::get('/', [ParticipantController::class, 'index']);
    Route::get('/import', [ParticipantController::class, 'importExcel']);
    Route::post('/upload-excel-file', [ParticipantController::class, 'storeExcel']);
    Route::get('/create', [ParticipantController::class, 'create']);
    Route::post('/', [ParticipantController::class, 'store']);
    Route::get('/{id}/edit', [ParticipantController::class, 'edit']);
    Route::put('/{id}', [ParticipantController::class, 'update']);
    Route::delete('/{id}', [ParticipantController::class, 'destory']);
});

Route::get('/admin/participants/{id}/download-pdf', [ParticipantController::class, 'generatePdf']);
