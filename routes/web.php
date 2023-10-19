<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('events', EventController::class);

Route::post('events/{event}/participate', [EventController::class, 'participate'])->name('events.participate')->middleware('auth', 'verified');

// Route to show the event update form
Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');

// Route to handle the event update
Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');

// Only verified users can create events
Route::get('events/create', [EventController::class, 'create'])->name('events.create')->middleware('auth', 'verified');

// Seulement les utilisateurs vérifiés peuvent participer aux événements

Route::get('mes-evenements', [EventController::class, 'userEvents'])->name('user.events')->middleware('auth', 'verified');

// Route to participating events
Route::get('participatingEvents', [EventController::class, 'participatingEvents'])->name('user.participatingEvents')->middleware('auth', 'verified');

Auth::routes(['verify' => true]);

// live search route
Route::get('/livesearch', [EventController::class, 'livesearch'])->name('livesearch');



    require __DIR__.'/auth.php';
