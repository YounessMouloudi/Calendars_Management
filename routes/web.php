<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendrierController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('events', EventController::class);
    Route::resource('calendriers', CalendrierController::class);
    
    Route::put('events/{id}/update-date', [EventController::class, 'updateDate'])->name("updateDate");

    // Route::post('eventsStore', [EventController::class, 'storeEvent'])->name("storeEvent");
    // Route::put('eventsUpdate/{event}', [EventController::class, 'updateEvent'])->name("updateEvent");
    // Route::delete('eventsDestroy/{event}', [EventController::class, 'destroyEvent'])->name("destroyEvent");
    
    Route::put('calendriers/create', [CalendrierController::class, 'create'])->name("new Calendrier");
});


require __DIR__.'/auth.php';
