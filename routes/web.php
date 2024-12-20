<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChirpController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/** CHIRPS */
Route::resource('chirps', ChirpController::class)
->only([
    'index', // GET chirps, index(), chirps.index
    'store'  // POST chirps, store(), chirps.store
])
->middleware(['auth']);


Route::get('/time', function () {
    $timezones = DateTimeZone::listIdentifiers();
    dd($timezones);
});


Route::get('/get-my-php-info/{password}', function ($password) {
    if( $password == "pleaseuseyoursecuredpasswordhere" )
        dd( phpinfo() );
    else
       abort(403, 'Unauthorized access');
});

Route::get('getmem',function(){
    $memory_limit = ini_get('memory_limit');
    dd( $memory_limit );
});


Route::get('def', function(){
    defer(function(){
        \Log::info('logging!');
    });
});

Route::get('dispatch',function(){
    \Log::info('dispatching job...');
    $job = new \App\Jobs\ProcessPodcast();
    $job->dispatch();
});
require __DIR__.'/auth.php';
