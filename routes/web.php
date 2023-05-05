<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipantTypeController;
use App\Models\Participant;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

// Route::get('/', function () {
//     return view('layouts.frontend.inc.master');
// });

Auth::routes();

// Route::prefix('admin/')->group(function () {
//     Route::get('login', [AuthController::class, 'index'])->name('login');
//     Route::post('custom-login', [AuthController::class, 'customLOgin'])->name('login.custom');


//     Route::get('/register', [AuthController::class, 'registration'])->name('register-user');
//     Route::post('/custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
// });

// Route::get('admin/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

// Route::post('admin/logout', [AuthController::class, 'signOut'])->name('signout')->middleware('auth');

require __DIR__ . '/admin.php';



Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);
Route::get('/home', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);
Route::get('/events/{id}/download/certificates', [App\Http\Controllers\Frontend\FrontendController::class, 'downloadPdf']);


Route::prefix('admin/events')->middleware('auth')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/create', [EventController::class, 'create']);

    Route::get('/trash', [EventController::class, 'trash']);

    Route::post('/', [EventController::class, 'store']);
    Route::get('/{id}/edit', [EventController::class, 'edit']);
    Route::put('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'destroy']);

    Route::get('/{id}/restore', [EventController::class, 'restore']);


    Route::delete('/{id}/force-delete', [EventController::class, 'forceDelete']);
});


Route::prefix('admin/events')->middleware('auth')->group(function () {
    Route::get('/{event_id}/participant-types', [ParticipantTypeController::class, 'index']);
    Route::get('/{event_id}/participant-types/create', [ParticipantTypeController::class, 'create']);
    Route::post('/{event_id}/participant-types', [ParticipantTypeController::class, 'store']);
    Route::get('/{event_id}/participant-types/{id}/edit', [ParticipantTypeController::class, 'edit']);
    Route::put('/{event_id}/participant-types/{id}', [ParticipantTypeController::class, 'update']);
    Route::delete('/{event_id}/participant-types/{id}', [ParticipantTypeController::class, 'destroy']);
});


Route::prefix('admin/events/{event_id}')->middleware('auth')->group(function () {
    Route::get('/participants', [ParticipantController::class, 'index']);

    Route::get('/participants/import', [ParticipantController::class, 'importExcel']);

    Route::post('/participants/upload-excel-file', [ParticipantController::class, 'storeExcel']);

    Route::get('/participants/create', [ParticipantController::class, 'create']);
    Route::post('/participants', [ParticipantController::class, 'store']);
    Route::get('/participants/{id}/edit', [ParticipantController::class, 'edit']);
    Route::put('/participants/{id}', [ParticipantController::class, 'update']);
    Route::delete('/participants/{id}', [ParticipantController::class, 'destory']);
});

Route::get('/admin/events/{id}/participants/import/download-participant-demo', function ($event) {
    $path = storage_path('app/participant-demo/demo.csv');
    return response()->download($path);
});

// Route::get('/admin/events/{id}/participant-types/download-template', function () {
//     $path = storage_path('app/template/template.zip');
//     return response()->download($path);
// });
Route::get('/admin/events/{id}/participant-types/download-template', function () {
    $file = 'template.zip';
    $path = Storage::path($file);

    if (Storage::exists($file)) {
        return response()->download($path, $file);
    } else {
        abort(404);
    }
});


Route::get(
    '/admin/events/{event_id}/participants/{id}/download-pdf',
    [ParticipantController::class, 'generatePdf']
);

Route::get('/admin/participants/{id}/download-pdf', [ParticipantController::class, 'generatePdf']);

Route::get('/manage-site', function () {
    Artisan::call('migrate');
    Artisan::call('db:seed');
    Artisan::call('storage:link');
});
